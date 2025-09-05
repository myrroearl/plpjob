import sys
import pandas as pd
import warnings

# Suppress warnings
warnings.filterwarnings("ignore")

# Handle command line arguments
if len(sys.argv) < 2:
    print("Error: New data file path is required")
    print("Usage: python add_data_to_model.py <new_data_file_path>")
    sys.exit(1)

new_data_file_path = sys.argv[1]

def count_new_data_records(file_path):
    """Count the number of records in the new data file"""
    try:
        print(f"Counting records in: {file_path}")
        
        # Try CSV first, then Excel
        try:
            df = pd.read_csv(file_path)
            print(f"Loaded as CSV: {len(df)} rows")
        except Exception:
            df = pd.read_excel(file_path)
            print(f"Loaded as Excel: {len(df)} rows")
        
        # Count non-empty rows (excluding header)
        record_count = len(df)
        print(f"Total records found: {record_count}")
        
        return record_count
    
    except Exception as e:
        print(f"Error counting records: {e}")
        return 0

def main():
    print("COUNT NEW DATA RECORDS")
    print("=" * 30)
    
    # Count records in new data file
    record_count = count_new_data_records(new_data_file_path)
    
    if record_count > 0:
        print(f"NEW_DATA_COUNT:{record_count}")
        print(f"Successfully counted {record_count} records")
    else:
        print("ERROR: No records found or failed to read file")
        sys.exit(1)
    
    print("=" * 30)
    print("COMPLETED")

if __name__ == "__main__":
    main()
