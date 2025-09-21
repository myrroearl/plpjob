<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

// Include FPDF
require_once app_path('Libraries/fpdf186/fpdf.php');

class PDF extends \FPDF {
    // Page header
    function Header() {
        // Add PLP logo on the left
        $this->Image(public_path('assets/img/plp-logo.png'), 10, 6, 25);
        //$this->Image(public_path('assets/img/ccs-logo.jpg'), 260, 6, 25);
        
        // Set font for header text
        $this->SetFont('Arial', 'B', 14);
        
        // University name
        $this->Cell(0, 6, 'Pamantasan ng Lungsod ng Pasig', 0, 1, 'C');
        
        // Address
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 6, 'Alkalde Jose St. Kapasigan, Pasig City', 0, 1, 'C');
        
        // College name
        $this->Cell(0, 6, 'College of Computer Studies', 0, 1, 'C');
        
        // Add some space
        $this->Ln(5);
        
        // Report title
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Student Employability Report', 0, 1, 'C');
        
        // Date and filters
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 6, 'Generated on: ' . date('F d, Y h:i A'), 0, 1, 'R');

        // Filter information if provided
        if (isset($_GET['year']) && $_GET['year'] != '') {
            $this->Cell(0, 6, 'Year Filter: ' . $_GET['year'], 0, 1, 'L');
        }
        if (isset($_GET['degree']) && $_GET['degree'] != '') {
            $this->Cell(0, 6, 'Degree Filter: ' . $_GET['degree'], 0, 1, 'L');
        }
        
        // Add a line separator
        $this->Line(10, $this->GetY(), 287, $this->GetY());
        
        // Add space after line
        $this->Ln(5);
    }

    // Page footer
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    // Better table header
    function FancyTable($header, $widths) {
        // Colors, line width and bold font
        $this->SetFillColor(47, 79, 79); // Dark slate gray
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 128, 128);
        $this->SetLineWidth(.3);
        $this->SetFont('Arial', 'B', 9);

        // Header
        for($i = 0; $i < count($header); $i++) {
            $this->Cell($widths[$i], 7, $header[$i], 1, 0, 'C', true);
        }
        $this->Ln();
        
        // Color and font restoration
        $this->SetFillColor(244, 244, 244);
        $this->SetTextColor(0);
        $this->SetFont('Arial', '', 8);
    }
}

class ReportController extends Controller
{
    public function index()
    {
        // Fetch data directly from users table instead of CSV/TXT files
        $users = \App\Models\User::where('skills_completed', true)
            ->where('role', 'user')
            ->get();

        $csvData = [];
        $highProbabilityCount = 0;
        $mediumProbabilityCount = 0;
        $lowProbabilityCount = 0;

        foreach ($users as $user) {
            // Calculate employability probability (simplified logic)
            $probability = $this->calculateEmployabilityProbability($user);
            
            $csvData[] = [
                'Student Number' => $user->student_id ?? $user->id,
                'Gender' => 'Male', // Default since users table doesn't have gender
                'Age' => $user->age ?? 0,
                'Degree' => $user->degree_name ?? 'Not Specified',
                'CGPA' => $user->average_grade ?? 0,
                'Average Prof Grade' => $user->average_prof_grade ?? 0,
                'Average Elec Grade' => $user->average_elec_grade ?? 0,
                'OJT Grade' => $user->ojt_grade ?? 0,
                'Soft Skills Ave' => $user->soft_skills_ave ?? 0,
                'Hard Skills Ave' => $user->hard_skills_ave ?? 0,
                'Year Graduated' => $user->year_graduated ?? date('Y'),
                'Predicted_Employability' => $probability >= 50 ? 'Employable' : 'Less Employable',
                'Employability_Probability' => $probability,
                'Predicted_Employment_Rate' => $probability
            ];

            if ($probability >= 75) {
                $highProbabilityCount++;
            } elseif ($probability >= 50) {
                $mediumProbabilityCount++;
            } else {
                $lowProbabilityCount++;
            }
        }

        return view('admin.reports.index', compact('csvData', 'highProbabilityCount', 'mediumProbabilityCount', 'lowProbabilityCount'));
    }

    private function calculateEmployabilityProbability($user)
    {
        // Simple calculation based on academic performance and skills
        $cgpa = $user->average_grade ?? 0;
        $profGrade = $user->average_prof_grade ?? 0;
        $elecGrade = $user->average_elec_grade ?? 0;
        $ojtGrade = $user->ojt_grade ?? 0;
        $softSkills = $user->soft_skills_ave ?? 0;
        $hardSkills = $user->hard_skills_ave ?? 0;

        // Weighted average calculation
        $probability = (
            ($cgpa * 0.25) +
            ($profGrade * 0.20) +
            ($elecGrade * 0.15) +
            ($ojtGrade * 0.15) +
            ($softSkills * 0.15) +
            ($hardSkills * 0.10)
        );

        return min(100, max(0, $probability));
    }

