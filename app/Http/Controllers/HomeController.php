<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured jobs (latest 6 jobs)
        $featuredJobs = Job::with('company')
            ->latest('posted_at')
            ->take(6)
            ->get();

        // Get top industries with job counts
        $topIndustries = Job::select('industry', DB::raw('count(*) as job_count'))
            ->groupBy('industry')
            ->orderByDesc('job_count')
            ->take(4)
            ->get();

        // Get featured companies (those with most jobs)
        $featuredCompanies = Company::withCount('jobs')
            ->orderByDesc('jobs_count')
            ->take(4)
            ->get();

        // Get job statistics
        $statistics = [
            'total_jobs' => Job::count(),
            'total_companies' => Company::count(),
            'jobs_this_month' => Job::where('posted_at', '>=', now()->startOfMonth())->count()
        ];

        return view('welcome', compact(
            'featuredJobs',
            'topIndustries',
            'featuredCompanies',
            'statistics'
        ));
    }
}
