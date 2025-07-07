<?php

namespace App\Models;

use App\Notifications\CustomVerifyEmail;
use App\Notifications\CustomResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;
use Illuminate\Auth\Passwords\CanResetPassword;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, CanResetPassword;

    protected $fillable = [
        'id',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'password',
        'degree_name',
        'average_grade',
        'age',
        'act_member',
        'leadership',
        'role',
        'is_board_passer',
        'board_exam_name',
        'board_exam_year',
        'license_number'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'act_member' => 'boolean',
        'leadership' => 'boolean',
        'is_board_passer' => 'boolean',
        'age' => 'integer',
        'board_exam_year' => 'integer',
        'average_grade' => 'decimal:2'
    ];

    protected $attributes = [
        'act_member' => null,
        'leadership' => null,
        'role' => null,
        'age' => null,
        'average_grade' => null,
        'is_board_passer' => null,
        'board_exam_name' => null,
        'board_exam_year' => null,
        'license_number' => null
    ];

    // Remove password hashing from the model
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = $value;
    }

    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new CustomVerifyEmail);
    }

    public function sendPasswordResetNotification($token)
    {
        $url = url(route('password.reset', [
            'token' => $token,
            'email' => $this->email,
        ], false));

        $this->notify(new \App\Notifications\CustomResetPassword($token, $url));
    }

    public function savedJobs()
    {
        return $this->belongsToMany(Job::class, 'saved_jobs')
                    ->withTimestamps()
                    ->withPivot('saved_at')
                    ->using(SavedJob::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isRecruiter(): bool
    {
        return $this->role === 'recruiter';
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }
}
