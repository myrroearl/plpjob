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
            \Log::info('Add data request received', [
                'hasFile' => $request->hasFile('dataFile'),
                'allFiles' => $request->allFiles(),
                'allInput' => $request->all()
            ]);

            $request->validate([
                'dataFile' => 'required|file|mimes:csv,xlsx,xls|max:10240'
            ]);

            \Log::info('Add data to existing model started', [
                'fileName' => $request->file('dataFile')->getClientOriginalName(),
                'fileSize' => $request->file('dataFile')->getSize(),
                'mimeType' => $request->file('dataFile')->getMimeType()
            ]);

            // Initialize Supabase services
            $supabaseService = new SupabaseStorageService();
            $supabaseDbService = new SupabaseDatabaseService();

            // Get the latest model from Supabase
            $latestModel = $supabaseDbService->getLatestModel();
            if (!$latestModel) {
                throw new \Exception('No existing model found. Please upload a model first.');
            }

            \Log::info('Latest model found', [
                'modelId' => $latestModel['id'],
                'modelName' => $latestModel['model_name'],
                'csvFilename' => $latestModel['csv_filename']
            ]);

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

            // Run Python script to add data to existing CSV
            $pythonScriptPath = public_path('assets/python/add_data_to_model.py');
            
            \Log::info('Running Python script to add data', [
                'scriptPath' => $pythonScriptPath,
                'existingCsvFilename' => $latestModel['csv_filename'],
                'newDataPath' => $tempNewDataPath
            ]);
            
            // Construct the command to run Python script
            $command = "python3 " . escapeshellarg($pythonScriptPath) . " " . escapeshellarg($latestModel['csv_filename']) . " " . escapeshellarg($tempNewDataPath);
            
            \Log::info('Python command', ['command' => $command]);
            
            $output = shell_exec($command);
            
            \Log::info('Python script output', ['output' => $output]);

            // Parse the output to find the updated CSV file
            $updatedCsvPath = null;
            $lines = explode("\n", $output);
            
            foreach ($lines as $line) {
                if (strpos($line, 'UPDATED_CSV:') === 0) {
                    $parts = explode(':', $line, 2);
                    if (count($parts) === 2) {
                        $updatedCsvPath = $parts[1];
                        break;
                    }
                }
            }

            \Log::info('Python script parsing', [
                'output_lines' => count($lines),
                'updatedCsvPath' => $updatedCsvPath,
                'file_exists' => $updatedCsvPath ? file_exists($updatedCsvPath) : false
            ]);

            if (!$updatedCsvPath || !file_exists($updatedCsvPath)) {
                \Log::error('Failed to generate updated CSV file', [
                    'output' => $output,
                    'updatedCsvPath' => $updatedCsvPath
                ]);
                throw new \Exception('Failed to generate updated CSV file. Check logs for details.');
            }

            // Upload updated CSV to Supabase (overwrite existing)
            $csvUploadResult = $supabaseService->uploadFromTemp($updatedCsvPath, $latestModel['csv_filename']);
            
            if (!$csvUploadResult) {
                \Log::error('Updated CSV upload failed', [
                    'tempPath' => $updatedCsvPath,
                    'filename' => $latestModel['csv_filename']
                ]);
                throw new \Exception('Failed to upload updated CSV file to Supabase');
            }
            
            \Log::info('Updated CSV upload successful', [
                'filename' => $latestModel['csv_filename'],
                'url' => $csvUploadResult['url']
            ]);

            // Update the model record with new data count
            $updateData = [
                'total_alumni' => 0, // Will be updated by Python script
                'last_updated' => now()->toISOString()
            ];
            
            $supabaseDbService->updateAlumniPredictionModel($latestModel['id'], $updateData);

            // Clean up temporary files
            if (File::exists($tempDir)) {
                File::deleteDirectory($tempDir);
            }
            
            if (File::exists($updatedCsvPath)) {
                unlink($updatedCsvPath);
            }

            // Clean the output to remove any non-UTF-8 characters
            $cleanOutput = '';
            if ($output) {
                $cleanOutput = mb_convert_encoding($output, 'UTF-8', 'UTF-8');
                $cleanOutput = preg_replace('/[^\x{0009}\x{000A}\x{000D}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}\x{10000}-\x{10FFFF}]/u', '', $cleanOutput);
                $cleanOutput = substr($cleanOutput, 0, 10000);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Data added to existing model successfully',
                'data' => [
                    'modelName' => $latestModel['model_name'],
                    'updatedCsvFile' => [
                        'filename' => $latestModel['csv_filename'],
                        'url' => $csvUploadResult['url']
                    ],
                    'output' => $cleanOutput
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
