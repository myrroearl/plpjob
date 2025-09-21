import sys
import pandas as pd
import numpy as np
import requests
import json
from statsmodels.tsa.stattools import adfuller
from statsmodels.tsa.arima.model import ARIMA
from statsmodels.tsa.seasonal import seasonal_decompose
from pmdarima import auto_arima
import matplotlib.pyplot as plt
import seaborn as sns
from sklearn.model_selection import TimeSeriesSplit
from sklearn.metrics import mean_squared_error
from sklearn.preprocessing import StandardScaler
from sklearn.ensemble import RandomForestClassifier
from sklearn.model_selection import train_test_split
import statsmodels.api as sm
import uuid
import json
import os
import warnings
from sklearn.linear_model import LinearRegression
from sklearn.metrics import r2_score, mean_squared_error, mean_absolute_error
import tempfile
from supabase import create_client, Client
import io

# Suppress all warnings
warnings.filterwarnings("ignore")

# Set matplotlib to use non-interactive backend
plt.switch_backend('Agg')

def generate_unique_filename(extension="png"):
    unique_id = uuid.uuid4()  # Generate a unique ID
    return f"{unique_id}.{extension}"

# Get temporary directory for saving files
temp_dir = tempfile.gettempdir()
# Handle command line arguments
if len(sys.argv) < 2:
    print("Error: CSV filename is required")
    sys.exit(1)

csv_filename = sys.argv[1]

# Supabase configuration
SUPABASE_URL = "https://cawdbumigiwafukejndb.supabase.co"
SUPABASE_KEY = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImNhd2RidW1pZ2l3YWZ1a2VqbmRiIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTM4MzY5NDYsImV4cCI6MjA2OTQxMjk0Nn0.R0twY6a16flkMAMdh6kndykvNRIG5d2FGlOpqoxQL20"
BUCKET_NAME = "adminfiles"

# Supabase database functions
def update_supabase_record(data):
    """Update the latest alumni_prediction_models record in Supabase"""
    try:
        print(f"Attempting to update Supabase record with data: {data}")
        
        # Convert any numpy/pandas types to native Python types
        clean_data = {}
        for key, value in data.items():
            if hasattr(value, 'item'):  # numpy scalar
                clean_data[key] = value.item()
            elif hasattr(value, '__float__'):  # pandas scalar
                clean_data[key] = float(value)
            else:
                clean_data[key] = value
            
            # Convert specific fields to integers for Supabase
            if key in ['total_alumni'] and isinstance(clean_data[key], (int, float)):
                clean_data[key] = int(clean_data[key])
            # Convert other numeric fields to float
            elif key in ['prediction_accuracy', 'rmse', 'mae', 'r2', 'aic', 'confidence_interval', 'actual_rate', 'predicted_rate', 'margin_of_error'] and isinstance(clean_data[key], (int, float)):
                clean_data[key] = float(clean_data[key])
        
        print(f"Cleaned data for update: {clean_data}")
        
        # Get the latest record ID first
        response = supabase.table("alumni_prediction_models").select("id").order("id", desc=True).limit(1).execute()
        
        if not response.data:
            print("No records found to update")
            return False
            
        latest_id = response.data[0]['id']
        print(f"Updating record with ID: {latest_id}")
        
        # Update the record using simple Supabase syntax
        update_response = supabase.table("alumni_prediction_models").update(clean_data).eq("id", latest_id).execute()
        
        print(f"Update response: {update_response}")
        print(f"Successfully updated record {latest_id}")
        return True
            
    except Exception as e:
        print(f"Error updating Supabase record: {e}")
        import traceback
        print(f"Full traceback: {traceback.format_exc()}")
        return False

# Initialize Supabase client
try:
    supabase: Client = create_client(SUPABASE_URL, SUPABASE_KEY)
    print(f"Supabase client initialized successfully")
except Exception as e:
    print(f"Error initializing Supabase client: {e}")
    sys.exit(1)

