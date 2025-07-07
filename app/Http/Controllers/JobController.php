<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Company;
use App\Services\JobSearchService;
use App\Models\User;
use App\Notifications\NewJobMatchNotification;
use App\Notifications\NewJobPostedNotification;

use Illuminate\Http\Request;

class JobController extends Controller
{
    public function __construct(
        private JobSearchService $searchService,
        
    ) {}

    public function index(Request $request)
    {
        $query = Job::with('company')->latest('posted_at');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('job_description', 'like', "%{$search}%")
                  ->orWhereHas('company', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Location filter
        if ($request->filled('location')) {
            $location = $request->location;
            $query->where('location', 'like', "%{$location}%");
        }

        // Job type filter (multiple)
        if ($request->filled('types')) {
            $query->whereIn('job_type', $request->types);
        }

        // Experience level filter (multiple)
        if ($request->filled('experience')) {
            $query->whereIn('experience_level', $request->experience);
        }

        // Industry filter
        if ($request->filled('industry')) {
            $query->where('industry', $request->industry);
        }

        // Salary range filter
        if ($request->filled('salary_min')) {
            $query->where('salary_min', '>=', $request->salary_min);
        }
        if ($request->filled('salary_max')) {
            $query->where('salary_max', '<=', $request->salary_max);
        }

        // Sorting
        switch ($request->get('sort', 'latest')) {
            case 'salary_high':
                $query->orderByDesc('salary_max')->orderByDesc('salary_min');
                break;
            case 'salary_low':
                $query->orderBy('salary_min')->orderBy('salary_max');
                break;
            case 'relevant':
                // If using search, sort by relevance
                if ($request->filled('search')) {
                    $query->orderByRaw("
                        CASE 
                            WHEN title LIKE ? THEN 1
                            WHEN job_description LIKE ? THEN 2
                            ELSE 3
                        END", 
                        ["%{$request->search}%", "%{$request->search}%"]
                    );
                }
                break;
            default: // latest
                $query->latest('posted_at');
                break;
        }

        $jobs = $query->paginate(10)->withQueryString();
        $industries = Job::distinct()->pluck('industry')->filter()->values();

        return view('jobs.index', compact('jobs', 'industries'));
    }

    public function show(Job $job)
    {
        $job->load('company');
        $similarJobs = Job::where('industry', $job->industry)
            ->where('id', '!=', $job->id)
            ->take(3)
            ->get();

        return view('jobs.show', compact('job', 'similarJobs'));
    }

    public function savedJobs()
    {
        $savedJobs = auth()->user()->savedJobs()
            ->with('company')
            ->latest('saved_jobs.created_at')
            ->paginate(5);

        return view('jobs.saved', compact('savedJobs'));
    }

    public function saveJob(Job $job)
    {
        auth()->user()->savedJobs()->attach($job->id, [
            'saved_at' => now(),
        ]);

        return back()->with('success', 'Job saved successfully!');
    }

    public function unsaveJob(Job $job)
    {
        auth()->user()->savedJobs()->detach($job->id);

        return back()->with('success', 'Job removed from saved jobs.');
    }

    public function store(Request $request)
    {
        // ... existing job creation code ...

        $job = Job::create($validated);

        // Notify users about the new job
        User::chunk(100, function ($users) use ($job) {
            foreach ($users as $user) {
                if ($this->jobMatchesUserProfile($job, $user)) {
                    $user->notify(new NewJobMatchNotification($job));
                } else {
                    $user->notify(new NewJobPostedNotification($job));
                }
            }
        });

        return redirect()->route('jobs.index')
            ->with('success', 'Job posted successfully!');
    }

    private function jobMatchesUserProfile(Job $job, User $user): bool
    {
        $score = 0;

        // Check degree match
        if ($user->degree_name && str_contains(strtolower($job->qualifications), strtolower($user->degree_name))) {
            $score += 40;
        }

        // Check ACT membership relevance
        if ($user->act_member && str_contains($job->qualifications, 'ACT')) {
            $score += 30;
        }

        // Check leadership match
        if ($user->leadership && (
            str_contains(strtolower($job->title), 'manager') ||
            str_contains(strtolower($job->title), 'leader') ||
            str_contains(strtolower($job->title), 'supervisor')
        )) {
            $score += 30;
        }

        return $score >= 60; // Consider it a match if score is 60 or higher
    }
} 