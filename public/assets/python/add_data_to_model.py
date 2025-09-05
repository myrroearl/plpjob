import sys
import pandas as pd
import numpy as np
import requests
import json
import tempfile
import os
from supabase import create_client, Client
import io
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
from sklearn.linear_model import LinearRegression
from sklearn.metrics import r2_score, mean_squared_error, mean_absolute_error

# Suppress all warnings
import warnings
warnings.filterwarnings("ignore")

# Set matplotlib to use non-interactive backend
plt.switch_backend('Agg')

# Handle command line arguments
if len(sys.argv) < 3:
    print("Error: Both existing CSV filename and new data file path are required")
    print("Usage: python add_data_to_model.py <existing_csv_filename> <new_data_file_path>")
    sys.exit(1)

existing_csv_filename = sys.argv[1]
new_data_file_path = sys.argv[2]

# Supabase configuration
SUPABASE_URL = "https://cawdbumigiwafukejndb.supabase.co"
SUPABASE_KEY = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImNhd2RidW1pZ2l3YWZ1a2VqbmRiIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTM4MzY5NDYsImV4cCI6MjA2OTQxMjk0Nn0.R0twY6a16flkMAMdh6kndykvNRIG5d2FGlOpqoxQL20"
BUCKET_NAME = "adminfiles"

# Initialize Supabase client
try:
    supabase: Client = create_client(SUPABASE_URL, SUPABASE_KEY)
    print(f"Supabase client initialized successfully")
except Exception as e:
    print(f"Error initializing Supabase client: {e}")
    sys.exit(1)

def normalize_column_names(df):
    """Normalize column names by removing quotes and extra spaces"""
    normalized_columns = {}
    for col in df.columns:
        # Remove leading/trailing quotes and spaces
        normalized_col = col.strip().strip('"').strip("'")
        normalized_columns[col] = normalized_col
    
    # Rename columns
    df = df.rename(columns=normalized_columns)
    return df

