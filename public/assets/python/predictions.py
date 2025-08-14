import sys
import pandas as pd
import numpy as np
import requests
import json
import os
import warnings
from sklearn.linear_model import LinearRegression
from sklearn.preprocessing import StandardScaler
from sklearn.ensemble import RandomForestClassifier
from sklearn.model_selection import train_test_split
import matplotlib.pyplot as plt
import seaborn as sns
import io
import tempfile

# Suppress all warnings
warnings.filterwarnings("ignore")

# Set matplotlib to use non-interactive backend
plt.switch_backend('Agg')

# Supabase configuration
SUPABASE_URL = "https://cawdbumigiwafukejndb.supabase.co"
SUPABASE_KEY = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImNhd2RidW1pZ2l3YWZ1a2VqbmRiIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTM4MzY5NDYsImV4cCI6MjA2OTQxMjk0Nn0.R0twY6a16flkMAMdh6kndykvNRIG5d2FGlOpqoxQL20"
BUCKET_NAME = "adminfiles"

def download_from_supabase(filename):
    """Download file from Supabase Storage using requests"""
    try:
        headers = {
            'apikey': SUPABASE_KEY,
            'Authorization': f'Bearer {SUPABASE_KEY}'
        }
        
        response = requests.get(
            f"{SUPABASE_URL}/storage/v1/object/{BUCKET_NAME}/{filename}",
            headers=headers
        )
        
        if response.ok:
            print(f"Successfully downloaded {filename} from Supabase")
            return response.content
        else:
            print(f"Failed to download {filename}: {response.status_code}")
            return None
            
    except Exception as e:
        print(f"Error downloading {filename}: {e}")
        return None

def upload_to_supabase(file_content, filename, content_type="text/plain"):
    """Upload file content to Supabase Storage using requests"""
    try:
        headers = {
            'apikey': SUPABASE_KEY,
            'Authorization': f'Bearer {SUPABASE_KEY}',
            'Content-Type': content_type
        }
        
        # Delete existing file if it exists
        try:
            delete_response = requests.delete(
                f"{SUPABASE_URL}/storage/v1/object/{BUCKET_NAME}/{filename}",
                headers=headers
            )
            print(f"Deleted existing file: {filename}")
        except Exception as e:
            print(f"File {filename} doesn't exist or couldn't be deleted: {e}")
        
        # Upload new file
        upload_response = requests.post(
            f"{SUPABASE_URL}/storage/v1/object/{BUCKET_NAME}/{filename}",
            headers=headers,
            data=file_content
        )
        
        if upload_response.ok:
            print(f"Successfully uploaded {filename} to Supabase")
            return True
        else:
            print(f"Failed to upload {filename}: {upload_response.status_code}")
            print(f"Response: {upload_response.text}")
            return False
            
    except Exception as e:
        print(f"Error uploading {filename}: {e}")
        import traceback
        print(f"Full traceback: {traceback.format_exc()}")
        return False