    public function printReport(Request $request)
    {
        $yearFilter = $request->query('year');
        $degreeFilter = $request->query('degree');

        // Fetch data directly from users table
        $users = \App\Models\User::where('skills_completed', true)
            ->where('role', 'user')
            ->get();

        $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->AddPage('L');
        $pdf->SetFont('Arial', '', 10);

        // Table headers
        $headers = [
            'Student Number', 'Gender', 'Age', 'Degree', 'CGPA', 
            'Prof Grade', 'Elec Grade', 'OJT Grade', 
            'Soft Skills', 'Hard Skills', 'Year Graduated', 
            'Employability'
        ];

        // Set column widths
        $widths = [30, 20, 10, 35, 15, 20, 20, 20, 20, 20, 30, 35];

        // Add fancy table header
        $pdf->FancyTable($headers, $widths);

        $rowCount = 0;
        foreach ($users as $user) {
            $rowYear = $user->year_graduated ?? date('Y');
            $rowDegree = $user->degree_name ?? 'Not Specified';

            // Apply filters
            if (($yearFilter && $rowYear != $yearFilter) || 
                ($degreeFilter && $rowDegree != $degreeFilter)) {
                continue;
            }

            $probability = $this->calculateEmployabilityProbability($user);
            $employ = $probability >= 50 ? 'Employable' : 'Less Employable';

            $row = [
                $user->student_id ?? $user->id,
                'Male', // Default since users table doesn't have gender
                $user->age ?? 0,
                $user->degree_name ?? 'Not Specified',
                $user->average_grade ?? 0,
                $user->average_prof_grade ?? 0,
                $user->average_elec_grade ?? 0,
                $user->ojt_grade ?? 0,
                $user->soft_skills_ave ?? 0,
                $user->hard_skills_ave ?? 0,
                $user->year_graduated ?? date('Y'),
                $employ,
            ];

            $isEmployable = $employ == "Employable";

            for($i = 0; $i < count($row); $i++) {
                if ($i == 11) {
                    $pdf->SetFillColor($isEmployable ? 144 : 255, $isEmployable ? 238 : 182, $isEmployable ? 144 : 193);
                } else {
                    $pdf->SetFillColor($rowCount % 2 == 0 ? 244 : 255);
                }
                
                $pdf->Cell($widths[$i], 6, $row[$i], 1, 0, 'C', true);
            }
            $pdf->Ln();
            $rowCount++;
        }

        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(0, 10, 'Summary', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 6, "Total Records: $rowCount", 0, 1, 'L');

        return response()->streamDownload(function() use ($pdf) {
            $pdf->Output();
        }, 'Student_Employability_Report.pdf');
    }

    public function printCompaniesReport()
    {
        $companies = \App\Models\Company::all();
        
        $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->AddPage('L');
        $pdf->SetFont('Arial', '', 10);

        // Table headers
        $headers = ['Company Name', 'Industry', 'Website', 'Description'];
        $widths = [60, 50, 60, 100];

        // Add fancy table header
        $pdf->FancyTable($headers, $widths);

        $rowCount = 0;
        foreach ($companies as $company) {
            $row = [
                $company->name,
                $company->industry ?? 'N/A',
                $company->website ?? 'N/A',
                substr($company->description ?? 'N/A', 0, 50) . (strlen($company->description ?? '') > 50 ? '...' : '')
            ];

            $pdf->SetFillColor($rowCount % 2 == 0 ? 244 : 255);
            for($i = 0; $i < count($row); $i++) {
                $pdf->Cell($widths[$i], 6, $row[$i], 1, 0, 'C', true);
            }
            $pdf->Ln();
            $rowCount++;
        }

        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(0, 10, 'Summary', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 6, "Total Companies: $rowCount", 0, 1, 'L');

        return response()->streamDownload(function() use ($pdf) {
            $pdf->Output();
        }, 'Companies_Report.pdf');
    }