def download_csv_from_supabase(filename):
    """Download CSV file from Supabase Storage"""
    try:
        print(f"Downloading CSV file: {filename} from Supabase bucket: {BUCKET_NAME}")
        
        # Download file from Supabase Storage
        response = supabase.storage.from_(BUCKET_NAME).download(filename)
        
        if response is None:
            raise Exception("No response from Supabase")
        
        print(f"Successfully retrieved file from Supabase")
        print(f"Response type: {type(response)}")
        print(f"Response length: {len(response) if hasattr(response, '__len__') else 'N/A'}")
        
        # Read CSV directly from memory using StringIO
        csv_content = response.decode('utf-8')
        
        # Clean the CSV content - handle various escape sequences
        csv_content = csv_content.replace('\\n', '\n')
        csv_content = csv_content.replace('\\r', '\r')
        csv_content = csv_content.replace('\\t', '\t')
        
        # Handle escaped quotes more carefully
        # First, let's see if the entire content is wrapped in quotes
        if csv_content.startswith('"') and csv_content.endswith('"'):
            print("CSV content is wrapped in quotes, removing them...")
            csv_content = csv_content[1:-1]
        
        # Remove escaped quotes that are causing parsing issues
        csv_content = csv_content.replace('\\"', '"')
        
        # Handle any remaining escape sequences
        csv_content = csv_content.replace('\\\\', '\\')
        
        # Remove any BOM (Byte Order Mark) if present
        if csv_content.startswith('\ufeff'):
            csv_content = csv_content[1:]
        
        # Debug: Show first few lines of CSV content
        lines = csv_content.split('\n')
        print(f"CSV content preview (first 3 lines):")
        for i, line in enumerate(lines[:3]):
            print(f"  Line {i+1}: {line[:100]}{'...' if len(line) > 100 else ''}")
        
        # Try to use pandas CSV reader first, then fall back to manual parsing
        try:
            from io import StringIO
            df = pd.read_csv(StringIO(csv_content))
            print(f"Successfully loaded existing CSV file with pandas CSV reader")
            print(f"Data shape: {df.shape}")
            print(f"Columns: {list(df.columns)}")
            
            # Normalize column names
            df = normalize_column_names(df)
            print(f"Normalized columns: {list(df.columns)}")
            
            return df
        except Exception as csv_error:
            print(f"Pandas CSV reader failed: {csv_error}")
            print("Falling back to manual parsing...")
            
            # Manual parsing approach - use proper CSV parsing
            import csv
            from io import StringIO
            
            # Try to clean the content further if it's wrapped in quotes
            if csv_content.startswith('"') and csv_content.endswith('"'):
                print("Removing outer quotes from CSV content")
                csv_content = csv_content[1:-1]
            
            # Additional cleaning for common CSV issues
            csv_content = csv_content.strip()
            
            # If the content still looks like it's all in one line, try to split it properly
            if '\n' not in csv_content and ',' in csv_content:
                print("CSV appears to be on a single line, attempting to split...")
                # This might be a case where the CSV is stored as a single line
                # We need to be more careful here
            
            # Use Python's csv module for proper parsing
            try:
                csv_reader = csv.reader(StringIO(csv_content))
                rows = list(csv_reader)
            except Exception as csv_parse_error:
                print(f"CSV parsing failed: {csv_parse_error}")
                print("Attempting alternative parsing method...")
                
                # Alternative parsing: split by lines first, then by commas
                lines = csv_content.split('\n')
                if len(lines) > 1:
                    # Get header from first line
                    header = lines[0].split(',')
                    # Get data rows
                    data_rows = []
                    for line in lines[1:]:
                        if line.strip():
                            data_rows.append(line.split(','))
                    
                    rows = [header] + data_rows
                    print(f"Alternative parsing successful, found {len(rows)} rows")
                else:
                    raise Exception("Could not parse CSV content")
            
            if len(rows) > 1:
                # Get header
                header = rows[0]
                # Get data rows
                data_rows = rows[1:]
                
                # Create DataFrame
                df = pd.DataFrame(data_rows, columns=header)
                print(f"Successfully loaded existing CSV file with manual parsing")
                print(f"Data shape: {df.shape}")
                print(f"Columns: {list(df.columns)}")
                
                # Normalize column names
                df = normalize_column_names(df)
                print(f"Normalized columns: {list(df.columns)}")
                
                return df
            else:
                raise Exception("No data rows found in existing CSV")
    
    except Exception as e:
        print(f"Error reading existing CSV file from Supabase: {e}")
        print(f"Error type: {type(e).__name__}")
        import traceback
        print(f"Full traceback: {traceback.format_exc()}")
        sys.exit(1)

def load_new_data(file_path):
    """Load new data from local file"""
    try:
        print(f"Loading new data from: {file_path}")
        
        # Try to read as CSV first
        try:
            df = pd.read_csv(file_path)
            print(f"Successfully loaded new data as CSV")
        except Exception as csv_error:
            print(f"CSV loading failed: {csv_error}")
            # Try Excel format
            try:
                df = pd.read_excel(file_path)
                print(f"Successfully loaded new data as Excel")
            except Exception as excel_error:
                print(f"Excel loading failed: {excel_error}")
                raise Exception("Could not load file as CSV or Excel")
        
        print(f"New data shape: {df.shape}")
        print(f"New data columns: {list(df.columns)}")
        
        # Normalize column names
        df = normalize_column_names(df)
        print(f"Normalized new data columns: {list(df.columns)}")
        
        print(f"First few rows of new data:")
        print(df.head())
        
        return df
    
    except Exception as e:
        print(f"Error loading new data: {e}")
        import traceback
        print(f"Full traceback: {traceback.format_exc()}")
        sys.exit(1)

def validate_columns(existing_df, new_df):
    """Validate that new data has the same columns as existing data"""
    # Normalize column names for both dataframes
    existing_df = normalize_column_names(existing_df)
    new_df = normalize_column_names(new_df)
    
    existing_columns = set(existing_df.columns)
    new_columns = set(new_df.columns)
    
    if existing_columns != new_columns:
        missing_in_new = existing_columns - new_columns
        extra_in_new = new_columns - existing_columns
        
        error_msg = "Column mismatch between existing and new data:\n"
        if missing_in_new:
            error_msg += f"Missing in new data: {missing_in_new}\n"
        if extra_in_new:
            error_msg += f"Extra in new data: {extra_in_new}\n"
        error_msg += f"Existing columns: {sorted(existing_columns)}\n"
        error_msg += f"New data columns: {sorted(new_columns)}"
        
        print(f"ERROR: {error_msg}")
        return False, existing_df, new_df
    
    print("Column validation passed - all columns match")
    return True, existing_df, new_df

