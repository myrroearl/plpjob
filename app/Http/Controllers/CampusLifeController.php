<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CampusLifeController extends Controller
{
    public function index()
    {
        
        return view('campus_life');
    }
}