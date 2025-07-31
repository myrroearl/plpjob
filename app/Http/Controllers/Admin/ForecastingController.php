<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlumniPredictionModel;
use App\Services\SupabaseStorageService;
use App\Services\SupabaseDatabaseService;

class ForecastingController extends Controller
{
    public function index()
    {
        $supabaseDbService = new SupabaseDatabaseService();
        $supabaseService = new SupabaseStorageService();
        
        $modelData = $supabaseDbService->getLatestAlumniPredictionModel();
        
        // If no data exists, provide default values
        if (!$modelData) {
            $modelData = [
                'last_updated' => now(),
                'prediction_accuracy' => 0,
                'total_alumni' => 0,
                'rmse' => 0,
                'mae' => 0,
                'aic' => 0,
                'predicted_rate' => 0,
                'confidence_interval' => 0,
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
        
        return view('admin.forecasting.index', compact('modelData'));
    }
} 