def combine_dataframes(existing_df, new_df):
    """Combine existing and new data"""
    try:
        print(f"Combining dataframes...")
        print(f"Existing data shape: {existing_df.shape}")
        print(f"New data shape: {new_df.shape}")
        
        # Reset index for both dataframes to avoid index conflicts
        existing_df = existing_df.reset_index(drop=True)
        new_df = new_df.reset_index(drop=True)
        
        # Combine the dataframes
        combined_df = pd.concat([existing_df, new_df], ignore_index=True)
        
        print(f"Combined data shape: {combined_df.shape}")
        print(f"Total rows: {len(combined_df)}")
        
        # Check for duplicates (optional - you might want to keep duplicates)
        initial_count = len(combined_df)
        combined_df = combined_df.drop_duplicates()
        final_count = len(combined_df)
        
        if initial_count != final_count:
            print(f"Removed {initial_count - final_count} duplicate rows")
        
        return combined_df
    
    except Exception as e:
        print(f"Error combining dataframes: {e}")
        import traceback
        print(f"Full traceback: {traceback.format_exc()}")
        sys.exit(1)

def save_combined_csv(df, output_path):
    """Save combined dataframe to CSV"""
    try:
        print(f"Saving combined data to: {output_path}")
        df.to_csv(output_path, index=False)
        print(f"Successfully saved combined CSV with {len(df)} rows")
        return True
    except Exception as e:
        print(f"Error saving combined CSV: {e}")
        return False

def generate_unique_filename(extension="png"):
    unique_id = uuid.uuid4()  # Generate a unique ID
    return f"{unique_id}.{extension}"

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

