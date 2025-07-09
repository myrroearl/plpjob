<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class StudentForecastController extends Controller
{
    public function index()
    {
        $detailedPredictionsFile = public_path('assets/predictions/detailed_predictions.txt');
        $csvPredictionsFile = public_path('assets/predictions/student_employability_predictions.csv');

        $detailedPredictions = file_exists($detailedPredictionsFile) ? file_get_contents($detailedPredictionsFile) : '';
        $csvData = [];

        if (file_exists($csvPredictionsFile)) {
            if (($handle = fopen($csvPredictionsFile, 'r')) !== FALSE) {
                $header = fgetcsv($handle);
                while (($data = fgetcsv($handle)) !== FALSE) {
                    $csvData[] = array_combine($header, $data);
                }
                fclose($handle);
            }
        }

        $highProbabilityCount = 0;
        $mediumProbabilityCount = 0;
        $lowProbabilityCount = 0;

        foreach ($csvData as $row) {
            $probability = $row['Employability_Probability'];

            if ($probability >= 75) {
                $highProbabilityCount++;
            } elseif ($probability >= 50) {
                $mediumProbabilityCount++;
            } else {
                $lowProbabilityCount++;
            }
        }

        return view('admin.student-forecast.index', compact('csvData', 'highProbabilityCount', 'mediumProbabilityCount', 'lowProbabilityCount'));
    }

    public function processPrediction(Request $request)
    {
        try {
            if (!$request->hasFile('csvFile')) {
                throw new \Exception('No file was uploaded');
            }

            $file = $request->file('csvFile');
            $predictDir = storage_path('app/public/predictions/');
            Storage::makeDirectory('predictions');

            $destination = $predictDir . 'student_predict.csv';
            $file->move($predictDir, 'student_predict.csv');

            $csvPath = storage_path('app/private/data/modeltrained.csv'); // Path for reading CSV
            $predictionsPath = storage_path('app/public/predictions'); // Path for saving figures

            // Construct the command to run Python script
            $command = "C:\Users\Rommel\AppData\Local\Programs\Python\Python312\python.exe " 
                . base_path('storage/app/python/predictions.py') . " "
                . escapeshellarg($csvPath). " "
                . escapeshellarg($predictionsPath);

            $output = shell_exec($command);

            return response()->json(['status' => 'success', 'message' => 'File uploaded and processed successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
} 
