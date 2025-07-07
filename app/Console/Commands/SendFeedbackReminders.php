<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Feedback;
use App\Notifications\MonthlyFeedbackReminder;
use Illuminate\Console\Command;
use Carbon\Carbon;

class SendFeedbackReminders extends Command
{
    protected $signature = 'feedback:send-reminders';
    protected $description = 'Send feedback reminders to users who haven\'t submitted feedback this month';

    public function handle()
    {
        $lastMonth = Carbon::now()->subMonth();

        // Get users who haven't submitted feedback in the last month
        $users = User::whereDoesntHave('feedback', function ($query) use ($lastMonth) {
            $query->where('created_at', '>=', $lastMonth);
        })->get();

        foreach ($users as $user) {
            $user->notify(new MonthlyFeedbackReminder());
        }

        $this->info("Sent reminders to {$users->count()} users.");
    }
}