def train_models_with_data(df_clean):
    """Train models with the updated data and generate visualizations"""
    try:
        print("\n" + "=" * 60)
        print("TRAINING MODELS WITH UPDATED DATA")
        print("=" * 60)
        
        # Prepare features for Employment Rate prediction
        feature_columns = ['CGPA', 'Average Prof Grade', 'Average Elec Grade', 'OJT Grade', 
                          'Leadership POS', 'Act Member POS', 'Soft Skills Ave', 'Hard Skills Ave']
        
        # Check if all required columns exist
        missing_columns = [col for col in feature_columns if col not in df_clean.columns]
        if missing_columns:
            print(f"Missing columns: {missing_columns}")
            print(f"Available columns: {list(df_clean.columns)}")
            return False
        
        print(f"Using feature columns: {feature_columns}")
        X = df_clean[feature_columns].copy()
        
        # Clean the data - remove any rows with NaN values
        print(f"Original data shape: {X.shape}")
        X = X.dropna()
        print(f"Data shape after removing NaN values: {X.shape}")
        
        # Convert Yes/No to 1/0 for binary columns
        X['Leadership POS'] = (X['Leadership POS'] == 'Yes').astype(int)
        X['Act Member POS'] = (X['Act Member POS'] == 'Yes').astype(int)
        
        # Check if Employability column exists
        if 'Employability' not in df_clean.columns:
            print(f"Missing 'Employability' column")
            return False
        
        # Clean the target variable as well - remove rows where target is NaN
        y = df_clean['Employability'].map({'Employable': 1, 'Not Employable': 0})
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
        lr_model_initial.fit(X, y)
        initial_employment_rate = lr_model_initial.predict(X)
        
        # Create a cleaned DataFrame for all operations
        df_clean_aligned = df_clean.loc[common_index].copy()
        df_clean_aligned['Employment Rate'] = initial_employment_rate * 100  # Convert to percentage
        
        # Check if Year Graduated column exists
        if 'Year Graduated' not in df_clean_aligned.columns:
            print(f"Missing 'Year Graduated' column")
            return False
        
        # Create time series by graduation year
        df_clean_aligned['Year Graduated'] = pd.to_datetime(df_clean_aligned['Year Graduated'], format='%Y')
        yearly_data = df_clean_aligned.groupby('Year Graduated')['Employment Rate'].mean()
        
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
        
        # Create linear regression model
        lr_results = create_linear_regression_model(ts)
        
        # Fit ARIMA model
        try:
            # Find best parameters
            auto_model = auto_arima(ts,
                                   start_p=1, max_p=5,
                                   start_q=1, max_q=5,
                                   m=12,
                                   seasonal=False,
                                   d=1,
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
            
            # Create the first plot - Employment Rate Forecast Line
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

            # Save to BytesIO and upload to Supabase
            buf1 = io.BytesIO()
            plt.savefig(buf1, format='png')
            plt.close()
            filename1 = 'employment_rate_forecast_line.png'
            
            # Upload first image
            try:
                supabase.storage.from_(BUCKET_NAME).remove(filename1)
            except:
                pass
            
            response1 = supabase.storage.from_(BUCKET_NAME).upload(
                filename1, buf1.getvalue(),
                file_options={"content-type": "image/png"}
            )
            print(f"Uploaded {filename1}")
            
            # Create forecast plot
            forecast_steps = 3
            forecast = results.get_forecast(steps=forecast_steps)
            forecast_mean = forecast.predicted_mean
            conf_int = forecast.conf_int()
            
            # Create forecast dates
            last_date = ts.index[-1]
            forecast_dates = pd.date_range(start=last_date + pd.DateOffset(years=1), 
                                         periods=forecast_steps, 
                                         freq='Y')
            
            # Create the second plot - Employment Rate Comparison with Forecast
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

            plt.tight_layout()

            # Save to BytesIO and upload to Supabase
            buf2 = io.BytesIO()
            plt.savefig(buf2, format='png')
            plt.close()
            filename2 = 'employment_rate_comparison.png'
            
            # Upload second image
            try:
                supabase.storage.from_(BUCKET_NAME).remove(filename2)
            except:
                pass
            
            response2 = supabase.storage.from_(BUCKET_NAME).upload(
                filename2, buf2.getvalue(),
                file_options={"content-type": "image/png"}
            )
            print(f"Uploaded {filename2}")
            
            # Calculate performance metrics
            mse = mean_squared_error(ts, predictions)
            rmse = np.sqrt(mse)
            mae = mean_absolute_error(ts, predictions)
            r2 = r2_score(ts, predictions)
            mape = np.mean(np.abs((ts - predictions) / ts)) * 100
            aic = results.aic
            
            # Calculate yearly accuracy
            yearly_comparison['Accuracy'] = (1 - abs(yearly_comparison['Actual'] - yearly_comparison['Predicted']) / yearly_comparison['Actual']) * 100
            
            # Determine the better model
            better_model = 'ARIMA' if rmse < lr_results['metrics']['rmse'] else 'Linear Regression'
            
            # Update Supabase with results
            update_data = {
                'total_alumni': int(len(df_clean_aligned)),
                'prediction_accuracy': float(yearly_comparison['Accuracy'].mean()),
                'employment_rate_forecast_line_image': filename1,
                'employment_rate_comparison_image': filename2,
                'rmse': float(rmse),
                'mae': float(mae),
                'r2': float(r2),
                'aic': float(aic),
                'confidence_interval': float(conf_int.iloc[-1, 1] - conf_int.iloc[-1, 0]),
                'actual_rate': float(yearly_comparison['Actual'].iloc[-1]),
                'predicted_rate': float(yearly_comparison['Predicted'].iloc[-1]),
                'margin_of_error': float(abs(yearly_comparison['Actual'].iloc[-1] - yearly_comparison['Predicted'].iloc[-1])),
                'predicted_employability_by_degree_image': '',
                'distribution_of_predicted_employment_rates_image': ''
            }
            
            update_supabase_record(update_data)
            print("Successfully updated Supabase database with training results")
            
            print("\nModel Training Results:")
            print("=" * 50)
            print(f"Total Alumni: {len(df_clean_aligned)}")
            print(f"Prediction Accuracy: {yearly_comparison['Accuracy'].mean():.2f}%")
            print(f"RMSE: {rmse:.4f}")
            print(f"MAE: {mae:.4f}")
            print(f"R²: {r2:.4f}")
            print(f"Better Model: {better_model}")
            print("=" * 50)
            
            return True
            
        except Exception as e:
            print(f"Error in ARIMA model training: {e}")
            import traceback
            print(f"Full traceback: {traceback.format_exc()}")
            return False
            
    except Exception as e:
        print(f"Error in model training: {e}")
        import traceback
        print(f"Full traceback: {traceback.format_exc()}")
        return False

def main():
    print("=" * 60)
    print("ADD DATA TO EXISTING MODEL SCRIPT")
    print("=" * 60)
    print(f"Arguments received:")
    print(f"  - existing_csv_filename: {existing_csv_filename}")
    print(f"  - new_data_file_path: {new_data_file_path}")
    print(f"  - new_data_file_exists: {os.path.exists(new_data_file_path)}")
    
    # Step 1: Download existing CSV from Supabase
    print("\nStep 1: Downloading existing CSV from Supabase...")
    existing_df = download_csv_from_supabase(existing_csv_filename)
    
    # Step 2: Load new data from local file
    print("\nStep 2: Loading new data from local file...")
    new_df = load_new_data(new_data_file_path)
    
    # Step 3: Validate columns match
    print("\nStep 3: Validating column structure...")
    validation_result, existing_df, new_df = validate_columns(existing_df, new_df)
    if not validation_result:
        print("ERROR: Column validation failed. Cannot proceed.")
        sys.exit(1)
    
    # Step 4: Combine the dataframes
    print("\nStep 4: Combining existing and new data...")
    combined_df = combine_dataframes(existing_df, new_df)
    
    # Step 5: Save combined data to temporary file
    print("\nStep 5: Saving combined data...")
    temp_dir = tempfile.gettempdir()
    output_filename = f"combined_data_{existing_csv_filename}"
    output_path = os.path.join(temp_dir, output_filename)
    
    if not save_combined_csv(combined_df, output_path):
        print("ERROR: Failed to save combined CSV")
        sys.exit(1)
    
    # Step 6: Upload updated CSV back to Supabase
    print("\nStep 6: Uploading updated CSV to Supabase...")
    try:
        # Read the file content
        with open(output_path, 'rb') as f:
            file_content = f.read()
        
        # Upload to Supabase (this will overwrite the existing file)
        response = supabase.storage.from_(BUCKET_NAME).upload(
            existing_csv_filename, file_content,
            file_options={"content-type": "text/csv", "upsert": "true"}
        )
        
        if response:
            print(f"Successfully uploaded updated CSV to Supabase")
            public_url = f"{SUPABASE_URL}/storage/v1/object/public/{BUCKET_NAME}/{existing_csv_filename}"
            print(f"Public URL: {public_url}")
        else:
            print("ERROR: Failed to upload updated CSV to Supabase")
            sys.exit(1)
    
    except Exception as e:
        print(f"ERROR: Exception during upload: {e}")
        import traceback
        print(f"Full traceback: {traceback.format_exc()}")
        sys.exit(1)
    
    # Step 7: Train models with updated data
    print("\nStep 7: Training models with updated data...")
    training_success = train_models_with_data(combined_df)
    
    if not training_success:
        print("Warning: Model training failed, but data was still added successfully")
        # Still update basic database record even if training failed
        try:
            update_data = {
                'total_alumni': int(len(combined_df)),
                'last_updated': pd.Timestamp.now().isoformat()
            }
            update_supabase_record(update_data)
        except Exception as e:
            print(f"Warning: Could not update basic database record: {e}")
    
    # Step 8: Clean up temporary file
    print("\nStep 8: Cleaning up...")
    try:
        if os.path.exists(output_path):
            os.remove(output_path)
            print("Temporary file cleaned up")
    except Exception as e:
        print(f"Warning: Could not clean up temporary file: {e}")
    
    # Output the path for the controller to use
    print(f"\nUPDATED_CSV:{output_path}")
    
    print("\n" + "=" * 60)
    print("DATA ADDITION AND MODEL TRAINING COMPLETED")
    print("=" * 60)
    print(f"Original data rows: {len(existing_df)}")
    print(f"New data rows: {len(new_df)}")
    print(f"Combined data rows: {len(combined_df)}")
    print(f"Updated CSV filename: {existing_csv_filename}")
    print(f"Model training: {'SUCCESS' if training_success else 'FAILED'}")
    print("=" * 60)

if __name__ == "__main__":
    main()
