<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlumniPredictionModel;
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

            // Clear existing files in the public data directory
            $publicDataPath = public_path('assets/data');
            if (File::exists($publicDataPath)) {
                File::cleanDirectory($publicDataPath);
            } else {
                File::makeDirectory($publicDataPath, 0755, true, true);
            }

            $file = $request->file('modelFile');
            $publicFilePath = $publicDataPath . '/modeltrained.csv';

            // Convert Excel to CSV if needed
            if ($file->getClientMimeType() !== 'text/csv') {
                $spreadsheet = IOFactory::load($file->getPathname());
                $writer = IOFactory::createWriter($spreadsheet, 'Csv');
                $writer->save($publicFilePath);
            } else {
                $file->move($publicDataPath, 'modeltrained.csv');
            }

            // Create model record
            $model = AlumniPredictionModel::create([
                'model_name' => $request->modelName,
                'total_alumni' => 0,
                'prediction_accuracy' => 0,
                'employment_rate_forecast_line_image' => '',
                'employment_rate_comparison_image' => '',
                'predicted_employability_by_degree_image' => '',
                'distribution_of_predicted_employment_rates_image' => ''
            ]);

            // Run Python script with full path
            $figuresPath = public_path('assets/figures'); // Path for saving figures
            $csvPath = public_path('assets/data/modeltrained.csv'); // Updated path for reading CSV

            // Construct the command to run Python script
            $command = "python3 " 
                . public_path('assets/python/process_model.py') . " "
                . escapeshellarg($figuresPath) . " "
                . escapeshellarg($csvPath);

            $output = shell_exec($command);

            return response()->json([
                'status' => 'success',
                'message' => 'Model uploaded successfully',
                'data' => [
                    'modelName' => $request->modelName,
                    'output' => $output,
                    'graphs' => [] 
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'success',
                'message' => 'Model uploaded successfully'
            ], 500);
        }
    }
}