# Read CSV data directly from Supabase
try:
    print(f"Reading CSV file: {csv_filename} from Supabase bucket: {BUCKET_NAME}")
    
    # Download file from Supabase Storage
    response = supabase.storage.from_(BUCKET_NAME).download(csv_filename)
    
    if response is None:
        raise Exception("No response from Supabase")
    
    print(f"Successfully retrieved file from Supabase")
    print(f"Response type: {type(response)}")
    print(f"Response length: {len(response) if hasattr(response, '__len__') else 'N/A'}")
    
    # Read CSV directly from memory using StringIO
    csv_content = response.decode('utf-8')
    
    # Force manual parsing since standard CSV parsing is not working correctly
    print("Using manual parsing for CSV...")
    
    # Manual parsing approach - handle escaped newlines
    csv_content = csv_content.replace('\\n', '\n')
    lines = csv_content.strip().split('\n')
    if len(lines) > 1:
        # Get header
        header = lines[0].split(',')
        # Get data rows
        data_rows = []
        for line in lines[1:]:
            if line.strip():
                data_rows.append(line.split(','))
        
        # Create DataFrame
        df = pd.DataFrame(data_rows, columns=header)
        print(f"Successfully loaded CSV file with manual parsing")
        print(f"Data shape: {df.shape}")
        print(f"Columns: {list(df.columns)}")
        print(f"First few rows:")
        print(df.head())
    else:
        raise Exception("No data rows found")
    
except Exception as e:
    print(f"Error reading CSV file from Supabase: {e}")
    print(f"Error type: {type(e).__name__}")
    import traceback
    print(f"Full traceback: {traceback.format_exc()}")
    sys.exit(1)

# Prepare features for Employment Rate prediction
feature_columns = ['CGPA', 'Average Prof Grade', 'Average Elec Grade', 'OJT Grade', 
                  'Leadership POS', 'Act Member POS', 'Soft Skills Ave', 'Hard Skills Ave']

# Check if all required columns exist
missing_columns = [col for col in feature_columns if col not in df.columns]
if missing_columns:
    print(f"Missing columns: {missing_columns}")
    print(f"Available columns: {list(df.columns)}")
    print("Please ensure your CSV file contains all required columns:")
    for col in feature_columns:
        print(f"  - {col}")
    sys.exit(1)

print(f"Using feature columns: {feature_columns}")
X = df[feature_columns].copy()

# Clean the data - remove any rows with NaN values
print(f"Original data shape: {X.shape}")
X = X.dropna()
print(f"Data shape after removing NaN values: {X.shape}")

# Convert Yes/No to 1/0 for binary columns
X['Leadership POS'] = (X['Leadership POS'] == 'Yes').astype(int)
X['Act Member POS'] = (X['Act Member POS'] == 'Yes').astype(int)

# Check if Employability column exists
if 'Employability' not in df.columns:
    print(f"Missing 'Employability' column")
    print(f"Available columns: {list(df.columns)}")
    sys.exit(1)

# Clean the target variable as well - remove rows where target is NaN
y = df['Employability'].map({'Employable': 1, 'Less Employable': 0})
print(f"Original target shape: {y.shape}")
y = y.dropna()
print(f"Target shape after removing NaN values: {y.shape}")

# Align X and y indices
common_index = X.index.intersection(y.index)
X = X.loc[common_index]
y = y.loc[common_index]
print(f"Final aligned data shape: X={X.shape}, y={y.shape}")

# Create initial employment rate predictions using Linear Regression
lr_model_initial = LinearRegression()
lr_model_initial.fit(X, y)  # Convert target to binary
initial_employment_rate = lr_model_initial.predict(X)

# Create a cleaned DataFrame for all operations
df_clean = df.loc[common_index].copy()
df_clean['Employment Rate'] = initial_employment_rate * 100  # Convert to percentage

# Check if Year Graduated column exists
if 'Year Graduated' not in df_clean.columns:
    print(f"Missing 'Year Graduated' column")
    print(f"Available columns: {list(df_clean.columns)}")
    sys.exit(1)

# Create time series by graduation year
df_clean['Year Graduated'] = pd.to_datetime(df_clean['Year Graduated'], format='%Y')
yearly_data = df_clean.groupby('Year Graduated')['Employment Rate'].mean()

# Convert to time series
ts = pd.Series(yearly_data.values, index=yearly_data.index)

# Linear Regression Model
def create_linear_regression_model(ts):
    # Prepare data for linear regression
    X = np.arange(len(ts)).reshape(-1, 1)
    y = ts.values
    
    # Create and fit the model
    lr_model = LinearRegression()
    lr_model.fit(X, y)
    
    # Make predictions
    lr_predictions = lr_model.predict(X)
    
    # Forecast next 3 years
    future_X = np.arange(len(ts), len(ts) + 3).reshape(-1, 1)
    lr_forecast = lr_model.predict(future_X)
    
    # Calculate metrics
    lr_mse = mean_squared_error(y, lr_predictions)
    lr_rmse = np.sqrt(lr_mse)
    lr_mae = mean_absolute_error(y, lr_predictions)
    lr_r2 = r2_score(y, lr_predictions)
    lr_mape = np.mean(np.abs((y - lr_predictions) / y)) * 100
    
    return {
        'predictions': lr_predictions,
        'forecast': lr_forecast,
        'metrics': {
            'mse': lr_mse,
            'rmse': lr_rmse,
            'mae': lr_mae,
            'r2': lr_r2,
            'mape': lr_mape
        }
    }

