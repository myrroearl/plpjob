<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlumniPredictionModel;
use App\Services\SupabaseStorageService;
use App\Services\SupabaseDatabaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

    public function store(Request $request)
    {
        try {
            $request->validate([
                'modelName' => 'required|string',
                'modelFile' => 'required|file|mimes:csv,xlsx,xls|max:10240'
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

            return response()->json([
                'status' => 'success',
                'message' => 'Model uploaded successfully',
                'data' => [
                    'modelName' => $request->modelName,
                    'csvFile' => [
                        'filename' => $csvFilename,
                        'url' => $csvUrl
                    ],
                    'output' => $cleanOutput,
                    'uploadedFiles' => $uploadedFiles
                ]
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
            $request->validate([
                'dataFile' => 'required|file|mimes:csv,xlsx,xls|max:10240'
            ]);

            \Log::info('Add data request received', [
                'fileName' => $request->file('dataFile')->getClientOriginalName(),
                'fileSize' => $request->file('dataFile')->getSize()
            ]);

            // Initialize Supabase services
            $supabaseDbService = new SupabaseDatabaseService();

            // Get the latest model from Supabase
            $latestModel = $supabaseDbService->getLatestModel();
            if (!$latestModel) {
                throw new \Exception('No existing model found. Please upload a model first.');
            }

            // Create temporary directory for processing
            $tempDir = sys_get_temp_dir() . '/add_data_' . uniqid();
            if (!File::exists($tempDir)) {
                File::makeDirectory($tempDir, 0755, true, true);
            }

            $file = $request->file('dataFile');
            $tempNewDataPath = $tempDir . '/new_data.csv';

            // Convert Excel to CSV if needed
            if ($file->getClientMimeType() !== 'text/csv') {
                $spreadsheet = IOFactory::load($file->getPathname());
                $writer = IOFactory::createWriter($spreadsheet, 'Csv');
                $writer->save($tempNewDataPath);
            } else {
                $file->move($tempDir, 'new_data.csv');
            }

            // Run Python script to count new data records
            $pythonScriptPath = public_path('assets/python/add_data_to_model.py');
            $command = "python3 " . escapeshellarg($pythonScriptPath) . " " . escapeshellarg($tempNewDataPath);
            
            \Log::info('Running Python script to count new data', ['command' => $command]);
            
            $output = shell_exec($command);
            \Log::info('Python script output', ['output' => $output]);

            // Parse the output to get new data count
            $newDataCount = 0;
            $lines = explode("\n", $output);
            
            foreach ($lines as $line) {
                if (strpos($line, 'NEW_DATA_COUNT:') === 0) {
                    $parts = explode(':', $line, 2);
                    if (count($parts) === 2) {
                        $newDataCount = (int) trim($parts[1]);
                        break;
                    }
                }
            }

            if ($newDataCount === 0) {
                throw new \Exception('Failed to count new data records. Please check your file format.');
            }

            // Update the model record with new total alumni count
            $currentTotal = $latestModel['total_alumni'] ?? 0;
            $newTotal = $currentTotal + $newDataCount;
            
            $updateData = [
                'total_alumni' => $newTotal,
                'last_updated' => now()->toISOString()
            ];
            
            $supabaseDbService->updateAlumniPredictionModel($latestModel['id'], $updateData);

            // Clean up temporary files
            if (File::exists($tempDir)) {
                File::deleteDirectory($tempDir);
            }

            return response()->json([
                'status' => 'success',
                'message' => "Successfully added {$newDataCount} new records. Total alumni count updated to {$newTotal}.",
                'data' => [
                    'modelName' => $latestModel['model_name'],
                    'newRecordsCount' => $newDataCount,
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
}
