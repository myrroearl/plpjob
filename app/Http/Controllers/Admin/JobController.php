<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Company;
use App\Models\User;
use App\Models\Notification;
use App\Events\NewJobPosted;
use App\Notifications\NewJobPostedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::with('company')->latest()->get();
        $companies = Company::all();
        return view('admin.jobs.index', compact('jobs', 'companies'));
    }

    public function create()
    {
        $companies = Company::all();
        return view('admin.jobs.create', compact('companies'));
    }

    public function store(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'title' => 'required|string',
                'company_id' => 'required|exists:companies,id',
                'location' => 'required|string',
                'job_type' => 'required|string',
                'job_description' => 'required|string',
                'application_link' => 'required|string',
                'responsibilities' => 'required|string',
                'qualifications' => 'required|string',
                'benefits' => 'required|string',
                'industry' => 'required|string',
                'salary_min' => 'required|numeric',
                'salary_max' => 'required|numeric',
                'currency' => 'required|string',
                'expires_at' => 'required|date',
            ]);

            // Create the job
            $job = Job::create($validated);

            // Get all users
            $users = User::all();

            foreach ($users as $user) {
                try {
                    // Using Laravel's notification system properly
                    $notification = [
                        'id' => Str::uuid()->toString(),
                        'type' => 'App\Notifications\NewJobPostedNotification',
                        'notifiable_type' => 'App\Models\User',
                        'notifiable_id' => $user->id,
                        'data' => json_encode([
                            'job_id' => $job->id,
                            'title' => $job->title,
                            'message' => "A new job opportunity has been posted: {$job->title} at {$job->company->name}",
                        ]),
                        'created_at' => now(),
                        'updated_at' => now()
                    ];

                    \DB::table('notifications')->insert($notification);

                    // Send email notification with explicit error handling
                    try {
                        Log::info("Attempting to send notification to user: {$user->email}");
                        $user->notify(new NewJobPostedNotification($job));
                        Log::info("Successfully sent notification to user: {$user->email}");
                    } catch (\Exception $e) {
                        Log::error("Email sending failed for user {$user->email}: " . $e->getMessage());
                        Log::error($e->getTraceAsString());
                    }

                } catch (\Exception $e) {
                    Log::error("Failed to notify user {$user->id}: " . $e->getMessage());
                    continue;
                }
            }

            return response()->json([
                'message' => 'Job created successfully',
                'job' => $job
            ]);

        } catch (\Exception $e) {
            Log::error('Job creation error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error creating job',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function edit(Job $job)
    {
        $companies = Company::all();
        return view('admin.jobs.edit', compact('job', 'companies'));
    }

    public function update(Request $request, Job $job)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'location' => 'required|string|max:255',
            'job_type' => 'required|string|max:255',
            'salary_min' => 'required|numeric',
            'salary_max' => 'required|numeric|gte:salary_min',
            'job_description' => 'required|string',
            'qualifications' => 'required|string',
            'responsibilities' => 'required|string',
            'benefits' => 'nullable|string',
            'expires_at' => 'required|date',
        ]);

        $job->update($request->all());

        return redirect()->route('admin.jobs.index')
            ->with('success', 'Job posting updated successfully.');
    }

    public function destroy(Job $job)
    {
        $job->delete();
        return redirect()->route('admin.jobs.index')
            ->with('success', 'Job posting deleted successfully.');
    }
} 