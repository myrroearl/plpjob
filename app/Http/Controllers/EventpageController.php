<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventpageController extends Controller
{
    public function index()
    {
        
        return view('eventspage');
    }
}