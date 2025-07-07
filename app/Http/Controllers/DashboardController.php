<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
        // Get recommended jobs
        $recommendedJobs = $this->getRecommendedJobs($user);
        
        // Get latest jobs for general display
        $latestJobs = Job::with('company')
            ->orderBy('posted_at', 'desc')
            ->take(5)
            ->get();

        return view('alumnidashboard', [
            'recommendedJobs' => $recommendedJobs,
            'latestJobs' => $latestJobs,
            'user' => $user,
        ]);
    }

    private function getRecommendedJobs(User $user)
    {
        // Get recommendations from saved jobs preferences
        $savedJobsRecommendations = $this->getSavedJobsRecommendations($user);
        
        // Get profile-based recommendations
        $profileRecommendations = Job::with('company')
            ->where('expires_at', '>', now())
            ->whereNotIn('id', $savedJobsRecommendations->pluck('id')) // Exclude jobs already recommended
            ->when($user->degree_name, function ($query, $degree) {
                return $query->where('qualifications', 'LIKE', "%{$degree}%");
            })
            ->when($user->act_member, function ($query) {
                return $query->where('qualifications', 'LIKE', '%ACT%');
            })
            ->when($user->leadership, function ($query) {
                return $query->where(function ($q) {
                    $q->where('title', 'LIKE', '%manager%')
                      ->orWhere('title', 'LIKE', '%leader%')
                      ->orWhere('title', 'LIKE', '%senior%')
                      ->orWhere('title', 'LIKE', '%lead%')
                      ->orWhere('title', 'LIKE', '%general%')
                      ->orWhere('title', 'LIKE', '%supervisor%');
                });
            })
            ->orderBy('posted_at', 'desc')
            ->take(5)
            ->get();

        // Calculate match percentage for profile-based recommendations
        $profileRecommendations->each(function ($job) use ($user) {
            $score = 0;
            
            if ($user->degree_name && str_contains(strtolower($job->qualifications), strtolower($user->degree_name))) {
                $score += 40;
            }
            
            if ($user->act_member && str_contains($job->qualifications, 'ACT')) {
                $score += 30;
            }
            
            if ($user->leadership && (
                str_contains(strtolower($job->title), 'manager') ||
                str_contains(strtolower($job->title), 'leader') ||
                str_contains(strtolower($job->title), 'lead') ||
                str_contains(strtolower($job->title), 'senior') ||
                str_contains(strtolower($job->title), 'general') ||
                str_contains(strtolower($job->title), 'supervisor')
            )) {
                $score += 30;
            }
            
            $job->match_percentage = $score;
        });

        // Combine both sets of recommendations
        return $savedJobsRecommendations->concat($profileRecommendations);
    }

    private function getSavedJobsRecommendations(User $user)
    {
        $savedJobs = $user->savedJobs;

        if ($savedJobs->isEmpty()) {
            return collect([]);
        }

        $preferences = $this->extractPreferences($savedJobs);

        return Job::with('company')
            ->select('job_listings.*')
            ->where('expires_at', '>', now())
            ->whereNotIn('id', $savedJobs->pluck('id'))
            ->addSelect(DB::raw("
                (CASE 
                    WHEN industry = '{$preferences['industry']}' THEN 20 ELSE 0 END +
                    CASE WHEN job_type = '{$preferences['job_type']}' THEN 15 ELSE 0 END +
                    CASE WHEN location = '{$preferences['location']}' THEN 15 ELSE 0 END +
                    CASE 
                        WHEN salary_min BETWEEN {$preferences['salary_min']} AND {$preferences['salary_max']} 
                        OR salary_max BETWEEN {$preferences['salary_min']} AND {$preferences['salary_max']}
                        THEN 10 ELSE 0 END
                ) as match_score"
            ))
            ->orderByDesc('match_score')
            ->take(5)
            ->get()
            ->each(function ($job) {
                // Convert match_score to percentage (out of 60 possible points)
                $job->match_percentage = round(($job->match_score / 60) * 100);
            });
    }

    private function extractPreferences($savedJobs)
    {
        return [
            'industry' => $savedJobs->groupBy('industry')
                ->sortByDesc(function ($group) {
                    return $group->count();
                })
                ->keys()
                ->first() ?? '',
                
            'job_type' => $savedJobs->groupBy('job_type')
                ->sortByDesc(function ($group) {
                    return $group->count();
                })
                ->keys()
                ->first() ?? '',
                
            'location' => $savedJobs->groupBy('location')
                ->sortByDesc(function ($group) {
                    return $group->count();
                })
                ->keys()
                ->first() ?? '',
                
            'salary_min' => $savedJobs->avg('salary_min') ?? 0,
            'salary_max' => $savedJobs->avg('salary_max') ?? 999999,
        ];
    }

    private function getProfileBasedRecommendations(User $user)
    {
        $jobs = Job::with('company')
            ->where('expires_at', '>', now())
            ->when($user->degree_name, function ($query, $degree) {
                return $query->where('qualifications', 'LIKE', "%{$degree}%");
            })
            ->when($user->act_member, function ($query) {
                return $query->where('qualifications', 'LIKE', '%ACT%');
            })
            ->when($user->leadership, function ($query) {
                return $query->where(function ($q) {
                    $q->where('title', 'LIKE', '%manager%')
                      ->orWhere('title', 'LIKE', '%leader%')
                      ->orWhere('title', 'LIKE', '%senior%')
                      ->orWhere('title', 'LIKE', '%lead%')
                      ->orWhere('title', 'LIKE', '%general%')
                      ->orWhere('title', 'LIKE', '%supervisor%');
                });
            })
            ->orderBy('posted_at', 'desc')
            ->take(10)
            ->get();

        // Calculate basic match percentage for profile-based recommendations
        $jobs->each(function ($job) use ($user) {
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
                str_contains(strtolower($job->title), 'lead') ||
                str_contains(strtolower($job->title), 'senior') ||
                str_contains(strtolower($job->title), 'general') ||
                str_contains(strtolower($job->title), 'supervisor')
            )) {
                $score += 30;
            }
            
            $job->match_percentage = $score;
        });

        return $jobs;
    }
} 