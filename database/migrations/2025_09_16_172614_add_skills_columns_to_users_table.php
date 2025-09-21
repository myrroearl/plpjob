<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
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
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
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
            ]);
        });
    }
};
