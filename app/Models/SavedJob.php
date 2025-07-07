<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class SavedJob extends Pivot
{
    protected $casts = [
        'saved_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
} 