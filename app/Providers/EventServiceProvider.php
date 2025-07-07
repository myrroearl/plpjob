<?php

namespace App\Providers;

use App\Events\JobApplicationSubmitted;
use App\Events\NewJobPosted;
use App\Listeners\SendJobApplicationNotification;
use App\Listeners\NotifyMatchingCandidates;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        JobApplicationSubmitted::class => [
            SendJobApplicationNotification::class,
        ],
        NewJobPosted::class => [
            NotifyMatchingCandidates::class,
        ],
    ];

    public function boot(): void
    {
        //
    }
} 