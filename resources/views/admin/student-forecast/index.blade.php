<x-admin-layout>
    @section('title', 'Predict & Report')

    <div class="main-content">
        <div class="dashboard-header">
            <h1>Student Employment Prediction</h1>
            <p class="text-muted">Analyze and predict individual student employment probability</p>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="dashboard-card">
                            <div class="stat-card">
                                <div class="stat-icon bg-success-light">
                                    <i class="fas fa-user-check text-success"></i>
                                </div>
                                <div class="stat-details">
                                    <h4>High Probability</h4>
                                    <h2>75%+</h2>
                                    <small class="text-success">{{ $highProbabilityCount }} Students</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="dashboard-card">
                            <div class="stat-card">
                                <div class="stat-icon bg-warning-light">
                                    <i class="fas fa-user-clock text-warning"></i>
                                </div>
                                <div class="stat-details">
                                    <h4>Medium Probability</h4>
                                    <h2>50-74%</h2>
                                    <small class="text-warning">{{ $mediumProbabilityCount }} Students</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="dashboard-card">
                            <div class="stat-card">
                                <div class="stat-icon bg-danger-light">
                                    <i class="fas fa-user-times text-danger"></i>
                                </div>
                                <div class="stat-details">
                                    <h4>Low Probability</h4>
                                    <h2>&lt;50%</h2>
                                    <small class="text-danger">{{ $lowProbabilityCount }} Students</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Generate Predictions Button -->
                {{-- <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="dashboard-card">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-1">Employment Predictions</h4>
                                    <p class="text-muted mb-0">Generate predictions based on student data</p>
                                </div>
                                <form action="{{ route('admin.student-forecast.processPrediction') }}" method="post" id="studentForecastForm" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success" {{ count($csvData) == 0 ? 'disabled' : '' }}>
                                        <i class="fas fa-calculator me-2"></i>Generate Predictions
                                    </button>
                                </form>
                            </div>
                            @if(count($csvData) == 0)
                                <div class="alert alert-warning mt-3">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>No Data Available</strong> - No students have completed their skills profile yet. Please ask students to update their profiles in the Alumni Portal.
                                </div>
                            @endif
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>

        <div class="dashboard-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="card-title mb-0">Latest Prediction Results</h3>
                <button onclick="printFilteredReport()" class="btn btn-primary">
                    <i class="fas fa-print"></i> Print Report
                </button>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Filter by Year Graduated</label>
                    <select class="form-select" id="yearFilter">
                        <option value="">All Years</option>
                        @foreach (array_unique(array_column($csvData, 'Year Graduated')) as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Filter by Degree</label>
                    <select class="form-select" id="degreeFilter">
                        <option value="">All Degrees</option>
                        @foreach (array_unique(array_column($csvData, 'Degree')) as $degree)
                            <option value="{{ $degree }}">{{ $degree }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover display" id="resultsTable">
                    <thead>
                        <tr>
                            <th>Student Number</th>
                            <th>Age</th>
                            <th>Degree</th>
                            <th>CGPA</th>
                            <th>Avg Prof Grade</th>
                            <th>Avg Elec Grade</th>
                            <th>OJT Grade</th>
                            <th>Soft Skills Ave</th>
                            <th>Hard Skills Ave</th>
                            <th>Year Graduated</th>
                            <th>Predicted Employability</th>
                            <th>Employability Probability</th>
                            <th>Predicted Employment Rate</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($csvData as $row)
                            <tr>
                                <td>{{ $row['Student Number'] }}</td>
                                <td>{{ $row['Age'] }}</td>
                                <td>{{ $row['Degree'] }}</td>
                                <td>{{ $row['CGPA'] }}</td>
                                <td>{{ $row['Average Prof Grade'] }}</td>
                                <td>{{ $row['Average Elec Grade'] }}</td>
                                <td>{{ $row['OJT Grade'] }}</td>
                                <td>{{ $row['Soft Skills Ave'] }}</td>
                                <td>{{ $row['Hard Skills Ave'] }}</td>
                                <td>{{ $row['Year Graduated'] }}</td>
                                <td class="{{ $row['Predicted_Employability'] == 'Employable' ? 'bg-success' : 'bg-danger' }}">
                                    <span class="badge">{{ $row['Predicted_Employability'] == 'Employable' ? 'Employable' : 'Less Employable' }}</span>
                                </td>
                                <td class="text-center">
                                    @php
                                        $employabilityProbability = $row['Employability_Probability'];
                                        $progressBarColor = 'bg-danger';

                                        if ($employabilityProbability >= 75) {
                                            $progressBarColor = 'bg-success';
                                        } elseif ($employabilityProbability >= 50) {
                                            $progressBarColor = 'bg-warning';
                                        }
                                    @endphp
                                    <div class="progress" style="height: 15px;">
                                        <div class="progress-bar {{ $progressBarColor }}" style="width: {{ $employabilityProbability }}%"></div>
                                    </div>
                                    {{ $employabilityProbability }}%
                                </td>
                                <td>{{ $row['Predicted_Employment_Rate'] }}%</td>
                                <td>
                                    @php
                                        $student = $students->where('student_id', $row['Student Number'])->first() ?? 
                                                  $students->where('id', $row['Student Number'])->first();
                                    @endphp
                                    <button type="button" class="btn btn-sm btn-info view-student-details" 
                                            data-student-number="{{ $row['Student Number'] }}"
                                            data-age="{{ $row['Age'] }}"
                                            data-degree="{{ $row['Degree'] }}"
                                            data-cgpa="{{ $row['CGPA'] }}"
                                            data-prof-grade="{{ $row['Average Prof Grade'] }}"
                                            data-elec-grade="{{ $row['Average Elec Grade'] }}"
                                            data-ojt-grade="{{ $row['OJT Grade'] }}"
                                            data-soft-skills="{{ $row['Soft Skills Ave'] }}"
                                            data-hard-skills="{{ $row['Hard Skills Ave'] }}"
                                            data-year-graduated="{{ $row['Year Graduated'] }}"
                                            data-employability="{{ $row['Predicted_Employability'] }}"
                                            data-probability="{{ $row['Employability_Probability'] }}"
                                            data-employment-rate="{{ $row['Predicted_Employment_Rate'] }}"
                                            @if($student)
                                                data-auditing-skills="{{ $student->auditing_skills ?? 0 }}"
                                                data-budgeting-analysis-skills="{{ $student->budgeting_analysis_skills ?? 0 }}"
                                                data-classroom-management-skills="{{ $student->classroom_management_skills ?? 0 }}"
                                                data-cloud-computing-skills="{{ $student->cloud_computing_skills ?? 0 }}"
                                                data-curriculum-development-skills="{{ $student->curriculum_development_skills ?? 0 }}"
                                                data-data-structures-algorithms="{{ $student->data_structures_algorithms ?? 0 }}"
                                                data-database-management-skills="{{ $student->database_management_skills ?? 0 }}"
                                                data-educational-technology-skills="{{ $student->educational_technology_skills ?? 0 }}"
                                                data-financial-accounting-skills="{{ $student->financial_accounting_skills ?? 0 }}"
                                                data-financial-management-skills="{{ $student->financial_management_skills ?? 0 }}"
                                                data-java-programming-skills="{{ $student->java_programming_skills ?? 0 }}"
                                                data-leadership-decision-making-skills="{{ $student->leadership_decision_making_skills ?? 0 }}"
                                                data-machine-learning-skills="{{ $student->machine_learning_skills ?? 0 }}"
                                                data-marketing-skills="{{ $student->marketing_skills ?? 0 }}"
                                                data-networking-skills="{{ $student->networking_skills ?? 0 }}"
                                                data-programming-logic-skills="{{ $student->programming_logic_skills ?? 0 }}"
                                                data-python-programming-skills="{{ $student->python_programming_skills ?? 0 }}"
                                                data-software-engineering-skills="{{ $student->software_engineering_skills ?? 0 }}"
                                                data-strategic-planning-skills="{{ $student->strategic_planning_skills ?? 0 }}"
                                                data-system-design-skills="{{ $student->system_design_skills ?? 0 }}"
                                                data-taxation-skills="{{ $student->taxation_skills ?? 0 }}"
                                                data-teaching-skills="{{ $student->teaching_skills ?? 0 }}"
                                                data-web-development-skills="{{ $student->web_development_skills ?? 0 }}"
                                                data-statistical-analysis-skills="{{ $student->statistical_analysis_skills ?? 0 }}"
                                                data-english-communication-writing-skills="{{ $student->english_communication_writing_skills ?? 0 }}"
                                                data-filipino-communication-writing-skills="{{ $student->filipino_communication_writing_skills ?? 0 }}"
                                                data-early-childhood-education-skills="{{ $student->early_childhood_education_skills ?? 0 }}"
                                                data-customer-service-skills="{{ $student->customer_service_skills ?? 0 }}"
                                                data-event-management-skills="{{ $student->event_management_skills ?? 0 }}"
                                                data-food-beverage-management-skills="{{ $student->food_beverage_management_skills ?? 0 }}"
                                                data-risk-management-skills="{{ $student->risk_management_skills ?? 0 }}"
                                                data-innovation-business-planning-skills="{{ $student->innovation_business_planning_skills ?? 0 }}"
                                                data-consumer-behavior-analysis="{{ $student->consumer_behavior_analysis ?? 0 }}"
                                                data-sales-management-skills="{{ $student->sales_management_skills ?? 0 }}"
                                                data-artificial-intelligence-skills="{{ $student->artificial_intelligence_skills ?? 0 }}"
                                                data-cybersecurity-skills="{{ $student->cybersecurity_skills ?? 0 }}"
                                                data-circuit-design-skills="{{ $student->circuit_design_skills ?? 0 }}"
                                                data-communication-systems-skills="{{ $student->communication_systems_skills ?? 0 }}"
                                                data-problem-solving-skills="{{ $student->problem_solving_skills ?? 0 }}"
                                                data-clinical-skills="{{ $student->clinical_skills ?? 0 }}"
                                                data-patient-care-skills="{{ $student->patient_care_skills ?? 0 }}"
                                                data-health-assessment-skills="{{ $student->health_assessment_skills ?? 0 }}"
                                                data-emergency-response-skills="{{ $student->emergency_response_skills ?? 0 }}"
                                            @endif>
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Prediction Visualizations -->
        <div class="dashboard-card mt-4">
            <h3 class="card-title mb-4">Prediction Visualizations</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="chart-container">
                        <canvas id="employabilityByDegreeChart"></canvas>
                        <h5 class="text-center mt-3">Predicted Employability by Degree</h5>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="chart-container">
                        <canvas id="employmentRateDistributionChart"></canvas>
                        <h5 class="text-center mt-3">Distribution of Predicted Employment Rates</h5>
                    </div>
                </div>
            </div>
    
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="chart-container">
                        <canvas id="topFactorsChart"></canvas>
                        <h5 class="text-center mt-3">Top Factors Affecting Employability</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student Details Modal -->
        <div class="modal fade" id="studentDetailsModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Student Employment Prediction Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">Basic Information</h6>
                                <div class="mb-2">
                                    <strong>Student Number:</strong> <span id="modal-student-number"></span>
                                </div>
                                <div class="mb-2">
                                    <strong>Age:</strong> <span id="modal-age"></span>
                                </div>
                                <div class="mb-2">
                                    <strong>Degree:</strong> <span id="modal-degree"></span>
                                </div>
                                <div class="mb-2">
                                    <strong>Year Graduated:</strong> <span id="modal-year-graduated"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">Academic Performance</h6>
                                <div class="mb-2">
                                    <strong>CGPA:</strong> <span id="modal-cgpa"></span>
                                </div>
                                <div class="mb-2">
                                    <strong>Average Prof Grade:</strong> <span id="modal-prof-grade"></span>
                                </div>
                                <div class="mb-2">
                                    <strong>Average Elec Grade:</strong> <span id="modal-elec-grade"></span>
                                </div>
                                <div class="mb-2">
                                    <strong>OJT Grade:</strong> <span id="modal-ojt-grade"></span>
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">Skills Assessment</h6>
                                <div class="mb-2">
                                    <strong>Soft Skills Average:</strong> <span id="modal-soft-skills"></span>
                                </div>
                                <div class="mb-2">
                                    <strong>Hard Skills Average:</strong> <span id="modal-hard-skills"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">Employment Prediction</h6>
                                <div class="mb-2">
                                    <strong>Predicted Employability:</strong> 
                                    <span id="modal-employability" class="badge"></span>
                                </div>
                                <div class="mb-2">
                                    <strong>Employability Probability:</strong> <span id="modal-probability"></span>%
                                </div>
                                <div class="mb-2">
                                    <strong>Predicted Employment Rate:</strong> <span id="modal-employment-rate"></span>%
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="text-primary mb-3">Degree-Specific Skills Assessment</h6>
                                <div id="skills-container-forecast">
                                    <!-- Skills will be dynamically loaded here -->
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Note:</strong> This prediction is based on academic performance, skills assessment, and historical data patterns.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        .chart-container {
            position: relative;
            height: 400px;
            margin-bottom: 20px;
        }
        
        .chart-container canvas {
            max-height: 400px;
        }
        
        .dashboard-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .stat-card {
            display: flex;
            align-items: center;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #007bff;
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }
        
        .stat-details h4 {
            margin: 0;
            font-size: 14px;
            color: #6c757d;
        }
        
        .stat-details h2 {
            margin: 5px 0;
            font-size: 24px;
            font-weight: bold;
        }
        
        .stat-details small {
            font-size: 12px;
        }
        
        .bg-success-light {
            background-color: rgba(40, 167, 69, 0.1);
        }
        
        .bg-warning-light {
            background-color: rgba(255, 193, 7, 0.1);
        }
        
        .bg-danger-light {
            background-color: rgba(220, 53, 69, 0.1);
        }
    </style>
    
    <script>
        // Chart data from PHP
        const chartData = {
            csvData: @json($csvData),
            highProbabilityCount: {{ $highProbabilityCount }},
            mediumProbabilityCount: {{ $mediumProbabilityCount }},
            lowProbabilityCount: {{ $lowProbabilityCount }}
        };

        // Function to get skills based on degree using partial string matching
        function getSkillsForDegree(degree) {
            const upperDegree = degree.toUpperCase();
            
            if (upperDegree.includes('BSIT') || upperDegree.includes('INFORMATION TECHNOLOGY')) {
                return [
                    'java_programming_skills',
                    'python_programming_skills',
                    'web_development_skills',
                    'database_management_skills',
                    'software_engineering_skills',
                    'data_structures_algorithms',
                    'programming_logic_skills',
                    'system_design_skills',
                    'networking_skills',
                    'cloud_computing_skills',
                    'artificial_intelligence_skills',
                    'cybersecurity_skills',
                    'machine_learning_skills',
                    'statistical_analysis_skills',
                    'problem_solving_skills'
                ];
            } else if (upperDegree.includes('BSED') || upperDegree.includes('EDUCATION')) {
                if (upperDegree.includes('ENGLISH')) {
                    return [
                        'english_communication_writing_skills',
                        'teaching_skills',
                        'classroom_management_skills',
                        'curriculum_development_skills',
                        'educational_technology_skills',
                        'leadership_decision_making_skills',
                        'early_childhood_education_skills',
                        'statistical_analysis_skills',
                        'problem_solving_skills'
                    ];
                } else if (upperDegree.includes('FILIPINO')) {
                    return [
                        'filipino_communication_writing_skills',
                        'teaching_skills',
                        'classroom_management_skills',
                        'curriculum_development_skills',
                        'educational_technology_skills',
                        'leadership_decision_making_skills',
                        'early_childhood_education_skills',
                        'statistical_analysis_skills',
                        'problem_solving_skills'
                    ];
                } else {
                    return [
                        'teaching_skills',
                        'classroom_management_skills',
                        'curriculum_development_skills',
                        'educational_technology_skills',
                        'leadership_decision_making_skills',
                        'early_childhood_education_skills',
                        'statistical_analysis_skills',
                        'problem_solving_skills'
                    ];
                }
            } else if (upperDegree.includes('BSN') || upperDegree.includes('NURSING')) {
                return [
                    'clinical_skills',
                    'patient_care_skills',
                    'health_assessment_skills',
                    'emergency_response_skills',
                    'leadership_decision_making_skills',
                    'problem_solving_skills',
                    'statistical_analysis_skills'
                ];
            } else if (upperDegree.includes('BSA') || upperDegree.includes('ACCOUNTANCY')) {
                return [
                    'auditing_skills',
                    'financial_accounting_skills',
                    'taxation_skills',
                    'budgeting_analysis_skills',
                    'financial_management_skills',
                    'leadership_decision_making_skills',
                    'problem_solving_skills',
                    'statistical_analysis_skills'
                ];
            } else if (upperDegree.includes('BSBA') || upperDegree.includes('BUSINESS')) {
                return [
                    'marketing_skills',
                    'sales_management_skills',
                    'customer_service_skills',
                    'event_management_skills',
                    'food_beverage_management_skills',
                    'risk_management_skills',
                    'innovation_business_planning_skills',
                    'consumer_behavior_analysis',
                    'leadership_decision_making_skills',
                    'problem_solving_skills',
                    'statistical_analysis_skills'
                ];
            } else if (upperDegree.includes('ECE') || upperDegree.includes('ELECTRONICS')) {
                return [
                    'circuit_design_skills',
                    'communication_systems_skills',
                    'networking_skills',
                    'system_design_skills',
                    'problem_solving_skills',
                    'leadership_decision_making_skills',
                    'statistical_analysis_skills'
                ];
            } else if (upperDegree.includes('BSCS') || upperDegree.includes('COMPUTER SCIENCE')) {
                return [
                    'data_structures_algorithms',
                    'machine_learning_skills',
                    'software_engineering_skills',
                    'programming_logic_skills',
                    'cloud_computing_skills',
                    'artificial_intelligence_skills',
                    'problem_solving_skills',
                    'statistical_analysis_skills'
                ];
            } else if (upperDegree.includes('BSMATH') || upperDegree.includes('MATHEMATICS')) {
                return [
                    'data_structures_algorithms',
                    'programming_logic_skills',
                    'software_engineering_skills',
                    'statistical_analysis_skills',
                    'problem_solving_skills'
                ];
            } else if (upperDegree.includes('BSHM') || upperDegree.includes('HOSPITALITY')) {
                return [
                    'customer_service_skills',
                    'event_management_skills',
                    'food_beverage_management_skills',
                    'leadership_decision_making_skills',
                    'problem_solving_skills',
                    'statistical_analysis_skills'
                ];
            } else {
                // Default skills for other degrees
                return [
                    'leadership_decision_making_skills',
                    'problem_solving_skills',
                    'statistical_analysis_skills',
                    'customer_service_skills'
                ];
            }
        }

        // Skills display names
        const skillsDisplayNames = {
            'data_structures_algorithms': 'Data Structures & Algorithms',
            'programming_logic_skills': 'Programming Logic Skills',
            'software_engineering_skills': 'Software Engineering Skills',
            'statistical_analysis_skills': 'Statistical Analysis Skills',
            'teaching_skills': 'Teaching Skills',
            'curriculum_development_skills': 'Curriculum Development Skills',
            'classroom_management_skills': 'Classroom Management Skills',
            'english_communication_writing_skills': 'English Communication & Writing Skills',
            'filipino_communication_writing_skills': 'Filipino Communication & Writing Skills',
            'early_childhood_education_skills': 'Early Childhood Education Skills',
            'customer_service_skills': 'Customer Service Skills',
            'event_management_skills': 'Event Management Skills',
            'food_beverage_management_skills': 'Food & Beverage Management Skills',
            'leadership_decision_making_skills': 'Leadership & Decision-Making Skills',
            'financial_accounting_skills': 'Financial Accounting Skills',
            'auditing_skills': 'Auditing Skills',
            'taxation_skills': 'Taxation Skills',
            'budgeting_analysis_skills': 'Budgeting & Analysis Skills',
            'risk_management_skills': 'Risk Management Skills',
            'marketing_skills': 'Marketing Skills',
            'strategic_planning_skills': 'Strategic Planning Skills',
            'financial_management_skills': 'Financial Management Skills',
            'innovation_business_planning_skills': 'Innovation & Business Planning Skills',
            'consumer_behavior_analysis': 'Consumer Behavior Analysis',
            'sales_management_skills': 'Sales Management Skills',
            'machine_learning_skills': 'Machine Learning Skills',
            'cloud_computing_skills': 'Cloud Computing Skills',
            'artificial_intelligence_skills': 'Artificial Intelligence Skills',
            'java_programming_skills': 'Java Programming Skills',
            'python_programming_skills': 'Python Programming Skills',
            'web_development_skills': 'Web Development Skills',
            'database_management_skills': 'Database Management Skills',
            'system_design_skills': 'System Design Skills',
            'networking_skills': 'Networking Skills',
            'cybersecurity_skills': 'Cybersecurity Skills',
            'circuit_design_skills': 'Circuit Design Skills',
            'communication_systems_skills': 'Communication Systems Skills',
            'problem_solving_skills': 'Problem-Solving Skills',
            'clinical_skills': 'Clinical Skills',
            'patient_care_skills': 'Patient Care Skills',
            'health_assessment_skills': 'Health Assessment Skills',
            'emergency_response_skills': 'Emergency Response Skills'
        };

        function printFilteredReport() {
            const yearFilter = document.getElementById('yearFilter').value;
            const degreeFilter = document.getElementById('degreeFilter').value;
            
            let url = '{{ route("admin.reports.print") }}?';
            if (yearFilter) url += 'year=' + encodeURIComponent(yearFilter) + '&';
            if (degreeFilter) url += 'degree=' + encodeURIComponent(degreeFilter);
            
            window.open(url, '_blank');
        }

        // Initialize charts when page loads
        document.addEventListener('DOMContentLoaded', function() {
            initializeCharts();
            initializeStudentDetailsModal();
        });

        function initializeStudentDetailsModal() {
            // Handle view student details button clicks
            document.addEventListener('click', function(e) {
                if (e.target.closest('.view-student-details')) {
                    const button = e.target.closest('.view-student-details');
                    const data = button.dataset;
                    
                    // Populate modal with student data
                    document.getElementById('modal-student-number').textContent = data.studentNumber;
                    document.getElementById('modal-age').textContent = data.age;
                    document.getElementById('modal-degree').textContent = data.degree;
                    document.getElementById('modal-cgpa').textContent = data.cgpa;
                    document.getElementById('modal-prof-grade').textContent = data.profGrade;
                    document.getElementById('modal-elec-grade').textContent = data.elecGrade;
                    document.getElementById('modal-ojt-grade').textContent = data.ojtGrade;
                    document.getElementById('modal-soft-skills').textContent = data.softSkills;
                    document.getElementById('modal-hard-skills').textContent = data.hardSkills;
                    document.getElementById('modal-year-graduated').textContent = data.yearGraduated;
                    document.getElementById('modal-probability').textContent = data.probability;
                    document.getElementById('modal-employment-rate').textContent = data.employmentRate;
                    
                    // Set employability badge
                    const employabilityBadge = document.getElementById('modal-employability');
                    employabilityBadge.textContent = data.employability;
                    employabilityBadge.className = 'badge ' + (data.employability === 'Employable' ? 'bg-success' : 'bg-danger');
                    
                    // Load skills based on degree
                    loadSkillsForDegreeForecast(data.degree, data);
                    
                    // Show modal
                    const modal = new bootstrap.Modal(document.getElementById('studentDetailsModal'));
                    modal.show();
                }
            });
        }

        function loadSkillsForDegreeForecast(degree, studentData) {
            const skillsContainer = document.getElementById('skills-container-forecast');
            const skills = getSkillsForDegree(degree);
            
            if (skills.length === 0) {
                skillsContainer.innerHTML = '<div class="alert alert-warning">No specific skills defined for this degree.</div>';
                return;
            }
            
            // Debug: Log all data attributes
            console.log('All data attributes (forecast):', studentData);
            
            let skillsHtml = '<div class="row">';
            skills.forEach(skillKey => {
                const skillName = skillsDisplayNames[skillKey] || skillKey;
                // Convert skillKey to camelCase for dataset access (HTML data attributes become camelCase in JS)
                const camelCaseKey = skillKey.replace(/_([a-z])/g, (match, letter) => letter.toUpperCase());
                // Try both camelCase and kebab-case formats
                const skillValue = studentData[camelCaseKey] || studentData[skillKey] || 'N/A';
                const rating = skillValue !== 'N/A' ? parseFloat(skillValue) : 0;
                
                // Debug: Log the values to console
                console.log('Skill:', skillKey, 'CamelCase Key:', camelCaseKey, 'Value:', skillValue, 'Rating:', rating);
                
                skillsHtml += `
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">${skillName}</h6>
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar ${getProgressBarColor(rating)}" 
                                                 style="width: ${(rating / 5) * 100}%">
                                                ${skillValue}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ms-2">
                                        <span class="badge ${getRatingBadgeColor(rating)}">${skillValue}/5</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
            skillsHtml += '</div>';
            
            skillsContainer.innerHTML = skillsHtml;
        }

        function getProgressBarColor(rating) {
            if (rating >= 4) return 'bg-success';
            if (rating >= 3) return 'bg-warning';
            return 'bg-danger';
        }

        function getRatingBadgeColor(rating) {
            if (rating >= 4) return 'bg-success';
            if (rating >= 3) return 'bg-warning';
            return 'bg-danger';
        }

        function initializeCharts() {
            // 1. Employability by Degree Chart
            createEmployabilityByDegreeChart();
            
            // 2. Employment Rate Distribution Chart
            createEmploymentRateDistributionChart();
            
            // 3. Top Factors Chart
            createTopFactorsChart();
        }

        function createEmployabilityByDegreeChart() {
            const ctx = document.getElementById('employabilityByDegreeChart').getContext('2d');
            
            // Process data to get employability by degree
            const degreeData = {};
            chartData.csvData.forEach(student => {
                const degree = student.Degree || 'Unknown';
                if (!degreeData[degree]) {
                    degreeData[degree] = { total: 0, employable: 0 };
                }
                degreeData[degree].total++;
                if (student.Predicted_Employability === 'Employable') {
                    degreeData[degree].employable++;
                }
            });

            const degrees = Object.keys(degreeData);
            const employabilityRates = degrees.map(degree => {
                const data = degreeData[degree];
                return data.total > 0 ? (data.employable / data.total * 100).toFixed(1) : 0;
            });

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: degrees,
                    datasets: [{
                        label: 'Employability Rate (%)',
                        data: employabilityRates,
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.8)',
                            'rgba(255, 99, 132, 0.8)',
                            'rgba(255, 205, 86, 0.8)',
                            'rgba(75, 192, 192, 0.8)',
                            'rgba(153, 102, 255, 0.8)',
                            'rgba(255, 159, 64, 0.8)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(255, 205, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            ticks: {
                                callback: function(value) {
                                    return value + '%';
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }

        function createEmploymentRateDistributionChart() {
            const ctx = document.getElementById('employmentRateDistributionChart').getContext('2d');
            
            // Process data to get employment rate distribution
            const rateRanges = {
                '0-20%': 0,
                '21-40%': 0,
                '41-60%': 0,
                '61-80%': 0,
                '81-100%': 0
            };

            chartData.csvData.forEach(student => {
                const rate = parseFloat(student['Predicted_Employment_Rate']) || 0;
                if (rate <= 20) rateRanges['0-20%']++;
                else if (rate <= 40) rateRanges['21-40%']++;
                else if (rate <= 60) rateRanges['41-60%']++;
                else if (rate <= 80) rateRanges['61-80%']++;
                else rateRanges['81-100%']++;
            });

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(rateRanges),
                    datasets: [{
                        data: Object.values(rateRanges),
                        backgroundColor: [
                            'rgba(220, 53, 69, 0.8)',
                            'rgba(255, 193, 7, 0.8)',
                            'rgba(40, 167, 69, 0.8)',
                            'rgba(0, 123, 255, 0.8)',
                            'rgba(111, 66, 193, 0.8)'
                        ],
                        borderColor: [
                            'rgba(220, 53, 69, 1)',
                            'rgba(255, 193, 7, 1)',
                            'rgba(40, 167, 69, 1)',
                            'rgba(0, 123, 255, 1)',
                            'rgba(111, 66, 193, 1)'
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }
        
        function createTopFactorsChart() {
            const ctx = document.getElementById('topFactorsChart').getContext('2d');
            
            // Calculate correlation between factors and employability
            const factors = {
                'Average Prof Grade': [],
                'Average Elec Grade': [],
                'OJT Grade': [],
                'Soft Skills Ave': [],
                'Hard Skills Ave': [],
                'CGPA': []
            };

            chartData.csvData.forEach(student => {
                Object.keys(factors).forEach(factor => {
                    const value = parseFloat(student[factor]) || 0;
                    const employable = student.Predicted_Employability === 'Employable' ? 1 : 0;
                    factors[factor].push({ value, employable });
                });
            });

            // Calculate correlation scores (simplified)
            const factorScores = {};
            Object.keys(factors).forEach(factor => {
                const data = factors[factor];
                const avgEmployable = data.filter(d => d.employable === 1).reduce((sum, d) => sum + d.value, 0) / data.filter(d => d.employable === 1).length || 0;
                const avgNotEmployable = data.filter(d => d.employable === 0).reduce((sum, d) => sum + d.value, 0) / data.filter(d => d.employable === 0).length || 0;
                factorScores[factor] = Math.abs(avgEmployable - avgNotEmployable);
            });

            // Get top 5 factors
            const sortedFactors = Object.entries(factorScores)
                .sort(([,a], [,b]) => b - a)
                .slice(0, 5);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: sortedFactors.map(([factor]) => factor),
                    datasets: [{
                        label: 'Impact Score',
                        data: sortedFactors.map(([,score]) => score.toFixed(2)),
                        backgroundColor: 'rgba(54, 162, 235, 0.8)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    indexAxis: 'y',
                    scales: {
                        x: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }

        // Handle form submission for prediction generation
        document.getElementById('studentForecastForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Generating...';
            
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.message,
                        timer: 3000
                    }).then(() => {
                        location.reload();
                    });
                } else if (data.status === 'warning') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No Data Available',
                        text: data.message
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'An error occurred while generating predictions.'
                });
            })
            .finally(() => {
                // Reset button state
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        });
        </script>

    <script src="{{ asset('assets/js/student_forecast.js') }}"></script>
</x-admin-layout>
