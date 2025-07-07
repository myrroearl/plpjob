<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CCSDepartmentController extends Controller
{
    public function index()
    {
        
        return view('ccs_academic');
    }
}