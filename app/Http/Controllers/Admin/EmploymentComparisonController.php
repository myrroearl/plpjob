<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlumniPredictionModel;

class EmploymentComparisonController extends Controller
{
    public function index()
    {
        $modelData = AlumniPredictionModel::latest()->first();
        return view('admin.employment-comparison.index', compact('modelData'));
    }
} 