<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlumniPredictionModel;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch the latest model data
        $modelData = AlumniPredictionModel::orderBy('id', 'desc')->first();

        return view('admin.dashboard.index', compact('modelData'));
    }
} 