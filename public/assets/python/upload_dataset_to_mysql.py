import sys
import pandas as pd
import mysql.connector
from mysql.connector import Error
import os
import warnings

# Suppress all warnings
warnings.filterwarnings("ignore")

def get_mysql_connection():
    """Get MySQL database connection using Laravel environment variables"""
    try:
        # These should match your Laravel .env file
        connection = mysql.connector.connect(
            host=os.getenv('DB_HOST', 'mysql.railway.internal'),
            port=int(os.getenv('DB_PORT', 3306)),
            database=os.getenv('DB_DATABASE', 'railway'),
            user=os.getenv('DB_USERNAME', 'root'),
            password=os.getenv('DB_PASSWORD', 'uzTWebEtRKIvSROmBYNgcQdrelFjZDgE')
        )
        return connection
    except Error as e:
        print(f"Error connecting to MySQL: {e}")
        return None

def truncate_dataset_table(connection):
    """Truncate the dataset table"""
    try:
        cursor = connection.cursor()
        cursor.execute("SET FOREIGN_KEY_CHECKS=0;")
        cursor.execute("TRUNCATE TABLE dataset;")
        cursor.execute("SET FOREIGN_KEY_CHECKS=1;")
        connection.commit()
        print("Dataset table truncated successfully")
        return True
    except Error as e:
        print(f"Error truncating dataset table: {e}")
        return False