# Add this code before the try block
lr_results = create_linear_regression_model(ts)

# Fit ARIMA model
try:
    # Find best parameters
    auto_model = auto_arima(ts,
                           start_p=1, max_p=5,
                           start_q=1, max_q=5,
                           m=12,
                           seasonal=False,  # Changed to False for yearly data
                           d=1,  # First difference
                           trace=True,
                           error_action='ignore',
                           suppress_warnings=True)
    
    # Get best parameters and fit final model
    order = auto_model.order
    final_model = ARIMA(ts, order=order)
    results = final_model.fit()
    
    # Get predictions
    predictions = results.predict(start=1)
    
    # Create comparison dataframe
    yearly_comparison = pd.DataFrame({
        'Actual': ts,
        'Predicted': predictions
    })
    
    # Create the plot
    plt.figure(figsize=(15, 8))
    plt.plot(yearly_comparison.index.year, yearly_comparison['Actual'], 
             marker='o', linewidth=2, label='Actual', color='blue')
    plt.plot(yearly_comparison.index.year, yearly_comparison['Predicted'], 
             marker='s', linewidth=2, label='Predicted', color='red', linestyle='--')

    plt.title('Average Employment Rate: Actual vs Predicted by Graduation Year', fontsize=14)
    plt.xlabel('Graduation Year', fontsize=12)
    plt.ylabel('Employment Rate (%)', fontsize=12)
    plt.grid(True, linestyle='--', alpha=0.7)
    plt.legend(fontsize=12)

    # Add value labels
    try:
        for year, row in yearly_comparison.iterrows():
            plt.annotate(f'{row["Actual"]:.1f}', 
                        (year.year, row["Actual"]), 
                        textcoords="offset points", 
                        xytext=(0,10), 
                        ha='center')
            plt.annotate(f'{row["Predicted"]:.1f}', 
                        (year.year, row["Predicted"]), 
                        textcoords="offset points", 
                        xytext=(0,-15), 
                        ha='center')
    except Exception as e:
        print(f"Warning: Could not add value labels: {e}")

    plt.tight_layout()

    # Save to BytesIO and upload to Supabase (with error checking)
    buf1 = io.BytesIO()
    plt.savefig(buf1, format='png')
    plt.close()
    filename1 = 'employment_rate_forecast_line.png'
    
    # Try to delete the file first (ignore errors if it doesn't exist)
    try:
        supabase.storage.from_(BUCKET_NAME).remove(filename1)
    except Exception as e:
        print(f"Warning: Could not delete {filename1} before upload: {e}")

    # Now upload
    try:
        response1 = supabase.storage.from_(BUCKET_NAME).upload(
            filename1, buf1.getvalue(),
            file_options={"content-type": "image/png"}
        )
        print(f"Upload response for {filename1}: {response1}")
    except Exception as e:
        print(f"Exception during upload for {filename1}: {e}")
    public_url1 = f"{SUPABASE_URL}/storage/v1/object/public/{BUCKET_NAME}/{filename1}"
    print(f"PUBLIC_URL:{filename1}:{public_url1}")


    # Print yearly statistics
    print("\nYearly Employment Rate Statistics:")
    print(yearly_comparison.round(2))

    # Calculate yearly accuracy
    yearly_comparison['Accuracy'] = (1 - abs(yearly_comparison['Actual'] - yearly_comparison['Predicted']) / yearly_comparison['Actual']) * 100
    print("\nYearly Prediction Accuracy:")
    print(yearly_comparison['Accuracy'].round(2))

    # Get predictions and forecasts
    predictions = results.predict(start=0)
    forecast_steps = 3
    forecast = results.get_forecast(steps=forecast_steps)
    forecast_mean = forecast.predicted_mean
    conf_int = forecast.conf_int()
    
    # Create forecast dates
    last_date = ts.index[-1]
    forecast_dates = pd.date_range(start=last_date + pd.DateOffset(years=1), 
                                 periods=forecast_steps, 
                                 freq='Y')
    
    # Create the plot
    plt.figure(figsize=(15, 8))
    
    # Plot actual data
    plt.plot(yearly_comparison.index.year, yearly_comparison['Actual'], 
             marker='o', linewidth=2, label='Actual', color='blue')
    
    # Plot predictions
    plt.plot(yearly_comparison.index.year, yearly_comparison['Predicted'], 
             marker='s', linewidth=2, label='Predicted', color='red', linestyle='--')
    
    # Plot forecast
    plt.plot(forecast_dates.year, forecast_mean.values, 
             marker='^', linewidth=2, label='Forecast', color='green', linestyle=':')
    
    # Plot confidence intervals for forecast
    plt.fill_between(forecast_dates.year,
                    conf_int.iloc[:, 0],
                    conf_int.iloc[:, 1],
                    color='green', alpha=0.1,
                    label='95% Confidence Interval')

    plt.title('Employment Rate: Actual, Predicted, and Future Forecast', fontsize=14)
    plt.xlabel('Graduation Year', fontsize=12)
    plt.ylabel('Employment Rate (%)', fontsize=12)
    plt.grid(True, linestyle='--', alpha=0.7)
    plt.legend(fontsize=12)

    # Add value labels for actual and predicted
    try:
        for year, row in yearly_comparison.iterrows():
            plt.annotate(f'{row["Actual"]:.1f}', 
                        (year.year, row["Actual"]), 
                        textcoords="offset points", 
                        xytext=(0,10), 
                        ha='center')
            plt.annotate(f'{row["Predicted"]:.1f}', 
                        (year.year, row["Predicted"]), 
                        textcoords="offset points", 
                        xytext=(0,-15), 
                        ha='center')
    except Exception as e:
        print(f"Warning: Could not add value labels for actual/predicted: {e}")
    
    # Add value labels for forecast
    try:
        for year, value in zip(forecast_dates.year, forecast_mean.values):
            plt.annotate(f'{value:.1f}', 
                        (year, value),
                        textcoords="offset points", 
                        xytext=(0,10), 
                        ha='center',
                        color='green')
    except Exception as e:
        print(f"Warning: Could not add value labels for forecast: {e}")

    plt.tight_layout()

    # Save to BytesIO and upload to Supabase (with error checking)
    buf2 = io.BytesIO()
    plt.savefig(buf2, format='png')
    plt.close()
    filename2 = 'employment_rate_comparison.png'
    
    # Try to delete the file first (ignore errors if it doesn't exist)
    try:
        supabase.storage.from_(BUCKET_NAME).remove(filename2)
    except Exception as e:
        print(f"Warning: Could not delete {filename2} before upload: {e}")

    # Now upload
    try:
        response2 = supabase.storage.from_(BUCKET_NAME).upload(
            filename2, buf2.getvalue(),
            file_options={"content-type": "image/png"}
        )
        print(f"Upload response for {filename2}: {response2}")
    except Exception as e:
        print(f"Exception during upload for {filename2}: {e}")
    public_url2 = f"{SUPABASE_URL}/storage/v1/object/public/{BUCKET_NAME}/{filename2}"
    print(f"PUBLIC_URL:{filename2}:{public_url2}")
   

    # Print forecast values
    print("\nForecast for next 3 years:")
    forecast_df = pd.DataFrame({
        'Year': forecast_dates.year,
        'Forecast': forecast_mean.values.round(2),
        'Lower CI': conf_int.iloc[:, 0].round(2),
        'Upper CI': conf_int.iloc[:, 1].round(2)
    })
    print(forecast_df)

    # Get predictions for the entire dataset
    predictions = results.predict(start=0)
    
    # Calculate performance metrics
    from sklearn.metrics import mean_squared_error, mean_absolute_error, r2_score
    import numpy as np
    
    # Basic metrics
    mse = mean_squared_error(ts, predictions)
    rmse = np.sqrt(mse)
    mae = mean_absolute_error(ts, predictions)
    r2 = r2_score(ts, predictions)
    
    # Calculate MAPE (Mean Absolute Percentage Error)
    mape = np.mean(np.abs((ts - predictions) / ts)) * 100
    
    # Calculate adjusted R-squared
    n = len(ts)
    p = sum(order)  # number of parameters in the model
    adjusted_r2 = 1 - (1 - r2) * (n - 1) / (n - p - 1)
    
    # AIC and BIC
    aic = results.aic
    bic = results.bic
    
    # Print all metrics
    print("\nModel Performance Metrics:")
    print("=" * 50)
    print(f"Mean Squared Error (MSE): {mse:.4f}")
    print(f"Root Mean Squared Error (RMSE): {rmse:.4f}")
    print(f"Mean Absolute Error (MAE): {mae:.4f}")
    print(f"Mean Absolute Percentage Error (MAPE): {mape:.2f}%")
    print(f"R-squared (R²): {r2:.4f}")
    print(f"Adjusted R-squared: {adjusted_r2:.4f}")
    print(f"Akaike Information Criterion (AIC): {aic:.4f}")
    print(f"Bayesian Information Criterion (BIC): {bic:.4f}")
    print("=" * 50)
    
    # Model parameters
    print("\nModel Parameters:")
    print("=" * 50)
    print(f"ARIMA Order (p,d,q): {order}")
    print("\nModel Summary:")
    print(results.summary())
    
    # Residual analysis
    residuals = ts - predictions
    
    # Plot residual diagnostics with error handling
    try:
        fig, ((ax1, ax2), (ax3, ax4)) = plt.subplots(2, 2, figsize=(15, 10))
        
        # Residuals over time
        ax1.plot(ts.index, residuals)
        ax1.set_title('Residuals over Time')
        ax1.set_xlabel('Year')
        ax1.set_ylabel('Residual')
        ax1.grid(True)
        
        # Residual histogram
        ax2.hist(residuals, bins=20, density=True)
        ax2.set_title('Residual Distribution')
        ax2.set_xlabel('Residual')
        ax2.set_ylabel('Density')
        
        # Q-Q plot
        try:
            from scipy import stats
            stats.probplot(residuals, dist="norm", plot=ax3)
            ax3.set_title('Q-Q Plot')
        except Exception as e:
            print(f"Warning: Could not create Q-Q plot: {e}")
            ax3.text(0.5, 0.5, 'Q-Q Plot\nNot Available', ha='center', va='center', transform=ax3.transAxes)
        
        # Autocorrelation plot
        try:
            from statsmodels.graphics.tsaplots import plot_acf
            # Ensure residuals has enough data points
            if len(residuals) > 10:
                plot_acf(residuals, ax=ax4, lags=min(10, len(residuals)-1))
            else:
                ax4.text(0.5, 0.5, 'Autocorrelation Plot\nNot Enough Data', ha='center', va='center', transform=ax4.transAxes)
            ax4.set_title('Autocorrelation Plot')
        except Exception as e:
            print(f"Warning: Could not create autocorrelation plot: {e}")
            ax4.text(0.5, 0.5, 'Autocorrelation Plot\nNot Available', ha='center', va='center', transform=ax4.transAxes)
        
        plt.tight_layout()
        
    except Exception as e:
        print(f"Warning: Could not create residual diagnostics plots: {e}")
        plt.close('all')  # Close any open plots
   

    # Inside the try block, after ARIMA metrics calculation, add:
    print("\nModel Comparison:")
    print("=" * 50)
    print("ARIMA Metrics:")
    print(f"RMSE: {rmse:.4f}")
    print(f"MAE: {mae:.4f}")
    print(f"R²: {r2:.4f}")
    print(f"MAPE: {mape:.2f}%")

    print("\nLinear Regression Metrics:")
    print(f"RMSE: {lr_results['metrics']['rmse']:.4f}")
    print(f"MAE: {lr_results['metrics']['mae']:.4f}")
    print(f"R²: {lr_results['metrics']['r2']:.4f}")
    print(f"MAPE: {lr_results['metrics']['mape']:.2f}%")

    # Determine the better model based on RMSE
    better_model = 'ARIMA' if rmse < lr_results['metrics']['rmse'] else 'Linear Regression'
    print(f"\nBetter Model Based on RMSE: {better_model}")

    # Only save the forecasting figures for the better model
    if better_model == 'Linear Regression':
        # Create and save Linear Regression forecast plot
        plt.figure(figsize=(15, 8))
        plt.plot(ts.index.year, ts.values, 
                 marker='o', linewidth=2, label='Actual', color='blue')
        plt.plot(ts.index.year, lr_results['predictions'], 
                 marker='s', linewidth=2, label='Predicted', color='red', linestyle='--')
        
        # Plot forecast
        forecast_years = pd.date_range(start=ts.index[-1] + pd.DateOffset(years=1), 
                                     periods=3, 
                                     freq='Y')
        plt.plot(forecast_years.year, lr_results['forecast'], 
                 marker='^', linewidth=2, label='Forecast', color='green', linestyle=':')
        
        plt.title('Employment Rate: Linear Regression Forecast', fontsize=14)
        plt.xlabel('Graduation Year', fontsize=12)
        plt.ylabel('Employment Rate (%)', fontsize=12)
        plt.grid(True, linestyle='--', alpha=0.7)
        plt.legend(fontsize=12)
        
        # Add value labels
        try:
            for year, value in zip(ts.index.year, ts.values):
                plt.annotate(f'{value:.1f}', 
                            (year, value), 
                            textcoords="offset points", 
                            xytext=(0,10), 
                            ha='center')
        except Exception as e:
            print(f"Warning: Could not add value labels for time series: {e}")
        
        try:
            for year, value in zip(forecast_years.year, lr_results['forecast']):
                plt.annotate(f'{value:.1f}', 
                            (year, value),
                            textcoords="offset points", 
                            xytext=(0,10), 
                            ha='center',
                            color='green')
        except Exception as e:
            print(f"Warning: Could not add value labels for linear regression forecast: {e}")
        
        plt.tight_layout()

        # Save to BytesIO and upload to Supabase (with error checking)
        buf3 = io.BytesIO()
        plt.savefig(buf3, format='png')
        plt.close()
        filename3 = 'linear_regression_comparison.png'
        
        # Try to delete the file first (ignore errors if it doesn't exist)
        try:
            supabase.storage.from_(BUCKET_NAME).remove(filename3)
        except Exception as e:
            print(f"Warning: Could not delete {filename3} before upload: {e}")

        # Now upload
        try:
            response3 = supabase.storage.from_(BUCKET_NAME).upload(
                filename3, buf3.getvalue(),
                file_options={"content-type": "image/png"}
            )
            print(f"Upload response for {filename3}: {response3}")
        except Exception as e:
            print(f"Exception during upload for {filename3}: {e}")
        public_url3 = f"{SUPABASE_URL}/storage/v1/object/public/{BUCKET_NAME}/{filename3}"
        print(f"PUBLIC_URL:{filename3}:{public_url3}")

        # Update Supabase database with final results (single update)
        try:
            # Use the better model's metrics
            if better_model == 'Linear Regression':
                final_metrics = lr_results['metrics']
                model_type = 'Linear Regression'
                predicted_rate = lr_results['predictions'][-1]
            else:
                final_metrics = {
                    'rmse': rmse,
                    'mae': mae,
                    'r2': r2,
                    'mape': mape
                }
                model_type = 'ARIMA'
                predicted_rate = yearly_comparison['Predicted'].iloc[-1]
            
            update_data = {
                'total_alumni': int(len(df_clean)),
                'prediction_accuracy': float(yearly_comparison['Accuracy'].mean()),
                'employment_rate_forecast_line_image': filename1,
                'employment_rate_comparison_image': filename2,
                'predicted_employability_by_degree_image': '',
                'distribution_of_predicted_employment_rates_image': '',
                'rmse': float(final_metrics['rmse']),
                'mae': float(final_metrics['mae']),
                'r2': float(final_metrics['r2']),
                'aic': float(aic),
                'confidence_interval': float(conf_int.iloc[-1, 1] - conf_int.iloc[-1, 0]),
                'actual_rate': float(yearly_comparison['Actual'].iloc[-1]),
                'predicted_rate': float(predicted_rate),
                'margin_of_error': float(abs(yearly_comparison['Actual'].iloc[-1] - predicted_rate)),
                'model_type': model_type
            }
            
            update_supabase_record(update_data)
            print("Successfully updated Supabase database with final results")

        except Exception as e:
            print(f"Error updating Supabase database: {e}")

except Exception as e:
    print(f"An error occurred: {e}")
    # Try to update with basic data even if processing failed
    try:
        basic_update_data = {
            'total_alumni': int(len(df_clean) if 'df_clean' in locals() else 0),
            'prediction_accuracy': 0.0,
            'employment_rate_forecast_line_image': '',
            'rmse': 0.0,
            'mae': 0.0,
            'r2': 0.0,
            'aic': 0.0,
            'confidence_interval': 0.0,
            'actual_rate': 0.0,
            'predicted_rate': 0.0,
            'margin_of_error': 0.0,
            'employment_rate_comparison_image': '',
            'predicted_employability_by_degree_image': '',
            'distribution_of_predicted_employment_rates_image': ''
        }
        
        update_supabase_record(basic_update_data)
        print("Updated Supabase with basic data due to processing error")
    except Exception as update_error:
        print(f"Failed to update Supabase even with basic data: {update_error}")
