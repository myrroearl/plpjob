<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlumniPredictionModel;
use App\Services\SupabaseDatabaseService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch the latest model data from Supabase
        $supabaseDbService = new SupabaseDatabaseService();
        $modelData = $supabaseDbService->getLatestAlumniPredictionModel();

        // If no data exists, provide default values
        if (!$modelData) {
            $modelData = [
                'total_alumni' => 0,
                'actual_rate' => 0,
                'prediction_accuracy' => 0,
                'margin_of_error' => 0
            ];
        }

        return view('admin.dashboard.index', compact('modelData'));
    }
} 
