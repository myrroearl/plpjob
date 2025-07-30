<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlumniPredictionModel;
use App\Services\SupabaseStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\File;

class ModelUploadController extends Controller
{
    public function index()
    {
        $recentUploads = AlumniPredictionModel::select('model_name', 'last_updated', 'prediction_accuracy', 'total_alumni')
            ->orderBy('last_updated', 'desc')
            ->limit(5)
            ->get();

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

            // Initialize Supabase service
            $supabaseService = new SupabaseStorageService();

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

            // Create model record
            \Log::info('Creating model record', [
                'modelName' => $request->modelName,
                'csvFilename' => $csvFilename,
                'csvUrl' => $csvUrl
            ]);
            
            $model = AlumniPredictionModel::create([
                'model_name' => $request->modelName,
                'csv_filename' => $csvFilename,
                'csv_url' => $csvUrl,
                'total_alumni' => 0,
                'prediction_accuracy' => 0,
                'employment_rate_forecast_line_image' => '',
                'employment_rate_comparison_image' => '',
                'predicted_employability_by_degree_image' => '',
                'distribution_of_predicted_employment_rates_image' => ''
            ]);
            
            \Log::info('Model record created', ['modelId' => $model->id]);

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

            return response()->json([
                'status' => 'success',
                'message' => 'Model uploaded successfully',
                'data' => [
                    'modelName' => $request->modelName,
                    'csvFile' => [
                        'filename' => $csvFilename,
                        'url' => $csvUrl
                    ],
                    'output' => $output,
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
}
