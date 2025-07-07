<?php

namespace App\Listeners;

use App\Events\NewJobPosted;
use App\Models\User;
use App\Models\Notification;

use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyMatchingCandidates implements ShouldQueue
{
  
    public function handle(NewJobPosted $event): void
    {
        // Find matching candidates based on job requirements
        $matchingUsers = User::query()
            ->where('degree_name', 'like', "%{$event->job->required_degree}%")
            ->where('average_grade', '>=', $event->job->min_grade ?? 0)
            ->get();

        // Create notifications for matching candidates
        foreach ($matchingUsers as $user) {
            Notification::create([
                'user_id' => $user->id,
                'type' => 'job_alert',
                'message' => "New job matching your profile: {$event->job->title} at {$event->job->company->name}",
                'data' => [
                    'job_id' => $event->job->id,
                    'company_id' => $event->job->company_id
                ]
            ]);
        }
    }
} 