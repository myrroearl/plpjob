<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Services\SupabaseStorageService;
use App\Models\User;

class StudentForecastController extends Controller
{
    public function index()
    {
        $supabaseService = new SupabaseStorageService();
        
        // Get students who have completed their skills profile
        $students = User::where('skills_completed', true)
            ->where('role', 'user')
            ->get();

        $csvData = [];
        $highProbabilityCount = 0;
        $mediumProbabilityCount = 0;
        $lowProbabilityCount = 0;

        // Convert user data to CSV format for prediction
        foreach ($students as $student) {
            $studentData = [
                'Student Number' => $student->student_id ?? $student->id,
                'Gender' => $student->gender ?? 'Not Specified',
                'Age' => $student->age ?? 0,
                'Degree' => $student->degree_name ?? 'Not Specified',
                'CGPA' => $student->cgpa ?? 0,
                'Average Prof Grade' => $student->average_prof_grade ?? 0,
                'Average Elec Grade' => $student->average_elec_grade ?? 0,
                'OJT Grade' => $student->ojt_grade ?? 0,
                'Soft Skills Ave' => $student->soft_skills_ave ?? 0,
                'Hard Skills Ave' => $student->hard_skills_ave ?? 0,
                'Year Graduated' => $student->year_graduated ?? date('Y'),
                'Employability' => $student->employability ?? 'Not Assessed',
                'Employability_Probability' => $this->calculateEmployabilityProbability($student),
                'Predicted_Employability' => $this->predictEmployability($student),
                'Predicted_Employment_Rate' => $this->calculateEmploymentRate($student)
            ];

            $csvData[] = $studentData;

            // Count by probability
            $probability = $studentData['Employability_Probability'];
            if ($probability >= 75) {
                $highProbabilityCount++;
            } elseif ($probability >= 50) {
                $mediumProbabilityCount++;
            } else {
                $lowProbabilityCount++;
            }
        }

        return view('admin.student-forecast.index', compact('csvData', 'highProbabilityCount', 'mediumProbabilityCount', 'lowProbabilityCount', 'supabaseService', 'students'));
    }

    public function processPrediction(Request $request)
    {
        try {
            // Get students who have completed their skills profile
            $students = User::where('skills_completed', true)
                ->where('role', 'user')
                ->get();

            if ($students->isEmpty()) {
                return response()->json([
                    'status' => 'warning', 
                    'message' => 'No students have completed their skills profile yet. Please ask students to update their profiles first.'
                ]);
            }

            $supabaseService = new SupabaseStorageService();
            
            // Create temporary directory for processing
            $tempDir = sys_get_temp_dir() . '/student_forecast_' . uniqid();
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }

            $tempCsvPath = $tempDir . '/student_predict.csv';
            
            // Generate CSV content from user data
            $csvContent = $this->generateCsvFromUsers($students);
            file_put_contents($tempCsvPath, $csvContent);

            // Upload student prediction CSV to Supabase
            $uploadResult = $supabaseService->uploadFromTemp($tempCsvPath, 'student_predict.csv');
            
            if (!$uploadResult) {
                throw new \Exception('Failed to upload student prediction file to Supabase');
            }

            // Construct the command to run Python script
            $command = "python3 " 
                . public_path('assets/python/predictions.py') . " "
                . escapeshellarg('modeltrained.csv') . " "  // Use the existing model file in Supabase
                . escapeshellarg($tempDir);  // Pass temp directory for processing

            $output = shell_exec($command);

            // Clean up temporary files
            if (file_exists($tempCsvPath)) {
                unlink($tempCsvPath);
            }
            if (file_exists($tempDir)) {
                rmdir($tempDir);
            }

            return response()->json([
                'status' => 'success', 
                'message' => 'Predictions generated successfully for ' . $students->count() . ' students',
                'student_count' => $students->count()
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Calculate employability probability based on student data
     */
    private function calculateEmployabilityProbability($student)
    {
        $score = 0;
        $maxScore = 100;

        // Academic performance (30% weight)
        if ($student->average_prof_grade) {
            $score += ($student->average_prof_grade / 100) * 15;
        }
        if ($student->average_elec_grade) {
            $score += ($student->average_elec_grade / 100) * 10;
        }
        if ($student->ojt_grade) {
            $score += ($student->ojt_grade / 100) * 5;
        }

        // Skills assessment (40% weight)
        if ($student->soft_skills_ave) {
            $score += ($student->soft_skills_ave / 100) * 20;
        }
        if ($student->hard_skills_ave) {
            $score += ($student->hard_skills_ave / 100) * 20;
        }

        // Additional factors (30% weight)
        if ($student->is_board_passer) {
            $score += 15;
        }
        if ($student->leadership) {
            $score += 10;
        }
        if ($student->act_member) {
            $score += 5;
        }

        return min(100, max(0, round($score)));
    }

    /**
     * Predict employability status
     */
    private function predictEmployability($student)
    {
        $probability = $this->calculateEmployabilityProbability($student);
        return $probability >= 50 ? 'Employable' : 'Less Employable';
    }

    /**
     * Calculate employment rate
     */
    private function calculateEmploymentRate($student)
    {
        $probability = $this->calculateEmployabilityProbability($student);
        return round($probability * 0.8); // Employment rate is typically 80% of employability probability
    }

    /**
     * Generate CSV content from user data
     */
    private function generateCsvFromUsers($students)
    {
        $csvContent = "Student Number,Gender,Age,Degree,CGPA,Average Prof Grade,Average Elec Grade,OJT Grade,Soft Skills Ave,Hard Skills Ave,Year Graduated,Employability\n";
        
        foreach ($students as $student) {
            $csvContent .= sprintf(
                "%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s\n",
                $student->student_id ?? $student->id,
                $student->gender ?? 'Not Specified',
                $student->age ?? 0,
                $student->degree_name ?? 'Not Specified',
                $student->cgpa ?? 0,
                $student->average_prof_grade ?? 0,
                $student->average_elec_grade ?? 0,
                $student->ojt_grade ?? 0,
                $student->soft_skills_ave ?? 0,
                $student->hard_skills_ave ?? 0,
                $student->year_graduated ?? date('Y'),
                $student->employability ?? 'Not Assessed'
            );
        }
        
        return $csvContent;
    }
} 
