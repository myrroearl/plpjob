import sys
import pandas as pd
import numpy as np
import mysql.connector
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
import mysql.connector

# Suppress all warnings
warnings.filterwarnings("ignore")


def generate_unique_filename(extension="txt"):
    unique_id = uuid.uuid4()  # Generate a unique ID
    return f"{unique_id}.{extension}"

csv_path = sys.argv[2] 
# Read and preprocess the data
df = pd.read_csv(csv_path)

# Prepare features for Employment Rate prediction
feature_columns = ['CGPA', 'Average Prof Grade', 'Average Elec Grade', 'OJT Grade', 
                  'Leadership POS', 'Act Member POS', 'Soft Skills Ave', 'Hard Skills Ave']
X = df[feature_columns].copy()

# Convert Yes/No to 1/0 for binary columns
X['Leadership POS'] = (X['Leadership POS'] == 'Yes').astype(int)
X['Act Member POS'] = (X['Act Member POS'] == 'Yes').astype(int)

# Create initial employment rate predictions using Linear Regression
lr_model_initial = LinearRegression()
lr_model_initial.fit(X, df['Employability'].map({'Employable': 1, 'Not Employable': 0}))  # Convert target to binary
initial_employment_rate = lr_model_initial.predict(X)

# Add predicted Employment Rate to dataframe
df['Employment Rate'] = initial_employment_rate * 100  # Convert to percentage

# Create time series by graduation year
df['Year Graduated'] = pd.to_datetime(df['Year Graduated'], format='%Y')
yearly_data = df.groupby('Year Graduated')['Employment Rate'].mean()

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

    plt.tight_layout()

    # Correct the path for saving figures
    # Create figures directory if it doesn't exist
    figures_path = sys.argv[1]
    

    # Update the plot saving paths
    employment_rate_line_id = uuid.uuid4()
    plt.savefig(f"{figures_path}/{employment_rate_line_id}.png")
    

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
    
    # Add value labels for forecast
    for year, value in zip(forecast_dates.year, forecast_mean.values):
        plt.annotate(f'{value:.1f}', 
                    (year, value),
                    textcoords="offset points", 
                    xytext=(0,10), 
                    ha='center',
                    color='green')

    plt.tight_layout()
    employment_rate_comparison_id = uuid.uuid4()
    plt.savefig(f"{figures_path}/{employment_rate_comparison_id}.png")
   

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
    
    # Plot residual diagnostics
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
    from scipy import stats
    stats.probplot(residuals, dist="norm", plot=ax3)
    ax3.set_title('Q-Q Plot')
    
    # Autocorrelation plot
    from statsmodels.graphics.tsaplots import plot_acf
    plot_acf(residuals, ax=ax4, lags=10)
    ax4.set_title('Autocorrelation Plot')
    
    plt.tight_layout()
   

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
        for year, value in zip(ts.index.year, ts.values):
            plt.annotate(f'{value:.1f}', 
                        (year, value), 
                        textcoords="offset points", 
                        xytext=(0,10), 
                        ha='center')
        
        for year, value in zip(forecast_years.year, lr_results['forecast']):
            plt.annotate(f'{value:.1f}', 
                        (year, value),
                        textcoords="offset points", 
                        xytext=(0,10), 
                        ha='center',
                        color='green')
        
        plt.tight_layout()
        employment_rate_comparison_id = uuid.uuid4()
        plt.savefig(f"{figures_path}/{employment_rate_comparison_id}.png")

        conn = mysql.connector.connect(
            host='127.0.0.1',
            user='root',
            password='',
            database='plpalumnijobportal_db'
        )
        cursor = conn.cursor()
        
        # Update the database values with Linear Regression results if it's better
        if 'conn' in locals():
            try:
                cursor.execute("""
                    UPDATE alumni_prediction_models 
                    SET 
                        prediction_accuracy = %s,
                        rmse = %s,
                        mae = %s,
                        r2 = %s,
                        predicted_rate = %s,
                        model_type = 'Linear Regression'
                    WHERE id = (SELECT MAX(id) FROM alumni_prediction_models)
                """, (
                    (1 - lr_results['metrics']['mape']/100) * 100,  # prediction_accuracy
                    lr_results['metrics']['rmse'],
                    lr_results['metrics']['mae'],
                    lr_results['metrics']['r2'],
                    lr_results['predictions'][-1]
                ))
                conn.commit()
            except Exception as e:
                print(f"Database error while updating Linear Regression results: {e}")
                if conn:
                    conn.rollback()

except Exception as e:
    print(f"An error occurred: {e}")




# Connect to the MySQL database
try:
    conn = mysql.connector.connect(
        host='127.0.0.1',
        user='root',
        password='',
        database='plpalumnijobportal_db'
    )
    cursor = conn.cursor()

    # Update the table name to match our Laravel migration
    cursor.execute("""
        UPDATE alumni_prediction_models 
        SET 
            total_alumni = %s,
            prediction_accuracy = %s,
            employment_rate_forecast_line_image = %s,
            rmse = %s,
            mae = %s,
            r2 = %s,
            aic = %s,
            confidence_interval = %s,
            actual_rate = %s,
            predicted_rate = %s,
            margin_of_error = %s,
            employment_rate_comparison_image = %s,
            predicted_employability_by_degree_image = %s,
            distribution_of_predicted_employment_rates_image = %s
        WHERE id = (SELECT MAX(id) FROM alumni_prediction_models)
    """, (
        len(df),  # total_alumni
        yearly_comparison['Accuracy'].mean(),  # prediction_accuracy
        str(employment_rate_line_id) + '.png',  # employment_rate_forecast_line_image
        rmse,  # rmse
        mae,  # mae
        r2,  # r2
        aic,  # aic
        conf_int.iloc[-1, 1] - conf_int.iloc[-1, 0],  # confidence_interval
        yearly_comparison['Actual'].iloc[-1],  # actual_rate
        yearly_comparison['Predicted'].iloc[-1],  # predicted_rate
        abs(yearly_comparison['Actual'].iloc[-1] - yearly_comparison['Predicted'].iloc[-1]),  # margin_of_error
        str(employment_rate_comparison_id) + '.png',  # employment_rate_comparison_image
        '',  # predicted_employability_by_degree_image (placeholder)
        ''   # distribution_of_predicted_employment_rates_image (placeholder)
    ))

    conn.commit()

except Exception as e:
    print(f"Database error: {e}")
    if conn:
        conn.rollback()
finally:
    if cursor:
        cursor.close()
    if conn:
        conn.close()
