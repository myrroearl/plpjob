<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'industry',
        'website',
        'description'
    ];

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
} 