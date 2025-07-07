<?php

namespace App\Listeners;

use App\Events\JobApplicationSubmitted;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendJobApplicationNotification implements ShouldQueue
{
    public function handle(JobApplicationSubmitted $event): void
    {
        Notification::create([
            'user_id' => $event->user->id,
            'type' => 'application_update',
            'message' => "Your application for {$event->job->title} at {$event->job->company->name} has been submitted successfully.",
            'data' => [
                'job_id' => $event->job->id,
                'company_id' => $event->job->company_id
            ]
        ]);
    }
} 