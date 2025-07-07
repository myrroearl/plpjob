<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResearchpageController extends Controller
{
    public function index()
    {
        
        return view('researchpage');
    }
}