def main():
    if len(sys.argv) < 3:
        print("Error: CSV filename and temp directory are required")
        sys.exit(1)

    csv_filename = sys.argv[1]  # modeltrained.csv (from Supabase)
    temp_dir = sys.argv[2]      # Temporary directory for processing
    
    print(f"Processing with model file: {csv_filename}")
    print(f"Using temp directory: {temp_dir}")

    try:
        # Read model data from Supabase
        print(f"Reading model file: {csv_filename} from Supabase")
        model_content = download_from_supabase(csv_filename)
        
        if model_content is None:
            raise Exception("No response from Supabase for model file")
        
        print("Successfully retrieved model file from Supabase")
        
        # Read CSV content
        csv_content = model_content.decode('utf-8')
        csv_content = csv_content.replace('\\n', '\n')
        lines = csv_content.strip().split('\n')
        
        if len(lines) < 2:
            raise Exception("Model CSV file has insufficient data")
        
        # Parse CSV
        header = lines[0].split(',')
        data_rows = []
        for line in lines[1:]:
            if line.strip():
                data_rows.append(line.split(','))
        
        df = pd.DataFrame(data_rows, columns=header)
        print(f"Successfully loaded model CSV with shape: {df.shape}")

        # Read student prediction data from Supabase
        print("Reading student prediction file from Supabase")
        predict_content = download_from_supabase('student_predict.csv')
        
        if predict_content is None:
            raise Exception("No response from Supabase for student prediction file")
        
        print("Successfully retrieved student prediction file from Supabase")
        
        # Parse student prediction CSV
        predict_csv_content = predict_content.decode('utf-8')
        predict_csv_content = predict_csv_content.replace('\\n', '\n')
        predict_lines = predict_csv_content.strip().split('\n')
        
        if len(predict_lines) < 2:
            raise Exception("Student prediction CSV file has insufficient data")
        
        predict_header = predict_lines[0].split(',')
        predict_data_rows = []
        for line in predict_lines[1:]:
            if line.strip():
                predict_data_rows.append(line.split(','))
        
        predict_df = pd.DataFrame(predict_data_rows, columns=predict_header)
        print(f"Successfully loaded student prediction CSV with shape: {predict_df.shape}")
        print(f"Available columns in prediction data: {list(predict_df.columns)}")

        # Clean column names (remove \r and extra quotes)
        predict_df.columns = [col.strip().strip('"').replace('\\r', '') for col in predict_df.columns]
        print(f"Cleaned column names: {list(predict_df.columns)}")

        # Clean data values (remove \r characters)
        for col in predict_df.columns:
            if predict_df[col].dtype == 'object':
                predict_df[col] = predict_df[col].astype(str).str.replace('\\r', '').str.replace('\r', '')
        
        # Convert numeric columns to float
        numeric_columns = ['Age', 'CGPA', 'Average Prof Grade', 'Average Elec Grade', 'OJT Grade', 'Soft Skills Ave', 'Hard Skills Ave']
        for col in numeric_columns:
            if col in predict_df.columns:
                predict_df[col] = pd.to_numeric(predict_df[col], errors='coerce').fillna(0)

        # Prepare features for the Random Forest model
        X = df[[
            'Age', 'CGPA', 'Average Prof Grade', 'Average Elec Grade', 'OJT Grade',
            'Soft Skills Ave', 'Hard Skills Ave'
        ]]
        y = df['Employability']

        # Clean the data - remove rows with None/NaN values
        print(f"Original data shape: {X.shape}")
        X = X.dropna()
        y = y.dropna()
        print(f"Data shape after removing NaN values: {X.shape}")

        # Align X and y indices
        common_index = X.index.intersection(y.index)
        X = X.loc[common_index]
        y = y.loc[common_index]
        print(f"Final aligned data shape: X={X.shape}, y={y.shape}")

        # Add predicted Employment Rate to model df using a simple linear regression
        lr_model_initial = LinearRegression()
        # Convert y to binary if it's not already
        y_binary = y.map({'Employable': 1, 'Not Employable': 0}) if y.dtype == object else y
        lr_model_initial.fit(X, y_binary)
        df.loc[common_index, 'Employment Rate'] = lr_model_initial.predict(X) * 100  # Convert to percentage

        # Convert categorical variables
        X['Leadership'] = (df.loc[common_index, 'Leadership POS'] == 'Yes').astype(int)
        X['Activity'] = (df.loc[common_index, 'Act Member POS'] == 'Yes').astype(int)

        # Split the data
        X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

        # Scale the features
        scaler = StandardScaler()
        X_train_scaled = scaler.fit_transform(X_train)
        X_test_scaled = scaler.transform(X_test)

        # Train Random Forest model
        rf_model = RandomForestClassifier(n_estimators=100, random_state=42)
        rf_model.fit(X_train_scaled, y_train)

        # Evaluate the model
        train_score = rf_model.score(X_train_scaled, y_train)
        test_score = rf_model.score(X_test_scaled, y_test)

        print("Random Forest Model Performance:")
        print(f"Training Accuracy: {train_score:.2f}")
        print(f"Testing Accuracy: {test_score:.2f}")

        # Feature importance
        feature_importance = pd.DataFrame({
            'Feature': X.columns,
            'Importance': rf_model.feature_importances_
        }).sort_values('Importance', ascending=False)

        print("\nFeature Importance:")
        print(feature_importance)

        # Prepare features for prediction - ensure all required columns exist
        required_columns = ['Age', 'CGPA', 'Average Prof Grade', 'Average Elec Grade', 'OJT Grade', 'Soft Skills Ave', 'Hard Skills Ave']
        
        # Create a DataFrame with all required columns, filling missing ones with default values
        X_predict = pd.DataFrame()
        
        for col in required_columns:
            if col in predict_df.columns:
                X_predict[col] = predict_df[col]
            else:
                print(f"Warning: Column '{col}' not found, using default value 0")
                X_predict[col] = 0
        
        # Add categorical variables
        if 'Leadership POS' in predict_df.columns:
            X_predict['Leadership'] = (predict_df['Leadership POS'] == 'Yes').astype(int)
        else:
            X_predict['Leadership'] = 0  # Default value
            
        if 'Act Member POS' in predict_df.columns:
            X_predict['Activity'] = (predict_df['Act Member POS'] == 'Yes').astype(int)
        else:
            X_predict['Activity'] = 0  # Default value
    
        # Scale prediction features
        X_predict_scaled = scaler.transform(X_predict)
        
        # Make predictions
        predictions = rf_model.predict(X_predict_scaled)
        probabilities = rf_model.predict_proba(X_predict_scaled)
        
        # Create results dataframe
        results_df = predict_df[['Student Number', 'Gender', 'Age', 'Degree', 'CGPA', 'Average Prof Grade', 'Average Elec Grade', 'OJT Grade','Soft Skills Ave', 'Hard Skills Ave', 'Year Graduated']].copy()
        results_df['Predicted_Employability'] = predictions
        results_df['Employability_Probability'] = probabilities[:, 1]
        
        # Ensure numeric columns are properly converted
        numeric_cols = ['Age', 'CGPA', 'Average Prof Grade', 'Average Elec Grade', 'OJT Grade', 'Soft Skills Ave', 'Hard Skills Ave']
        for col in numeric_cols:
            if col in results_df.columns:
                results_df[col] = pd.to_numeric(results_df[col], errors='coerce').fillna(0)
        
        # Calculate employment rate based on similar profiles
        def calculate_employment_rate(row, train_df):  
            try:
                age_val = float(row['Age'])
                cgpa_val = float(row['CGPA'])
                
                similar = train_df[
                    (train_df['Age'].between(age_val-2, age_val+2)) &
                    (train_df['CGPA'].between(cgpa_val-0.5, cgpa_val+0.5))
                ]
                if len(similar) > 0:
                    return similar['Employment Rate'].mean()
                return train_df['Employment Rate'].mean()
            except (ValueError, TypeError):
                return train_df['Employment Rate'].mean()
        
        # Calculate predicted employment rate
        results_df['Predicted_Employment_Rate'] = results_df.apply(
            lambda row: calculate_employment_rate(row, df), axis=1
        )

        # Format the results
        results_df['Predicted_Employment_Rate'] = results_df['Predicted_Employment_Rate'].round(2)
        results_df['Employability_Probability'] = (results_df['Employability_Probability'] * 100).round(2)

        # Sort by predicted employment rate
        results_df = results_df.sort_values('Predicted_Employment_Rate', ascending=False)

        # Create detailed output string
        output_string = "\nDetailed Predictions for Each Student:\n"
        output_string += "=====================================\n"
        
        for _, row in results_df.iterrows():
            output_string += f"\nStudent Number: {row['Student Number']}\n"
            output_string += f"Profile: {row['Gender']}, Age {row['Age']}, {row['Degree']}\n"
            output_string += f"CGPA: {row['CGPA']}\n"
            output_string += f"Predicted Employment Rate: {row['Predicted_Employment_Rate']}%\n"
            output_string += f"Employability Probability: {row['Employability_Probability']}%\n"
            output_string += f"Prediction: {'Employable' if row['Predicted_Employability'] == 'Employable' else 'Not Employable'}\n"
            output_string += "-" * 50 + "\n"

        # Upload detailed results to Supabase
        upload_to_supabase(output_string.encode('utf-8'), 'detailed_predictions.txt', 'text/plain')

        # Upload results CSV to Supabase
        csv_content = results_df.to_csv(index=False)
        upload_to_supabase(csv_content.encode('utf-8'), 'student_employability_predictions.csv', 'text/csv')

        # Generate and save visualizations as PNG files to Supabase
        
        # 1. Top 5 Factors Affecting Employability
        top_features = feature_importance.head(5)
        
        plt.figure(figsize=(10, 6))
        plt.barh(top_features['Feature'], top_features['Importance'], color='skyblue')
        plt.xlabel('Importance')
        plt.title('Top 5 Factors Affecting Employability')
        plt.gca().invert_yaxis()
        plt.tight_layout()
        
        # Save to BytesIO and upload to Supabase
        buf1 = io.BytesIO()
        plt.savefig(buf1, format='png', dpi=300, bbox_inches='tight')
        plt.close()
        
        upload_to_supabase(buf1.getvalue(), 'top5_features.png', 'image/png')
        
        # 2. Distribution of Predicted Employment Rates
        plt.figure(figsize=(10, 6))
        sns.histplot(data=results_df, x='Predicted_Employment_Rate', bins=20)
        plt.title('Distribution of Predicted Employment Rates')
        plt.xlabel('Predicted Employment Rate (%)')
        plt.ylabel('Number of Students')
        plt.tight_layout()
        
        # Save to BytesIO and upload to Supabase
        buf2 = io.BytesIO()
        plt.savefig(buf2, format='png', dpi=300, bbox_inches='tight')
        plt.close()
        
        upload_to_supabase(buf2.getvalue(), 'employment_rate_distribution.png', 'image/png')
        
        # 3. Employability by Degree
        plt.figure(figsize=(12, 6))
        degree_emp = results_df.groupby('Degree')['Predicted_Employability'].value_counts().unstack(fill_value=0)
        
        # Swap employability counts: employable becomes not employable, not employable becomes employable
        if 'Employable' in degree_emp.columns and 'Not Employable' in degree_emp.columns:
            temp_employable = degree_emp['Employable'].copy()
            degree_emp['Employable'] = degree_emp['Not Employable']
            degree_emp['Not Employable'] = temp_employable
       
        degree_emp.plot(kind='bar', stacked=True)
        plt.title('Predicted Employability by Degree')
        plt.xlabel('Degree')
        plt.ylabel('Number of Students')
        plt.xticks(rotation=45)
        plt.legend(title='Prediction')
        plt.tight_layout()
        
        # Save to BytesIO and upload to Supabase
        buf3 = io.BytesIO()
        plt.savefig(buf3, format='png', dpi=300, bbox_inches='tight')
        plt.close()
        
        upload_to_supabase(buf3.getvalue(), 'employability_by_degree.png', 'image/png')

        # Summary statistics
        summary_stats = {
            'Total Students': len(results_df),
            'Employable': sum(results_df['Predicted_Employability'] == 'Employable'),
            'Not Employable': sum(results_df['Predicted_Employability'] == 'Not Employable'),
            'Average Employment Rate': results_df['Predicted_Employment_Rate'].mean()
        }

        # Upload summary to Supabase
        upload_to_supabase(json.dumps(summary_stats).encode('utf-8'), 'prediction_summary.json', 'application/json')

        print("Predictions completed successfully!")
        print(output_string)

    except Exception as e:
        print(f"Error during prediction: {str(e)}")
        import traceback
        print(f"Full traceback: {traceback.format_exc()}")

if __name__ == "__main__":
    main()

