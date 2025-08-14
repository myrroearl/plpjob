<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Job;

class NewJobMatchNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $job;

    public function __construct(Job $job)
    {
        $this->job = $job;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Job Match Found!')
            ->line('We found a new job that matches your profile:')
            ->line('Company: ' . $this->job->company->name)
            ->line('Position: ' . $this->job->title)
            ->line('Location: ' . $this->job->location)
            ->action('View Job', route('jobs.show', $this->job))
            ->line('Good luck with your application!');
    }

    public function toArray($notifiable)
    {
        return [
            'job_id' => $this->job->id,
            'title' => $this->job->title,
            'company' => $this->job->company->name,
            'type' => 'job_match'
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'job_id' => $this->job->id,
            'title' => $this->job->title,
            'company' => $this->job->company->name,
            'type' => 'job_match'
        ];
    }
} 