    public function printJobsReport()
    {
        $jobs = \App\Models\Job::with('company')->get();
        
        $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->AddPage('L');
        $pdf->SetFont('Arial', '', 9);

        // Table headers
        $headers = ['Job Title', 'Company', 'Location', 'Job Type', 'Industry', 'Salary Range', 'Expires'];
        $widths = [45, 40, 35, 35, 35, 45, 35];

        // Add fancy table header
        $pdf->FancyTable($headers, $widths);

        $rowCount = 0;
        foreach ($jobs as $job) {
            $salaryRange = $job->salary_min && $job->salary_max ? 
                $job->currency . ' ' . $job->salary_min . ' - ' . $job->salary_max : 'N/A';

            $row = [
                substr($job->title, 0, 30) . (strlen($job->title) > 30 ? '...' : ''),
                substr($job->company->name, 0, 25) . (strlen($job->company->name) > 25 ? '...' : ''),
                substr($job->location, 0, 20) . (strlen($job->location) > 20 ? '...' : ''),
                $job->job_type,
                substr($job->industry, 0, 20) . (strlen($job->industry) > 20 ? '...' : ''),
                $salaryRange,
                $job->expires_at ? $job->expires_at->format('M d, Y') : 'N/A'
            ];

            $pdf->SetFillColor($rowCount % 2 == 0 ? 244 : 255);
            for($i = 0; $i < count($row); $i++) {
                $pdf->Cell($widths[$i], 6, $row[$i], 1, 0, 'C', true);
            }
            $pdf->Ln();
            $rowCount++;
        }

        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(0, 10, 'Summary', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 6, "Total Jobs: $rowCount", 0, 1, 'L');

        return response()->streamDownload(function() use ($pdf) {
            $pdf->Output();
        }, 'Jobs_Report.pdf');
    }

    public function printUsersReport()
    {
        $users = \App\Models\User::where('role', 'user')->get();
        
        $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->AddPage('L');
        $pdf->SetFont('Arial', '', 9);

        // Table headers
        $headers = ['Student ID', 'Full Name', 'Email', 'Degree', 'Age', 'Skills Completed', 'Board Passer'];
        $widths = [35, 70, 60, 35, 20, 30, 25];

        // Add fancy table header
        $pdf->FancyTable($headers, $widths);

        $rowCount = 0;
        foreach ($users as $user) {
            $fullName = $user->first_name . ' ' . $user->middle_name . ' ' . $user->last_name;
            
            $row = [
                $user->student_id ?? $user->id,
                substr($fullName, 0, 35) . (strlen($fullName) > 35 ? '...' : ''),
                substr($user->email, 0, 35) . (strlen($user->email) > 35 ? '...' : ''),
                substr($user->degree_name, 0, 20) . (strlen($user->degree_name) > 20 ? '...' : ''),
                $user->age ?? 'N/A',
                $user->skills_completed ? 'Yes' : 'No',
                $user->is_board_passer ? 'Yes' : 'No'
            ];

            $pdf->SetFillColor($rowCount % 2 == 0 ? 244 : 255);
            for($i = 0; $i < count($row); $i++) {
                $pdf->Cell($widths[$i], 6, $row[$i], 1, 0, 'C', true);
            }
            $pdf->Ln();
            $rowCount++;
        }

        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(0, 10, 'Summary', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 6, "Total Users: $rowCount", 0, 1, 'L');

        return response()->streamDownload(function() use ($pdf) {
            $pdf->Output();
        }, 'Users_Report.pdf');
    }

    public function printFeedbacksReport()
    {
        $feedbacks = \App\Models\Feedback::with('user')->get();
        
        $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->AddPage('L');
        $pdf->SetFont('Arial', '', 8);

        // Table headers
        $headers = ['Student Name', 'Employment Status', 'Company', 'Position', 'Duration', 'Feedback', 'Date'];
        $widths = [40, 35, 40, 35, 35, 50, 35];

        // Add fancy table header
        $pdf->FancyTable($headers, $widths);

        $rowCount = 0;
        foreach ($feedbacks as $feedback) {
            $studentName = $feedback->user->first_name . ' ' . $feedback->user->last_name;
            $employmentStatus = ucfirst($feedback->employment_status);
            
            $row = [
                substr($studentName, 0, 25) . (strlen($studentName) > 25 ? '...' : ''),
                $employmentStatus,
                substr($feedback->company_name ?? 'N/A', 0, 20) . (strlen($feedback->company_name ?? '') > 20 ? '...' : ''),
                substr($feedback->position ?? 'N/A', 0, 18) . (strlen($feedback->position ?? '') > 18 ? '...' : ''),
                $feedback->employment_duration ?? 'N/A',
                substr($feedback->improvements ?? 'N/A', 0, 30) . (strlen($feedback->improvements ?? '') > 30 ? '...' : ''),
                $feedback->created_at->format('M d, Y')
            ];

            $pdf->SetFillColor($rowCount % 2 == 0 ? 244 : 255);
            for($i = 0; $i < count($row); $i++) {
                $pdf->Cell($widths[$i], 6, $row[$i], 1, 0, 'C', true);
            }
            $pdf->Ln();
            $rowCount++;
        }

        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(0, 10, 'Summary', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 6, "Total Feedbacks: $rowCount", 0, 1, 'L');

        return response()->streamDownload(function() use ($pdf) {
            $pdf->Output();
        }, 'Feedbacks_Report.pdf');
    }
} 
