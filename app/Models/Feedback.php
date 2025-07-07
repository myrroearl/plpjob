<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'employment_status',
        'company_name',
        'position',
        'employment_duration',
        'improvements',
        'additional_comments',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
