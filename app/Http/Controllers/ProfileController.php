<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            
            $user = $request->user();
            $passwordChanged = false;
    
            // Handle password update if password fields are filled
            if ($request->filled('current_password') || $request->filled('new_password')) {
                // Validate password fields
                $passwordValidated = $request->validate([
                    'current_password' => ['required', 'string'],
                    'new_password' => ['required', 'string', 'min:8', 'confirmed'],
                    'new_password_confirmation' => ['required', 'string'],
                ]);
    
                // Check if current password matches
                if ($request->current_password != $user->password) {
                    throw ValidationException::withMessages([
                        'current_password' => ['The provided password does not match your current password.']
                    ]);
                }
    
                // Update password
                $user->password = $request->new_password;
                $passwordChanged = true;
            }
    
            // Prepare validation rules
            $rules = [
                'age' => ['required', 'integer', 'min:1', 'max:150'],
                'average_grade' => ['required', 'numeric', 'min:0', 'max:100'],
                'average_prof_grade' => ['nullable', 'numeric', 'min:0', 'max:100'],
                'average_elec_grade' => ['nullable', 'numeric', 'min:0', 'max:100'],
                'ojt_grade' => ['nullable', 'numeric', 'min:0', 'max:100'],
                'soft_skills_ave' => ['nullable', 'numeric', 'min:0', 'max:100'],
                'hard_skills_ave' => ['nullable', 'numeric', 'min:0', 'max:100'],
                'skills_completed' => ['nullable', 'boolean'],
            ];

            // Add skills validation rules based on user's degree
            $userDegree = $user->degree_name;
            $skillsToValidate = $this->getSkillsForDegree($userDegree);
            
            foreach ($skillsToValidate as $skillKey => $skillName) {
                $rules[$skillKey] = ['nullable', 'integer', 'min:1', 'max:5'];
            }
    
            // Add conditional validation rules for board passer fields
            if ($request->has('is_board_passer')) {
                $rules['board_exam_name'] = ['required', 'string', 'max:255'];
                $rules['board_exam_year'] = ['required', 'integer', 'min:1900', 'max:' . date('Y')];
                $rules['license_number'] = ['required', 'string', 'max:255'];
            } else {
                $rules['board_exam_name'] = ['nullable', 'string', 'max:255'];
                $rules['board_exam_year'] = ['nullable', 'integer', 'min:1900', 'max:' . date('Y')];
                $rules['license_number'] = ['nullable', 'string', 'max:255'];
            }
    
            // Validate fields
            $validated = $request->validate($rules);
    
            // Prepare user data for update
            $userData = [
                'age' => $validated['age'],
                'average_grade' => $validated['average_grade'],
                'average_prof_grade' => $validated['average_prof_grade'],
                'average_elec_grade' => $validated['average_elec_grade'],
                'ojt_grade' => $validated['ojt_grade'],
                'soft_skills_ave' => $validated['soft_skills_ave'],
                'hard_skills_ave' => $validated['hard_skills_ave'],
                'act_member' => $request->has('act_member'),
                'leadership' => $request->has('leadership'),
                'is_board_passer' => $request->has('is_board_passer'),
                'board_exam_name' => $validated['board_exam_name'],
                'board_exam_year' => $validated['board_exam_year'],
                'license_number' => $validated['license_number'],
                'skills_completed' => $request->has('skills_completed')
            ];

            // Add skills data
            foreach ($skillsToValidate as $skillKey => $skillName) {
                if ($request->has($skillKey) && $request->input($skillKey) !== null) {
                    $userData[$skillKey] = $request->input($skillKey);
                }
            }

            // Update user data
            $user->fill($userData);
    
            // Save all changes
            $user->save();
    
            DB::commit();
    
            $message = 'Profile updated successfully!';
            if ($passwordChanged) {
                $message .= ' Your password has been changed.';
            }
    
            return Redirect::route('profile.edit')->with('status', $message);
    
        } catch (ValidationException $e) {
            DB::rollBack();
            return back()
                ->withErrors($e->errors())
                ->withInput($request->except(['current_password', 'new_password', 'new_password_confirmation']));
    
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withErrors(['error' => 'An error occurred while updating your profile: ' . $e->getMessage()])
                ->withInput($request->except(['current_password', 'new_password', 'new_password_confirmation']));
        }
    }

    /**
     * Get the changes made to the profile
     */
    private function getProfileChanges(array $validated, $user): array
    {
        $changes = [];
        
        foreach ($validated as $field => $value) {
            if ($user->$field != $value) {
                $changes[$field] = [
                    'from' => $user->$field,
                    'to' => $value
                ];
            }
        }
        
        return $changes;
    }

    /**
     * Get skills for a specific degree
     */
    private function getSkillsForDegree($userDegree): array
    {
        $skills = [];
        
        // Define skills based on degree
        if (str_contains(strtoupper($userDegree), 'BSIT') || str_contains(strtoupper($userDegree), 'INFORMATION TECHNOLOGY')) {
            $skills = [
                'java_programming_skills' => 'Java Programming Skills',
                'python_programming_skills' => 'Python Programming Skills',
                'web_development_skills' => 'Web Development Skills',
                'database_management_skills' => 'Database Management Skills',
                'software_engineering_skills' => 'Software Engineering Skills',
                'data_structures_algorithms' => 'Data Structures & Algorithms',
                'programming_logic_skills' => 'Programming Logic Skills',
                'system_design_skills' => 'System Design Skills',
                'networking_skills' => 'Networking Skills',
                'cloud_computing_skills' => 'Cloud Computing Skills',
                'artificial_intelligence_skills' => 'Artificial Intelligence Skills',
                'cybersecurity_skills' => 'Cybersecurity Skills',
                'machine_learning_skills' => 'Machine Learning Skills',
                'statistical_analysis_skills' => 'Statistical Analysis Skills',
                'problem_solving_skills' => 'Problem-Solving Skills'
            ];
        } elseif (str_contains(strtoupper($userDegree), 'BSED') || str_contains(strtoupper($userDegree), 'EDUCATION')) {
            if (str_contains(strtoupper($userDegree), 'ENGLISH')) {
                $skills = [
                    'english_communication_writing_skills' => 'English Communication & Writing Skills',
                    'teaching_skills' => 'Teaching Skills',
                    'classroom_management_skills' => 'Classroom Management Skills',
                    'curriculum_development_skills' => 'Curriculum Development Skills',
                    'educational_technology_skills' => 'Educational Technology Skills',
                    'leadership_decision_making_skills' => 'Leadership & Decision-Making Skills',
                    'early_childhood_education_skills' => 'Early Childhood Education Skills',
                    'statistical_analysis_skills' => 'Statistical Analysis Skills',
                    'problem_solving_skills' => 'Problem-Solving Skills'
                ];
            } else {
                $skills = [
                    'teaching_skills' => 'Teaching Skills',
                    'classroom_management_skills' => 'Classroom Management Skills',
                    'curriculum_development_skills' => 'Curriculum Development Skills',
                    'educational_technology_skills' => 'Educational Technology Skills',
                    'leadership_decision_making_skills' => 'Leadership & Decision-Making Skills',
                    'early_childhood_education_skills' => 'Early Childhood Education Skills',
                    'statistical_analysis_skills' => 'Statistical Analysis Skills',
                    'problem_solving_skills' => 'Problem-Solving Skills'
                ];
            }
        } elseif (str_contains(strtoupper($userDegree), 'BSN') || str_contains(strtoupper($userDegree), 'NURSING')) {
            $skills = [
                'clinical_skills' => 'Clinical Skills',
                'patient_care_skills' => 'Patient Care Skills',
                'health_assessment_skills' => 'Health Assessment Skills',
                'emergency_response_skills' => 'Emergency Response Skills',
                'leadership_decision_making_skills' => 'Leadership & Decision-Making Skills',
                'problem_solving_skills' => 'Problem-Solving Skills',
                'statistical_analysis_skills' => 'Statistical Analysis Skills'
            ];
        } elseif (str_contains(strtoupper($userDegree), 'BSA') || str_contains(strtoupper($userDegree), 'ACCOUNTANCY')) {
            $skills = [
                'auditing_skills' => 'Auditing Skills',
                'financial_accounting_skills' => 'Financial Accounting Skills',
                'taxation_skills' => 'Taxation Skills',
                'budgeting_analysis_skills' => 'Budgeting & Analysis Skills',
                'financial_management_skills' => 'Financial Management Skills',
                'leadership_decision_making_skills' => 'Leadership & Decision-Making Skills',
                'problem_solving_skills' => 'Problem-Solving Skills',
                'statistical_analysis_skills' => 'Statistical Analysis Skills'
            ];
        } elseif (str_contains(strtoupper($userDegree), 'BSBA') || str_contains(strtoupper($userDegree), 'BUSINESS')) {
            $skills = [
                'marketing_skills' => 'Marketing Skills',
                'sales_management_skills' => 'Sales Management Skills',
                'customer_service_skills' => 'Customer Service Skills',
                'event_management_skills' => 'Event Management Skills',
                'food_beverage_management_skills' => 'Food & Beverage Management Skills',
                'risk_management_skills' => 'Risk Management Skills',
                'innovation_business_planning_skills' => 'Innovation & Business Planning Skills',
                'consumer_behavior_analysis' => 'Consumer Behavior Analysis',
                'leadership_decision_making_skills' => 'Leadership & Decision-Making Skills',
                'problem_solving_skills' => 'Problem-Solving Skills',
                'statistical_analysis_skills' => 'Statistical Analysis Skills'
            ];
        } elseif (str_contains(strtoupper($userDegree), 'ECE') || str_contains(strtoupper($userDegree), 'ELECTRONICS')) {
            $skills = [
                'circuit_design_skills' => 'Circuit Design Skills',
                'communication_systems_skills' => 'Communication Systems Skills',
                'problem_solving_skills' => 'Problem-Solving Skills',
                'leadership_decision_making_skills' => 'Leadership & Decision-Making Skills',
                'statistical_analysis_skills' => 'Statistical Analysis Skills'
            ];
        } else {
            // Default skills for other degrees
            $skills = [
                'leadership_decision_making_skills' => 'Leadership & Decision-Making Skills',
                'problem_solving_skills' => 'Problem-Solving Skills',
                'statistical_analysis_skills' => 'Statistical Analysis Skills',
                'customer_service_skills' => 'Customer Service Skills',
                'communication_systems_skills' => 'Communication Skills'
            ];
        }
        
        return $skills;
    }
}