def upload_csv_to_mysql(csv_file_path):
    """Upload CSV data to MySQL dataset table"""
    try:
        # Read CSV file
        print(f"Reading CSV file: {csv_file_path}")
        df = pd.read_csv(csv_file_path)
        print(f"CSV loaded successfully. Shape: {df.shape}")
        print(f"Columns: {list(df.columns)}")
        
        # Get MySQL connection
        connection = get_mysql_connection()
        if not connection:
            return False
        
        # Truncate table first
        if not truncate_dataset_table(connection):
            return False
        
        # Column mapping from CSV headers to database columns
        column_mapping = {
            'Student Number': 'student_number',
            'Gender': 'gender',
            'Age': 'age',
            'Degree': 'degree',
            'Year Graduated': 'year_graduated',
            'CGPA': 'cgpa',
            'Average Prof Grade': 'average_prof_grade',
            'Average Elec Grade': 'average_elec_grade',
            'OJT Grade': 'ojt_grade',
            'Leadership POS': 'leadership_pos',
            'Act Member POS': 'act_member_pos',
            'Soft Skills Ave': 'soft_skills_ave',
            'Hard Skills Ave': 'hard_skills_ave',
            'Employability': 'employability',
            'Auditing Skills': 'auditing_skills',
            'Budgeting & Analysis Skills': 'budgeting_analysis_skills',
            'Classroom Management Skills': 'classroom_management_skills',
            'Cloud Computing Skills': 'cloud_computing_skills',
            'Curriculum Development Skills': 'curriculum_development_skills',
            'Data Structures & Algorithms': 'data_structures_algorithms',
            'Database Management Skills': 'database_management_skills',
            'Educational Technology Skills': 'educational_technology_skills',
            'Financial Accounting Skills': 'financial_accounting_skills',
            'Financial Management Skills': 'financial_management_skills',
            'Java Programming Skills': 'java_programming_skills',
            'Leadership & Decision-Making Skills': 'leadership_decision_making_skills',
            'Machine Learning Skills': 'machine_learning_skills',
            'Marketing Skills': 'marketing_skills',
            'Networking Skills': 'networking_skills',
            'Programming Logic Skills': 'programming_logic_skills',
            'Python Programming Skills': 'python_programming_skills',
            'Software Engineering Skills': 'software_engineering_skills',
            'Strategic Planning Skills': 'strategic_planning_skills',
            'System Design Skills': 'system_design_skills',
            'Taxation Skills': 'taxation_skills',
            'Teaching Skills': 'teaching_skills',
            'Web Development Skills': 'web_development_skills',
            'Statistical Analysis Skills': 'statistical_analysis_skills',
            'English Communication & Writing Skills': 'english_communication_writing_skills',
            'Filipino Communication & Writing Skills': 'filipino_communication_writing_skills',
            'Early Childhood Education Skills': 'early_childhood_education_skills',
            'Customer Service Skills': 'customer_service_skills',
            'Event Management Skills': 'event_management_skills',
            'Food & Beverage Management Skills': 'food_beverage_management_skills',
            'Risk Management Skills': 'risk_management_skills',
            'Innovation & Business Planning Skills': 'innovation_business_planning_skills',
            'Consumer Behavior Analysis': 'consumer_behavior_analysis',
            'Sales Management Skills': 'sales_management_skills',
            'Artificial Intelligence Skills': 'artificial_intelligence_skills',
            'Cybersecurity Skills': 'cybersecurity_skills',
            'Circuit Design Skills': 'circuit_design_skills',
            'Communication Systems Skills': 'communication_systems_skills',
            'Problem-Solving Skills': 'problem_solving_skills',
            'Clinical Skills': 'clinical_skills',
            'Patient Care Skills': 'patient_care_skills',
            'Health Assessment Skills': 'health_assessment_skills',
            'Emergency Response Skills': 'emergency_response_skills',
            'Board Passer': 'board_passer'
        }
        
        # Prepare insert statement
        db_columns = list(column_mapping.values())
        placeholders = ', '.join(['%s'] * len(db_columns))
        insert_query = f"""
            INSERT INTO dataset ({', '.join(db_columns)}) 
            VALUES ({placeholders})
        """
        
        cursor = connection.cursor()
        inserted_count = 0
        error_count = 0
        
        # Process each row
        for index, row in df.iterrows():
            try:
                # Map CSV data to database columns
                values = []
                for csv_col, db_col in column_mapping.items():
                    if csv_col in df.columns:
                        value = row[csv_col]
                        
                        # Handle NaN values
                        if pd.isna(value):
                            values.append(None)
                            continue
                        
                        # Convert data types
                        if db_col in ['age', 'year_graduated']:
                            values.append(int(value) if pd.notna(value) and str(value).replace('.', '').isdigit() else None)
                        elif db_col == 'board_passer':
                            values.append(str(value).lower() in ['yes', '1', 'true', 'y'])
                        elif db_col in ['cgpa', 'average_prof_grade', 'average_elec_grade', 'ojt_grade', 
                                      'soft_skills_ave', 'hard_skills_ave', 'employability'] or '_skills' in db_col:
                            values.append(float(value) if pd.notna(value) and str(value).replace('.', '').replace('-', '').isdigit() else None)
                        else:
                            values.append(str(value) if pd.notna(value) else None)
                    else:
                        values.append(None)
                
                # Validate required fields
                if not values[0] or not values[1] or not values[3] or not values[4]:  # student_number, gender, degree, year_graduated
                    print(f"Row {index + 2}: Missing required fields, skipping")
                    error_count += 1
                    continue
                
                # Insert record
                cursor.execute(insert_query, values)
                inserted_count += 1
                
                # Log progress every 100 records
                if inserted_count % 100 == 0:
                    print(f"Inserted {inserted_count} records...")
                    
            except Exception as e:
                print(f"Error processing row {index + 2}: {e}")
                error_count += 1
        
        # Commit transaction
        connection.commit()
        cursor.close()
        connection.close()
        
        print(f"Upload completed successfully!")
        print(f"Records inserted: {inserted_count}")
        print(f"Errors: {error_count}")
        print(f"Total rows processed: {len(df)}")
        
        return True
        
    except Exception as e:
        print(f"Error uploading CSV to MySQL: {e}")
        return False

def main():
    if len(sys.argv) < 2:
        print("Usage: python upload_dataset_to_mysql.py <csv_file_path>")
        sys.exit(1)
    
    csv_file_path = sys.argv[1]
    
    if not os.path.exists(csv_file_path):
        print(f"Error: CSV file not found: {csv_file_path}")
        sys.exit(1)
    
    print(f"Starting dataset upload from: {csv_file_path}")
    
    if upload_csv_to_mysql(csv_file_path):
        print("Dataset upload completed successfully!")
        sys.exit(0)
    else:
        print("Dataset upload failed!")
        sys.exit(1)

if __name__ == "__main__":
    main()
