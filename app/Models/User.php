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
        'student_id',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'password',
        'degree_name',
        'average_grade',
        'average_prof_grade',
        'average_elec_grade',
        'ojt_grade',
        'soft_skills_ave',
        'hard_skills_ave',
        'age',
        'act_member',
        'leadership',
        'role',
        'is_board_passer',
        'board_exam_name',
        'board_exam_year',
        'license_number',
        'year_graduated',
        'average_prof_grade',
        'average_elec_grade',
        'ojt_grade',
        'soft_skills_ave',
        'hard_skills_ave',
        'auditing_skills',
        'budgeting_analysis_skills',
        'classroom_management_skills',
        'cloud_computing_skills',
        'curriculum_development_skills',
        'data_structures_algorithms',
        'database_management_skills',
        'educational_technology_skills',
        'financial_accounting_skills',
        'financial_management_skills',
        'java_programming_skills',
        'leadership_decision_making_skills',
        'machine_learning_skills',
        'marketing_skills',
        'networking_skills',
        'programming_logic_skills',
        'python_programming_skills',
        'software_engineering_skills',
        'strategic_planning_skills',
        'system_design_skills',
        'taxation_skills',
        'teaching_skills',
        'web_development_skills',
        'statistical_analysis_skills',
        'english_communication_writing_skills',
        'filipino_communication_writing_skills',
        'early_childhood_education_skills',
        'customer_service_skills',
        'event_management_skills',
        'food_beverage_management_skills',
        'risk_management_skills',
        'innovation_business_planning_skills',
        'consumer_behavior_analysis',
        'sales_management_skills',
        'artificial_intelligence_skills',
        'cybersecurity_skills',
        'circuit_design_skills',
        'communication_systems_skills',
        'problem_solving_skills',
        'clinical_skills',
        'patient_care_skills',
        'health_assessment_skills',
        'emergency_response_skills',
        'skills_completed'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'act_member' => 'boolean',
        'leadership' => 'boolean',
        'is_board_passer' => 'boolean',
        'skills_completed' => 'boolean',
        'age' => 'integer',
        'board_exam_year' => 'integer',
        'year_graduated' => 'integer',
        'average_grade' => 'decimal:2',
        'average_prof_grade' => 'decimal:2',
        'average_elec_grade' => 'decimal:2',
        'ojt_grade' => 'decimal:2',
        'soft_skills_ave' => 'decimal:2',
        'hard_skills_ave' => 'decimal:2',
        'auditing_skills' => 'decimal:2',
        'budgeting_analysis_skills' => 'decimal:2',
        'classroom_management_skills' => 'decimal:2',
        'cloud_computing_skills' => 'decimal:2',
        'curriculum_development_skills' => 'decimal:2',
        'data_structures_algorithms' => 'decimal:2',
        'database_management_skills' => 'decimal:2',
        'educational_technology_skills' => 'decimal:2',
        'financial_accounting_skills' => 'decimal:2',
        'financial_management_skills' => 'decimal:2',
        'java_programming_skills' => 'decimal:2',
        'leadership_decision_making_skills' => 'decimal:2',
        'machine_learning_skills' => 'decimal:2',
        'marketing_skills' => 'decimal:2',
        'networking_skills' => 'decimal:2',
        'programming_logic_skills' => 'decimal:2',
        'python_programming_skills' => 'decimal:2',
        'software_engineering_skills' => 'decimal:2',
        'strategic_planning_skills' => 'decimal:2',
        'system_design_skills' => 'decimal:2',
        'taxation_skills' => 'decimal:2',
        'teaching_skills' => 'decimal:2',
        'web_development_skills' => 'decimal:2',
        'statistical_analysis_skills' => 'decimal:2',
        'english_communication_writing_skills' => 'decimal:2',
        'filipino_communication_writing_skills' => 'decimal:2',
        'early_childhood_education_skills' => 'decimal:2',
        'customer_service_skills' => 'decimal:2',
        'event_management_skills' => 'decimal:2',
        'food_beverage_management_skills' => 'decimal:2',
        'risk_management_skills' => 'decimal:2',
        'innovation_business_planning_skills' => 'decimal:2',
        'consumer_behavior_analysis' => 'decimal:2',
        'sales_management_skills' => 'decimal:2',
        'artificial_intelligence_skills' => 'decimal:2',
        'cybersecurity_skills' => 'decimal:2',
        'circuit_design_skills' => 'decimal:2',
        'communication_systems_skills' => 'decimal:2',
        'problem_solving_skills' => 'decimal:2',
        'clinical_skills' => 'decimal:2',
        'patient_care_skills' => 'decimal:2',
        'health_assessment_skills' => 'decimal:2',
        'emergency_response_skills' => 'decimal:2'
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
        'license_number' => null,
        'year_graduated' => null,
        'average_prof_grade' => null,
        'average_elec_grade' => null,
        'ojt_grade' => null,
        'soft_skills_ave' => null,
        'hard_skills_ave' => null,
        'skills_completed' => false
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
