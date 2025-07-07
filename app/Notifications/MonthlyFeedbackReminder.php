<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MonthlyFeedbackReminder extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Monthly Feedback Reminder')
            ->line('Hello ' . $notifiable->name . ',')
            ->line('We noticed you haven\'t submitted your feedback this month.')
            ->line('Your feedback helps us improve our platform and helps future alumni.')
            ->action('Submit Feedback', route('feedback.index'))
            ->line('Thank you for being part of our community!');
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Monthly Feedback Reminder',
            'message' => 'Please take a moment to submit your feedback for this month.',
            'action_url' => route('feedback.index'),
        ];
    }
}
