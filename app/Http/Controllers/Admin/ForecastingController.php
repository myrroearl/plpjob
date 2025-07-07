<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlumniPredictionModel;

class ForecastingController extends Controller
{
    public function index()
    {
        $modelData = AlumniPredictionModel::latest()->first();
        return view('admin.forecasting.index', compact('modelData'));
    }
} 