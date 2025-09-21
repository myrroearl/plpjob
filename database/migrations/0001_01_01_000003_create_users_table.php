<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 100);
            $table->string('middle_name', 100);
            $table->string('last_name', 100);
            $table->string('degree_name', 100);
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('age')->nullable();
            $table->decimal('average_grade', 5, 2)->nullable();
            $table->boolean('act_member')->nullable()->default(null);
            $table->boolean('leadership')->nullable()->default(null);
            $table->enum('role', ['user', 'recruiter', 'admin'])->nullable()->default(null);
            // Add board passer columns
            $table->boolean('is_board_passer')->nullable()->default(null);
            $table->string('board_exam_name', 150)->nullable();
            $table->integer('board_exam_year')->nullable();
            $table->string('license_number', 100)->nullable();
            $table->integer('year_graduated')->nullable();
            $table->decimal('average_prof_grade', 4, 2)->nullable();
            $table->decimal('average_elec_grade', 4, 2)->nullable();
            $table->decimal('ojt_grade', 4, 2)->nullable();
            $table->decimal('soft_skills_ave', 4, 2)->nullable();
            $table->decimal('hard_skills_ave', 4, 2)->nullable();
            $table->decimal('auditing_skills', 4, 2)->nullable();
            $table->decimal('budgeting_analysis_skills', 4, 2)->nullable();
            $table->decimal('classroom_management_skills', 4, 2)->nullable();
            $table->decimal('cloud_computing_skills', 4, 2)->nullable();
            $table->decimal('curriculum_development_skills', 4, 2)->nullable();
            $table->decimal('data_structures_algorithms', 4, 2)->nullable();
            $table->decimal('database_management_skills', 4, 2)->nullable();
            $table->decimal('educational_technology_skills', 4, 2)->nullable();
            $table->decimal('financial_accounting_skills', 4, 2)->nullable();
            $table->decimal('financial_management_skills', 4, 2)->nullable();
            $table->decimal('java_programming_skills', 4, 2)->nullable();
            $table->decimal('leadership_decision_making_skills', 4, 2)->nullable();
            $table->decimal('machine_learning_skills', 4, 2)->nullable();
            $table->decimal('marketing_skills', 4, 2)->nullable();
            $table->decimal('networking_skills', 4, 2)->nullable();
            $table->decimal('programming_logic_skills', 4, 2)->nullable();
            $table->decimal('python_programming_skills', 4, 2)->nullable();
            $table->decimal('software_engineering_skills', 4, 2)->nullable();
            $table->decimal('strategic_planning_skills', 4, 2)->nullable();
            $table->decimal('system_design_skills', 4, 2)->nullable();
            $table->decimal('taxation_skills', 4, 2)->nullable();
            $table->decimal('teaching_skills', 4, 2)->nullable();
            $table->decimal('web_development_skills', 4, 2)->nullable();
            $table->decimal('statistical_analysis_skills', 4, 2)->nullable();
            $table->decimal('english_communication_writing_skills', 4, 2)->nullable();
            $table->decimal('filipino_communication_writing_skills', 4, 2)->nullable();
            $table->decimal('early_childhood_education_skills', 4, 2)->nullable();
            $table->decimal('customer_service_skills', 4, 2)->nullable();
            $table->decimal('event_management_skills', 4, 2)->nullable();
            $table->decimal('food_beverage_management_skills', 4, 2)->nullable();
            $table->decimal('risk_management_skills', 4, 2)->nullable();
            $table->decimal('innovation_business_planning_skills', 4, 2)->nullable();
            $table->decimal('consumer_behavior_analysis', 4, 2)->nullable();
            $table->decimal('sales_management_skills', 4, 2)->nullable();
            $table->decimal('artificial_intelligence_skills', 4, 2)->nullable();
            $table->decimal('cybersecurity_skills', 4, 2)->nullable();
            $table->decimal('circuit_design_skills', 4, 2)->nullable();
            $table->decimal('communication_systems_skills', 4, 2)->nullable();
            $table->decimal('problem_solving_skills', 4, 2)->nullable();
            $table->decimal('clinical_skills', 4, 2)->nullable();
            $table->decimal('patient_care_skills', 4, 2)->nullable();
            $table->decimal('health_assessment_skills', 4, 2)->nullable();
            $table->decimal('emergency_response_skills', 4, 2)->nullable();
            $table->boolean('skills_completed')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
