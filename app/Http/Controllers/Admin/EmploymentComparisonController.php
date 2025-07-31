<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlumniPredictionModel;
use App\Services\SupabaseStorageService;
use App\Services\SupabaseDatabaseService;

class EmploymentComparisonController extends Controller
{
    public function index()
    {
        $supabaseDbService = new SupabaseDatabaseService();
        $supabaseService = new SupabaseStorageService();
        
        $modelData = $supabaseDbService->getLatestAlumniPredictionModel();
        
        // If no data exists, provide default values
        if (!$modelData) {
            $modelData = [
                'actual_rate' => 0,
                'predicted_rate' => 0,
                'prediction_accuracy' => 0,
                'margin_of_error' => 0,
                'employment_rate_forecast_line_image' => '',
                'employment_rate_comparison_image' => ''
            ];
        }
        
        // Get public URLs for the images
        if ($modelData['employment_rate_forecast_line_image']) {
            $modelData['employment_rate_forecast_line_url'] = $supabaseService->getPublicUrl($modelData['employment_rate_forecast_line_image']);
        }
        if ($modelData['employment_rate_comparison_image']) {
            $modelData['employment_rate_comparison_url'] = $supabaseService->getPublicUrl($modelData['employment_rate_comparison_image']);
        }
        
        return view('admin.employment-comparison.index', compact('modelData'));
    }
} 
