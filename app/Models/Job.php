<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $table = 'job_listings';

    protected $fillable = [
        'title',
        'company_id',
        'location',
        'job_type',
        'salary_min',
        'salary_max',
        'currency',
        'job_description',
        'application_link',
        'responsibilities',
        'qualifications',
        'benefits',
        'industry',
        'posted_at',
        'expires_at'
    ];

    protected $casts = [
        'posted_at' => 'datetime',
        'expires_at' => 'datetime',
        'salary_min' => 'decimal:2',
        'salary_max' => 'decimal:2',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'saved_jobs')
            ->withTimestamps()
            ->withPivot('saved_at');
    }
} 