<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewsArticleController extends Controller
{
    public function index()
    {
        
        return view('news_article');
    }
}