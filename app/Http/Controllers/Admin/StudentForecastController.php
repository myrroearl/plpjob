<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Services\SupabaseStorageService;

class StudentForecastController extends Controller
{
    public function index()
    {
        $supabaseService = new SupabaseStorageService();
        
        // Get files from Supabase instead of local storage
        $detailedPredictions = '';
        $csvData = [];
        
        // Try to get detailed predictions from Supabase
        if ($supabaseService->fileExists('detailed_predictions.txt')) {
            $detailedPredictions = $supabaseService->downloadFile('detailed_predictions.txt');
        }
        
        // Try to get CSV predictions from Supabase
        if ($supabaseService->fileExists('student_employability_predictions.csv')) {
            $csvContent = $supabaseService->downloadFile('student_employability_predictions.csv');
            if ($csvContent) {
                $lines = explode("\n", $csvContent);
                if (count($lines) > 1) {
                    $header = str_getcsv($lines[0]);
                    for ($i = 1; $i < count($lines); $i++) {
                        if (trim($lines[$i]) !== '') {
                            $data = str_getcsv($lines[$i]);
                            if (count($data) === count($header)) {
                                $csvData[] = array_combine($header, $data);
                            }
                        }
                    }
                }
            }
        }

        $highProbabilityCount = 0;
        $mediumProbabilityCount = 0;
        $lowProbabilityCount = 0;

        foreach ($csvData as $row) {
            if (isset($row['Employability_Probability'])) {
                $probability = floatval($row['Employability_Probability']);

                if ($probability >= 75) {
                    $highProbabilityCount++;
                } elseif ($probability >= 50) {
                    $mediumProbabilityCount++;
                } else {
                    $lowProbabilityCount++;
                }
            }
        }

        return view('admin.student-forecast.index', compact('csvData', 'highProbabilityCount', 'mediumProbabilityCount', 'lowProbabilityCount', 'supabaseService'));
    }

    public function processPrediction(Request $request)
    {
        try {
            if (!$request->hasFile('csvFile')) {
                throw new \Exception('No file was uploaded');
            }

            $supabaseService = new SupabaseStorageService();
            $file = $request->file('csvFile');
            
            // Create temporary directory for processing
            $tempDir = sys_get_temp_dir() . '/student_forecast_' . uniqid();
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }

            $tempCsvPath = $tempDir . '/student_predict.csv';
            $file->move($tempDir, 'student_predict.csv');

            // Upload student prediction CSV to Supabase
            $uploadResult = $supabaseService->uploadFromTemp($tempCsvPath, 'student_predict.csv');
            
            if (!$uploadResult) {
                throw new \Exception('Failed to upload student prediction file to Supabase');
            }

            // Construct the command to run Python script
            $command = "C:\Users\Rommel\AppData\Local\Programs\Python\Python312\python.exe " 
                . base_path('storage/app/python/predictions.py') . " "
                . escapeshellarg('modeltrained.csv') . " "  // Use the existing model file in Supabase
                . escapeshellarg($tempDir);  // Pass temp directory for processing

            $output = shell_exec($command);

            // Clean up temporary files
            if (file_exists($tempCsvPath)) {
                unlink($tempCsvPath);
            }
            if (file_exists($tempDir)) {
                rmdir($tempDir);
            }

            return response()->json(['status' => 'success', 'message' => 'File uploaded and processed successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
} 
