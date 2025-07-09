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
        $detailedPredictionsFile = public_path('assets/predictions/detailed_predictions.txt');
        $csvPredictionsFile = public_path('assets/predictions/student_employability_predictions.csv');

        $detailedPredictions = file_exists($detailedPredictionsFile) ? file_get_contents($detailedPredictionsFile) : '';
        $csvData = [];

        if (file_exists($csvPredictionsFile)) {
            if (($handle = fopen($csvPredictionsFile, 'r')) !== FALSE) {
                $header = fgetcsv($handle);
                while (($data = fgetcsv($handle)) !== FALSE) {
                    $csvData[] = array_combine($header, $data);
                }
                fclose($handle);
            }
        }

        $highProbabilityCount = 0;
        $mediumProbabilityCount = 0;
        $lowProbabilityCount = 0;

        foreach ($csvData as $row) {
            $probability = $row['Employability_Probability'];

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

    public function printReport(Request $request)
    {
        $yearFilter = $request->query('year');
        $degreeFilter = $request->query('degree');

        $csvFile = public_path('assets/predictions/student_employability_predictions.csv');
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

        if (($handle = fopen($csvFile, "r")) !== FALSE) {
            $header = fgetcsv($handle);
            $rowCount = 0;

            while (($data = fgetcsv($handle)) !== FALSE) {
                $rowYear = $data[array_search('Year Graduated', $header)];
                $rowDegree = $data[array_search('Degree', $header)];


                $employ = $data[array_search('Predicted_Employability', $header)];
                if ($employ == "Not Employable") {
                    $employ = "Employable";
                } else {
                    $employ = "Not Employable";
                }

                if (($yearFilter && $rowYear != $yearFilter) || 
                    ($degreeFilter && $rowDegree != $degreeFilter)) {
                    continue;
                }

                $row = [
                    $data[array_search('Student Number', $header)],
                    $data[array_search('Gender', $header)],
                    $data[array_search('Age', $header)],
                    $data[array_search('Degree', $header)],
                    $data[array_search('CGPA', $header)],
                    $data[array_search('Average Prof Grade', $header)],
                    $data[array_search('Average Elec Grade', $header)],
                    $data[array_search('OJT Grade', $header)],
                    $data[array_search('Soft Skills Ave', $header)],
                    $data[array_search('Hard Skills Ave', $header)],
                    $data[array_search('Year Graduated', $header)],
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
            fclose($handle);
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
} 
