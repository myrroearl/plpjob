<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\Job;

class NewJobPostedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $job;

    public function __construct(Job $job)
    {
        $this->job = $job;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        // Try just mail first to isolate the issue
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        try {
            Log::info('Attempting to send email to: ' . $notifiable->email);
            
            // Get user's name or default to "there" if name is not available
            $userName = $notifiable->first_name ?? $notifiable->username ?? 'there';
            
            return (new MailMessage)
                ->subject('New Job Posted: ' . $this->job->title)
                ->greeting('Hello ' . $userName . '!')
                ->line('A new job has been posted that might interest you:')
                ->line('Company: ' . $this->job->company->name)
                ->line('Position: ' . $this->job->title)
                ->line('Location: ' . $this->job->location)
                ->action('View Job', route('jobs.show', $this->job))
                ->line('Check it out and apply if interested!')
                ->salutation('Best regards, ' . config('app.name'));
        } catch (\Exception $e) {
            Log::error('Email sending failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get the array representation of the notification.
     */
    public function toDatabase($notifiable): array
    {
        return [
            'job_id' => $this->job->id,
            'title' => $this->job->title,
            'message' => "A new job opportunity has been posted: {$this->job->title} at {$this->job->company->name}",
        ];
    }

    /**
     * Handle a notification failure.
     */
    public function failed(\Exception $e)
    {
        Log::error('Notification failed to process: ' . $e->getMessage());
    }
} 