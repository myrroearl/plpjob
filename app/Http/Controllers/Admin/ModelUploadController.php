<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlumniPredictionModel;
use App\Models\Student;
use App\Models\User;
use App\Services\SupabaseStorageService;
use App\Services\SupabaseDatabaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\File;

class ModelUploadController extends Controller
{
    public function index()
    {
        // Initialize Supabase database service
        $supabaseDbService = new SupabaseDatabaseService();
        
        // Get recent uploads from Supabase
        $recentUploads = $supabaseDbService->getRecentUploads(5);
        
        // Convert to collection for compatibility with view
        if ($recentUploads === false) {
            $recentUploads = collect([]);
        } else {
            $recentUploads = collect($recentUploads);
        }

        return view('admin.model-upload.index', compact('recentUploads'));
    }

    public function viewDataset()
    {
        $dataset = Student::orderBy('created_at', 'desc')->paginate(50);
        return view('admin.model-upload.dataset', compact('dataset'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'modelName' => 'required|string',
                'modelFile' => 'required|file|mimes:csv,xlsx,xls|max:10240',
                'uploadToDataset' => 'nullable|boolean'
            ]);

            \Log::info('Model upload started', [
                'modelName' => $request->modelName,
                'fileName' => $request->file('modelFile')->getClientOriginalName()
            ]);

            // Initialize Supabase services
            $supabaseService = new SupabaseStorageService();
            $supabaseDbService = new SupabaseDatabaseService();

            // Create temporary directory for CSV processing
            $tempDir = sys_get_temp_dir() . '/model_upload_' . uniqid();
            if (!File::exists($tempDir)) {
                File::makeDirectory($tempDir, 0755, true, true);
            }

            $file = $request->file('modelFile');
            $tempCsvPath = $tempDir . '/modeltrained.csv';

            // Convert Excel to CSV if needed
            if ($file->getClientMimeType() !== 'text/csv') {
                $spreadsheet = IOFactory::load($file->getPathname());
                $writer = IOFactory::createWriter($spreadsheet, 'Csv');
                $writer->save($tempCsvPath);
            } else {
                $file->move($tempDir, 'modeltrained.csv');
            }

            // Upload CSV to Supabase with consistent filename
            $csvFilename = 'modeltrained.csv';
            \Log::info('Attempting CSV upload', [
                'tempPath' => $tempCsvPath,
                'filename' => $csvFilename
            ]);
            
            // Check if file exists in Supabase and delete it first (for overwrite)
            if ($supabaseService->fileExists($csvFilename)) {
                \Log::info('File exists in Supabase, deleting for overwrite', [
                    'filename' => $csvFilename
                ]);
                $supabaseService->deleteFile($csvFilename);
            }
            
            $csvUploadResult = $supabaseService->uploadFromTemp($tempCsvPath, $csvFilename);
            
            if (!$csvUploadResult) {
                \Log::error('CSV upload failed', [
                    'tempPath' => $tempCsvPath,
                    'filename' => $csvFilename
                ]);
                throw new \Exception('Failed to upload CSV file to Supabase');
            }
            
            \Log::info('CSV upload successful', [
                'filename' => $csvFilename,
                'url' => $csvUploadResult['url']
            ]);
            
            $csvUrl = $csvUploadResult['url'];

            // Create model record in Supabase
            \Log::info('Creating model record in Supabase', [
                'modelName' => $request->modelName,
                'csvFilename' => $csvFilename,
                'csvUrl' => $csvUrl
            ]);
            
            $modelData = [
                'model_name' => $request->modelName,
                'csv_filename' => $csvFilename,
                'csv_url' => $csvUrl,
                'total_alumni' => 0,
                'prediction_accuracy' => 0,
                'employment_rate_forecast_line_image' => '',
                'employment_rate_comparison_image' => '',
                'predicted_employability_by_degree_image' => '',
                'distribution_of_predicted_employment_rates_image' => ''
            ];
            
            $model = $supabaseDbService->insertAlumniPredictionModel($modelData);
            
            if (!$model) {
                throw new \Exception('Failed to create model record in Supabase');
            }
            
            \Log::info('Model record created in Supabase', ['modelId' => $model[0]['id'] ?? 'unknown']);

            // Run Python script with Supabase CSV filename
            $pythonScriptPath = public_path('assets/python/process_model.py');
            
            \Log::info('Running Python script', [
                'scriptPath' => $pythonScriptPath,
                'csvFilename' => $csvFilename
            ]);
            
            // Construct the command to run Python script with CSV filename
            $command = "python3 " . escapeshellarg($pythonScriptPath) . " " . escapeshellarg($csvFilename);
            
            \Log::info('Python command', ['command' => $command]);
            
            $output = shell_exec($command);
            
            \Log::info('Python script output', ['output' => $output]);

            // Check if we should also upload to dataset table
            $datasetUploadResult = null;
            if ($request->input('uploadToDataset', false)) {
                \Log::info('Uploading to dataset table as requested');
                $datasetUploadResult = $this->uploadToDatasetTable($tempCsvPath);
            }

            // Parse the output to find generated files
            $uploadedFiles = [];
            $lines = explode("\n", $output);
            
            foreach ($lines as $line) {
                if (strpos($line, 'SAVED_FILE:') === 0) {
                    $parts = explode(':', $line, 3);
                    if (count($parts) === 3) {
                        $filename = $parts[1];
                        $filepath = $parts[2];
                        
                        // Upload to Supabase
                        $uploadResult = $supabaseService->uploadFromTemp($filepath, $filename);
                        
                        if ($uploadResult) {
                            $uploadedFiles[] = [
                                'filename' => $filename,
                                'url' => $uploadResult['url']
                            ];
                            
                            // Clean up temporary file
                            if (file_exists($filepath)) {
                                unlink($filepath);
                            }
                        }
                    }
                }
            }

            // Clean up temporary directory and files
            if (File::exists($tempDir)) {
                File::deleteDirectory($tempDir);
            }
            
            // Clean up temporary CSV file
            if (File::exists($tempCsvPath)) {
                File::delete($tempCsvPath);
            }

            // Clean the output to remove any non-UTF-8 characters
            $cleanOutput = '';
            if ($output) {
                // Remove any non-UTF-8 characters and limit length
                $cleanOutput = mb_convert_encoding($output, 'UTF-8', 'UTF-8');
                $cleanOutput = preg_replace('/[^\x{0009}\x{000A}\x{000D}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}\x{10000}-\x{10FFFF}]/u', '', $cleanOutput);
                $cleanOutput = substr($cleanOutput, 0, 10000); // Limit to 10KB
            }

            $responseData = [
                'modelName' => $request->modelName,
                'csvFile' => [
                    'filename' => $csvFilename,
                    'url' => $csvUrl
                ],
                'output' => $cleanOutput,
                'uploadedFiles' => $uploadedFiles
            ];

            // Add dataset upload results if applicable
            if ($datasetUploadResult) {
                $responseData['datasetUpload'] = $datasetUploadResult;
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Model uploaded successfully' . ($datasetUploadResult ? ' and dataset table updated' : ''),
                'data' => $responseData
            ]);

        } catch (\Exception $e) {
            \Log::error('Model upload error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Model uploaded successfully'
            ]);
        }
    }

    public function addData(Request $request)
    {
        try {
            \Log::info('Add data request received - syncing from users table');

            // Initialize Supabase services
            $supabaseDbService = new SupabaseDatabaseService();

            // Get the latest model from Supabase
            $latestModel = $supabaseDbService->getLatestModel();
            if (!$latestModel) {
                throw new \Exception('No existing model found. Please upload a model first.');
            }

            // Sync data from users table to dataset table
            $syncResult = $this->syncUsersToDataset();

            if ($syncResult['status'] !== 'success') {
                throw new \Exception($syncResult['message']);
            }

            // Update the model record with new total alumni count
            $currentTotal = $latestModel['total_alumni'] ?? 0;
            $newTotal = $currentTotal + $syncResult['newRecordsCount'];
            
            $updateData = [
                'total_alumni' => $newTotal,
                'last_updated' => now()->toISOString()
            ];
            
            $supabaseDbService->updateAlumniPredictionModel($latestModel['id'], $updateData);

            return response()->json([
                'status' => 'success',
                'message' => "Successfully synced {$syncResult['newRecordsCount']} new records and updated {$syncResult['updatedRecordsCount']} existing records. Total alumni count updated to {$newTotal}.",
                'data' => [
                    'modelName' => $latestModel['model_name'],
                    'newRecordsCount' => $syncResult['newRecordsCount'],
                    'updatedRecordsCount' => $syncResult['updatedRecordsCount'],
                    'previousTotal' => $currentTotal,
                    'newTotal' => $newTotal
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Add data error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    private function syncUsersToDataset()
    {
        try {
            \Log::info('Starting users to dataset sync');

            // Get all users with skills_completed = true
            $users = User::where('skills_completed', true)
                ->where('role', 'user')
                ->get();

            if ($users->isEmpty()) {
                return [
                    'status' => 'warning',
                    'message' => 'No users found with completed skills profiles.',
                    'newRecordsCount' => 0,
                    'updatedRecordsCount' => 0
                ];
            }

            \Log::info('Found users with completed skills', ['count' => $users->count()]);

            $newRecordsCount = 0;
            $updatedRecordsCount = 0;
            $errors = [];

            // Start database transaction
            DB::beginTransaction();

            try {
                foreach ($users as $user) {
                    try {
                        // Calculate employability based on user's academic performance and skills
                        $employabilityStatus = $this->calculateEmployabilityStatus($user);
                        
                        // Map user data to dataset structure
                        $datasetData = [
                            'student_number' => $user->student_id ?? $user->id,
                            'gender' => 'Male', // Default value since users table doesn't have gender column
                            'age' => $user->age ?? 0,
                            'degree' => $user->degree_name ?? 'Not Specified',
                            'year_graduated' => $user->year_graduated ?? date('Y'),
                            'cgpa' => $user->average_grade ?? 0,
                            'average_prof_grade' => $user->average_prof_grade ?? 0,
                            'average_elec_grade' => $user->average_elec_grade ?? 0,
                            'ojt_grade' => $user->ojt_grade ?? 0,
                            'leadership_pos' => $user->leadership ? 'Yes' : 'No',
                            'act_member_pos' => $user->act_member ? 'Yes' : 'No',
                            'soft_skills_ave' => $user->soft_skills_ave ?? 0,
                            'hard_skills_ave' => $user->hard_skills_ave ?? 0,
                            'employability' => $employabilityStatus,
                            'board_passer' => $user->is_board_passer ?? false,
                            'created_at' => now(),
                            'updated_at' => now()
                        ];

                        // Add all skill columns
                        $skillColumns = [
                            'auditing_skills', 'budgeting_analysis_skills', 'classroom_management_skills',
                            'cloud_computing_skills', 'curriculum_development_skills', 'data_structures_algorithms',
                            'database_management_skills', 'educational_technology_skills', 'financial_accounting_skills',
                            'financial_management_skills', 'java_programming_skills', 'leadership_decision_making_skills',
                            'machine_learning_skills', 'marketing_skills', 'networking_skills', 'programming_logic_skills',
                            'python_programming_skills', 'software_engineering_skills', 'strategic_planning_skills',
                            'system_design_skills', 'taxation_skills', 'teaching_skills', 'web_development_skills',
                            'statistical_analysis_skills', 'english_communication_writing_skills', 'filipino_communication_writing_skills',
                            'early_childhood_education_skills', 'customer_service_skills', 'event_management_skills',
                            'food_beverage_management_skills', 'risk_management_skills', 'innovation_business_planning_skills',
                            'consumer_behavior_analysis', 'sales_management_skills', 'artificial_intelligence_skills',
                            'cybersecurity_skills', 'circuit_design_skills', 'communication_systems_skills',
                            'problem_solving_skills', 'clinical_skills', 'patient_care_skills',
                            'health_assessment_skills', 'emergency_response_skills'
                        ];

                        foreach ($skillColumns as $skillColumn) {
                            $datasetData[$skillColumn] = $user->$skillColumn ?? null;
                        }

                        // Check if record exists
                        $existingRecord = Student::where('student_number', $datasetData['student_number'])->first();

                        if ($existingRecord) {
                            // Update existing record
                            $existingRecord->update($datasetData);
                            $updatedRecordsCount++;
                            \Log::info('Updated existing dataset record', ['student_number' => $datasetData['student_number']]);
                        } else {
                            // Create new record
                            Student::create($datasetData);
                            $newRecordsCount++;
                            \Log::info('Created new dataset record', ['student_number' => $datasetData['student_number']]);
                        }

                    } catch (\Exception $e) {
                        $errors[] = "User ID {$user->id}: " . $e->getMessage();
                        \Log::error('Error processing user', [
                            'userId' => $user->id,
                            'error' => $e->getMessage()
                        ]);
                    }
                }

                // Reset skills_completed flag for all synced users
                $syncedUserIds = $users->pluck('id')->toArray();
                User::whereIn('id', $syncedUserIds)->update(['skills_completed' => false]);
                
                \Log::info('Reset skills_completed flag for synced users', [
                    'userIds' => $syncedUserIds
                ]);

                // Commit transaction
                DB::commit();

                \Log::info('Users to dataset sync completed', [
                    'newRecords' => $newRecordsCount,
                    'updatedRecords' => $updatedRecordsCount,
                    'errors' => count($errors),
                    'usersReset' => count($syncedUserIds)
                ]);

                return [
                    'status' => 'success',
                    'message' => 'Successfully synced users data to dataset table and reset skills completion flags.',
                    'newRecordsCount' => $newRecordsCount,
                    'updatedRecordsCount' => $updatedRecordsCount,
                    'errors' => $errors
                ];

            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }

        } catch (\Exception $e) {
            \Log::error('Users to dataset sync error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'status' => 'error',
                'message' => 'Failed to sync users data: ' . $e->getMessage()
            ];
        }
    }

    private function calculateEmployabilityStatus($user)
    {
        // Calculate employability based on academic performance and skills
        $cgpa = $user->average_grade ?? 0;
        $profGrade = $user->average_prof_grade ?? 0;
        $elecGrade = $user->average_elec_grade ?? 0;
        $ojtGrade = $user->ojt_grade ?? 0;
        $softSkills = $user->soft_skills_ave ?? 0;
        $hardSkills = $user->hard_skills_ave ?? 0;

        // Weighted average calculation (same logic as in ReportController)
        $probability = (
            ($cgpa * 0.25) +
            ($profGrade * 0.20) +
            ($elecGrade * 0.15) +
            ($ojtGrade * 0.15) +
            ($softSkills * 0.15) +
            ($hardSkills * 0.10)
        );

        // Convert probability to employability status
        return $probability >= 50 ? 'Employable' : 'Less Employable';
    }

    private function uploadToDatasetTable($csvPath)
    {
        try {
            \Log::info('Starting dataset table upload', ['csvPath' => $csvPath]);

            // Read CSV file
            $csvData = [];
            if (($handle = fopen($csvPath, 'r')) !== FALSE) {
                $header = fgetcsv($handle); // Skip header row
                \Log::info('CSV Header', ['header' => $header]);
                
                $rowCount = 0;
                while (($data = fgetcsv($handle)) !== FALSE) {
                    $csvData[] = $data;
                    $rowCount++;
                }
                fclose($handle);
                
                \Log::info('CSV Data loaded', ['rowCount' => $rowCount]);
            } else {
                throw new \Exception('Could not read CSV file');
            }

            // Column mapping from CSV headers to database columns
            $columnMapping = [
                'Student Number' => 'student_number',
                'Gender' => 'gender',
                'Age' => 'age',
                'Degree' => 'degree',
                'Year Graduated' => 'year_graduated',
                'CGPA' => 'cgpa',
                'Average Prof Grade' => 'average_prof_grade',
                'Average Elec Grade' => 'average_elec_grade',
                'OJT Grade' => 'ojt_grade',
                'Leadership POS' => 'leadership_pos',
                'Act Member POS' => 'act_member_pos',
                'Soft Skills Ave' => 'soft_skills_ave',
                'Hard Skills Ave' => 'hard_skills_ave',
                'Employability' => 'employability',
                'Auditing Skills' => 'auditing_skills',
                'Budgeting & Analysis Skills' => 'budgeting_analysis_skills',
                'Classroom Management Skills' => 'classroom_management_skills',
                'Cloud Computing Skills' => 'cloud_computing_skills',
                'Curriculum Development Skills' => 'curriculum_development_skills',
                'Data Structures & Algorithms' => 'data_structures_algorithms',
                'Database Management Skills' => 'database_management_skills',
                'Educational Technology Skills' => 'educational_technology_skills',
                'Financial Accounting Skills' => 'financial_accounting_skills',
                'Financial Management Skills' => 'financial_management_skills',
                'Java Programming Skills' => 'java_programming_skills',
                'Leadership & Decision-Making Skills' => 'leadership_decision_making_skills',
                'Machine Learning Skills' => 'machine_learning_skills',
                'Marketing Skills' => 'marketing_skills',
                'Networking Skills' => 'networking_skills',
                'Programming Logic Skills' => 'programming_logic_skills',
                'Python Programming Skills' => 'python_programming_skills',
                'Software Engineering Skills' => 'software_engineering_skills',
                'Strategic Planning Skills' => 'strategic_planning_skills',
                'System Design Skills' => 'system_design_skills',
                'Taxation Skills' => 'taxation_skills',
                'Teaching Skills' => 'teaching_skills',
                'Web Development Skills' => 'web_development_skills',
                'Statistical Analysis Skills' => 'statistical_analysis_skills',
                'English Communication & Writing Skills' => 'english_communication_writing_skills',
                'Filipino Communication & Writing Skills' => 'filipino_communication_writing_skills',
                'Early Childhood Education Skills' => 'early_childhood_education_skills',
                'Customer Service Skills' => 'customer_service_skills',
                'Event Management Skills' => 'event_management_skills',
                'Food & Beverage Management Skills' => 'food_beverage_management_skills',
                'Risk Management Skills' => 'risk_management_skills',
                'Innovation & Business Planning Skills' => 'innovation_business_planning_skills',
                'Consumer Behavior Analysis' => 'consumer_behavior_analysis',
                'Sales Management Skills' => 'sales_management_skills',
                'Artificial Intelligence Skills' => 'artificial_intelligence_skills',
                'Cybersecurity Skills' => 'cybersecurity_skills',
                'Circuit Design Skills' => 'circuit_design_skills',
                'Communication Systems Skills' => 'communication_systems_skills',
                'Problem-Solving Skills' => 'problem_solving_skills',
                'Clinical Skills' => 'clinical_skills',
                'Patient Care Skills' => 'patient_care_skills',
                'Health Assessment Skills' => 'health_assessment_skills',
                'Emergency Response Skills' => 'emergency_response_skills',
                'Board Passer' => 'board_passer'
            ];

            // Start database transaction
            DB::beginTransaction();

            try {
                // Truncate the dataset table
                \Log::info('Truncating dataset table');
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                DB::table('dataset')->truncate();
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');

                $insertedCount = 0;
                $errorCount = 0;
                $errors = [];

                // Process each row
                foreach ($csvData as $rowIndex => $row) {
                    try {
                        $studentData = [];
                        
                        // Map CSV columns to database columns
                        foreach ($columnMapping as $csvColumn => $dbColumn) {
                            $columnIndex = array_search($csvColumn, $header);
                            if ($columnIndex !== false && isset($row[$columnIndex])) {
                                $value = trim($row[$columnIndex]);
                                
                                // Handle empty values
                                if ($value === '' || $value === null) {
                                    $studentData[$dbColumn] = null;
                                    continue;
                                }
                                
                                // Convert data types based on column type
                                switch ($dbColumn) {
                                    case 'age':
                                    case 'year_graduated':
                                        $studentData[$dbColumn] = is_numeric($value) ? (int) $value : null;
                                        break;
                                    
                                    case 'cgpa':
                                    case 'average_prof_grade':
                                    case 'average_elec_grade':
                                    case 'ojt_grade':
                                    case 'soft_skills_ave':
                                    case 'hard_skills_ave':
                                        $studentData[$dbColumn] = is_numeric($value) ? (float) $value : null;
                                        break;
                                    
                                    case 'employability':
                                        $studentData[$dbColumn] = $value; // Keep as string
                                        break;
                                    
                                    case 'board_passer':
                                        $studentData[$dbColumn] = in_array(strtolower($value), ['yes', '1', 'true', 'y']) ? true : false;
                                        break;
                                    
                                    case 'leadership_pos':
                                    case 'act_member_pos':
                                        $studentData[$dbColumn] = $value;
                                        break;
                                    
                                    default:
                                        // Handle all skill columns and other numeric fields
                                        if (strpos($dbColumn, '_skills') !== false || 
                                            in_array($dbColumn, ['consumer_behavior_analysis', 'data_structures_algorithms'])) {
                                            $studentData[$dbColumn] = is_numeric($value) ? (float) $value : null;
                                        } else {
                                            $studentData[$dbColumn] = $value;
                                        }
                                        break;
                                }
                            }
                        }

                        // Validate required fields
                        if (empty($studentData['student_number']) || empty($studentData['gender']) || 
                            empty($studentData['degree']) || empty($studentData['year_graduated'])) {
                            $errors[] = "Row " . ($rowIndex + 2) . ": Missing required fields (Student Number, Gender, Degree, Year Graduated)";
                            $errorCount++;
                            continue;
                        }

                        // Create student record
                        Student::create($studentData);
                        $insertedCount++;

                        // Log progress every 100 records
                        if ($insertedCount % 100 === 0) {
                            \Log::info('Dataset upload progress', ['inserted' => $insertedCount]);
                        }

                    } catch (\Exception $e) {
                        $errors[] = "Row " . ($rowIndex + 2) . ": " . $e->getMessage();
                        $errorCount++;
                        \Log::error('Error processing row', [
                            'rowIndex' => $rowIndex + 2,
                            'error' => $e->getMessage()
                        ]);
                    }
                }

                // Commit transaction
                DB::commit();

                \Log::info('Dataset upload completed', [
                    'inserted' => $insertedCount,
                    'errors' => $errorCount,
                    'totalRows' => count($csvData)
                ]);

                return [
                    'status' => 'success',
                    'insertedCount' => $insertedCount,
                    'errorCount' => $errorCount,
                    'totalRows' => count($csvData),
                    'errors' => $errors
                ];

            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }

        } catch (\Exception $e) {
            \Log::error('Dataset upload error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'status' => 'error',
                'message' => 'Failed to upload dataset: ' . $e->getMessage()
            ];
        }
    }

}
