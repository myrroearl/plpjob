<?php

namespace App\Events;

use App\Models\Job;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class JobApplicationSubmitted
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public User $user,
        public Job $job
    ) {}
} 