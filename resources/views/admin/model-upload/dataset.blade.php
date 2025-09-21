<x-admin-layout>
    @section('title', 'Dataset Records')
    <div class="main-content">
        <div class="dashboard-header">
            <h1>Dataset Records</h1>
            <p class="text-muted">View all records in the dataset table used for model training</p>
        </div>
        
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-database me-1"></i>
                    Dataset Records ({{ $dataset->total() }} total)
                </div>
                <a href="{{ route('admin.model-upload.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Back to Model Upload
                </a>
            </div>
            <div class="card-body">
                <div class="alert alert-info mb-4">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Dataset Information:</strong> This table shows all records currently stored in the dataset table used for model training and predictions.
                </div>

                <!-- Search and Filter Section -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" class="form-control" id="searchInput" placeholder="Search by student number, degree, or name...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" id="degreeFilter">
                            <option value="">All Degrees</option>
                            @php
                                $uniqueDegrees = \App\Models\Student::distinct()->pluck('degree')->sort()->values();
                            @endphp
                            @foreach($uniqueDegrees as $degree)
                                <option value="{{ $degree }}">{{ $degree }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" id="employabilityFilter">
                            <option value="">All Status</option>
                            <option value="Employable">Employable</option>
                            <option value="Less Employable">Less Employable</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" id="boardPasserFilter">
                            <option value="">All Board Status</option>
                            <option value="1">Board Passer</option>
                            <option value="0">Non-Board Passer</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-outline-secondary w-100" id="clearFilters">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <!-- Results Summary -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="text-muted">
                            <span id="resultsCount">{{ $dataset->count() }}</span> records found
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="btn-group" role="group">
                            {{-- <button type="button" class="btn btn-outline-primary btn-sm" id="exportCsv">
                                <i class="fas fa-download"></i> Export CSV
                            </button> --}}
                            <button type="button" class="btn btn-outline-success btn-sm" id="refreshData">
                                <i class="fas fa-sync-alt"></i> Refresh
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Student Number</th>
                                <th>Gender</th>
                                <th>Age</th>
                                <th>Degree</th>
                                <th>Year Graduated</th>
                                <th>CGPA</th>
                                <th>Avg Prof Grade</th>
                                <th>Avg Elec Grade</th>
                                <th>OJT Grade</th>
                                <th>Soft Skills</th>
                                <th>Hard Skills</th>
                                <th>Employability</th>
                                <th>Board Passer</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dataset as $record)
                                <tr>
                                    <td>{{ $record->student_number }}</td>
                                    <td>{{ $record->gender }}</td>
                                    <td>{{ $record->age }}</td>
                                    <td>{{ $record->degree }}</td>
                                    <td>{{ $record->year_graduated }}</td>
                                    <td>{{ $record->cgpa }}</td>
                                    <td>{{ $record->average_prof_grade }}</td>
                                    <td>{{ $record->average_elec_grade }}</td>
                                    <td>{{ $record->ojt_grade }}</td>
                                    <td>{{ $record->soft_skills_ave }}</td>
                                    <td>{{ $record->hard_skills_ave }}</td>
                                    <td>{{ $record->employability }}</td>
                                    <td>
                                        <span class="badge {{ $record->board_passer ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $record->board_passer ? 'Yes' : 'No' }}
                                        </span>
                                    </td>
                                    <td>{{ $record->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info view-skills-details" 
                                                data-student-number="{{ $record->student_number }}"
                                                data-degree="{{ $record->degree }}"
                                                data-age="{{ $record->age }}"
                                                data-cgpa="{{ $record->cgpa }}"
                                                data-prof-grade="{{ $record->average_prof_grade }}"
                                                data-elec-grade="{{ $record->average_elec_grade }}"
                                                data-ojt-grade="{{ $record->ojt_grade }}"
                                                data-soft-skills="{{ $record->soft_skills_ave }}"
                                                data-hard-skills="{{ $record->hard_skills_ave }}"
                                                data-year-graduated="{{ $record->year_graduated }}"
                                                data-employability="{{ $record->employability }}"
                                                data-board-passer="{{ $record->board_passer }}"
                                                data-auditing-skills="{{ $record->auditing_skills ?? 0 }}"
                                                data-budgeting-analysis-skills="{{ $record->budgeting_analysis_skills ?? 0 }}"
                                                data-classroom-management-skills="{{ $record->classroom_management_skills ?? 0 }}"
                                                data-cloud-computing-skills="{{ $record->cloud_computing_skills ?? 0 }}"
                                                data-curriculum-development-skills="{{ $record->curriculum_development_skills ?? 0 }}"
                                                data-data-structures-algorithms="{{ $record->data_structures_algorithms ?? 0 }}"
                                                data-database-management-skills="{{ $record->database_management_skills ?? 0 }}"
                                                data-educational-technology-skills="{{ $record->educational_technology_skills ?? 0 }}"
                                                data-financial-accounting-skills="{{ $record->financial_accounting_skills ?? 0 }}"
                                                data-financial-management-skills="{{ $record->financial_management_skills ?? 0 }}"
                                                data-java-programming-skills="{{ $record->java_programming_skills ?? 0 }}"
                                                data-leadership-decision-making-skills="{{ $record->leadership_decision_making_skills ?? 0 }}"
                                                data-machine-learning-skills="{{ $record->machine_learning_skills ?? 0 }}"
                                                data-marketing-skills="{{ $record->marketing_skills ?? 0 }}"
                                                data-networking-skills="{{ $record->networking_skills ?? 0 }}"
                                                data-programming-logic-skills="{{ $record->programming_logic_skills ?? 0 }}"
                                                data-python-programming-skills="{{ $record->python_programming_skills ?? 0 }}"
                                                data-software-engineering-skills="{{ $record->software_engineering_skills ?? 0 }}"
                                                data-strategic-planning-skills="{{ $record->strategic_planning_skills ?? 0 }}"
                                                data-system-design-skills="{{ $record->system_design_skills ?? 0 }}"
                                                data-taxation-skills="{{ $record->taxation_skills ?? 0 }}"
                                                data-teaching-skills="{{ $record->teaching_skills ?? 0 }}"
                                                data-web-development-skills="{{ $record->web_development_skills ?? 0 }}"
                                                data-statistical-analysis-skills="{{ $record->statistical_analysis_skills ?? 0 }}"
                                                data-english-communication-writing-skills="{{ $record->english_communication_writing_skills ?? 0 }}"
                                                data-filipino-communication-writing-skills="{{ $record->filipino_communication_writing_skills ?? 0 }}"
                                                data-early-childhood-education-skills="{{ $record->early_childhood_education_skills ?? 0 }}"
                                                data-customer-service-skills="{{ $record->customer_service_skills ?? 0 }}"
                                                data-event-management-skills="{{ $record->event_management_skills ?? 0 }}"
                                                data-food-beverage-management-skills="{{ $record->food_beverage_management_skills ?? 0 }}"
                                                data-risk-management-skills="{{ $record->risk_management_skills ?? 0 }}"
                                                data-innovation-business-planning-skills="{{ $record->innovation_business_planning_skills ?? 0 }}"
                                                data-consumer-behavior-analysis="{{ $record->consumer_behavior_analysis ?? 0 }}"
                                                data-sales-management-skills="{{ $record->sales_management_skills ?? 0 }}"
                                                data-artificial-intelligence-skills="{{ $record->artificial_intelligence_skills ?? 0 }}"
                                                data-cybersecurity-skills="{{ $record->cybersecurity_skills ?? 0 }}"
                                                data-circuit-design-skills="{{ $record->circuit_design_skills ?? 0 }}"
                                                data-communication-systems-skills="{{ $record->communication_systems_skills ?? 0 }}"
                                                data-problem-solving-skills="{{ $record->problem_solving_skills ?? 0 }}"
                                                data-clinical-skills="{{ $record->clinical_skills ?? 0 }}"
                                                data-patient-care-skills="{{ $record->patient_care_skills ?? 0 }}"
                                                data-health-assessment-skills="{{ $record->health_assessment_skills ?? 0 }}"
                                                data-emergency-response-skills="{{ $record->emergency_response_skills ?? 0 }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="15" class="text-center text-muted">
                                        <i class="fas fa-database fa-2x mb-2"></i>
                                        <br>No dataset records found. Please sync data from users first.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($dataset->count() > 0)
                    <div class="mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="text-muted">
                                Showing {{ $dataset->firstItem() }} to {{ $dataset->lastItem() }} of {{ $dataset->total() }} entries
                            </div>
                            <div class="text-muted">
                                Page {{ $dataset->currentPage() }} of {{ $dataset->lastPage() }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <nav aria-label="Dataset pagination">
                                {{ $dataset->links('pagination::bootstrap-4') }}
                            </nav>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Skills Details Modal -->
        <div class="modal fade" id="skillsDetailsModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Student Skills Assessment Details</h5>
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
                                <h6 class="text-primary mb-3">Overall Skills</h6>
                                <div class="mb-2">
                                    <strong>Soft Skills Average:</strong> <span id="modal-soft-skills"></span>
                                </div>
                                <div class="mb-2">
                                    <strong>Hard Skills Average:</strong> <span id="modal-hard-skills"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">Employment Status</h6>
                                <div class="mb-2">
                                    <strong>Employability:</strong> 
                                    <span id="modal-employability" class="badge"></span>
                                </div>
                                <div class="mb-2">
                                    <strong>Board Passer:</strong> 
                                    <span id="modal-board-passer" class="badge"></span>
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="text-primary mb-3">Degree-Specific Skills Assessment</h6>
                                <div id="skills-container">
                                    <!-- Skills will be dynamically loaded here -->
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Note:</strong> Skills are rated on a scale of 1-5, where 1 = Beginner and 5 = Expert.
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

    <style>
        /* Pagination styling */
        .pagination {
            margin-bottom: 0;
        }
        
        .pagination .page-link {
            color: #007bff;
            background-color: #fff;
            border: 1px solid #dee2e6;
            padding: 0.5rem 0.75rem;
            margin: 0 2px;
            border-radius: 0.25rem;
        }
        
        .pagination .page-link:hover {
            color: #0056b3;
            background-color: #e9ecef;
            border-color: #dee2e6;
        }
        
        .pagination .page-item.active .page-link {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }
        
        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            background-color: #fff;
            border-color: #dee2e6;
        }
        
        /* Responsive pagination */
        @media (max-width: 768px) {
            .pagination {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .pagination .page-link {
                padding: 0.375rem 0.5rem;
                font-size: 0.875rem;
                margin: 1px;
            }
        }
        
        /* Search and Filter Styling */
        .input-group-text {
            background-color: #f8f9fa;
            border-color: #dee2e6;
        }
        
        .form-select:focus,
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        
        #clearFilters {
            transition: all 0.3s ease;
        }
        
        #clearFilters:hover {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
        }
        
        .btn-group .btn {
            transition: all 0.3s ease;
        }
        
        .btn-group .btn:hover {
            transform: translateY(-1px);
        }
        
        /* Results count styling */
        #resultsCount {
            font-weight: 600;
            color: #007bff;
        }
        
        /* Table row highlighting on search */
        .table tbody tr:not(.no-results-row) {
            transition: background-color 0.3s ease;
        }
        
        .table tbody tr:not(.no-results-row):hover {
            background-color: #f8f9fa;
        }
        
        /* Empty state styling */
        .no-results-row {
            background-color: #f8f9fa;
        }
        
        .no-results-row td {
            padding: 2rem;
            font-style: italic;
        }
        
        /* Responsive search filters */
        @media (max-width: 768px) {
            .row.mb-4 .col-md-4,
            .row.mb-4 .col-md-3,
            .row.mb-4 .col-md-2,
            .row.mb-4 .col-md-1 {
                margin-bottom: 0.5rem;
            }
        }
    </style>

    <script>
        // Search and Filter functionality
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const degreeFilter = document.getElementById('degreeFilter');
            const employabilityFilter = document.getElementById('employabilityFilter');
            const boardPasserFilter = document.getElementById('boardPasserFilter');
            const clearFiltersBtn = document.getElementById('clearFilters');
            const resultsCount = document.getElementById('resultsCount');
            const exportCsvBtn = document.getElementById('exportCsv');
            const refreshDataBtn = document.getElementById('refreshData');
            
            const table = document.querySelector('table tbody');
            const allRows = Array.from(table.querySelectorAll('tr'));
            
            // Store original data for filtering
            let filteredRows = [...allRows];
            
            // Search functionality
            function performSearch() {
                const searchTerm = searchInput.value.toLowerCase();
                const selectedDegree = degreeFilter.value;
                const selectedEmployability = employabilityFilter.value;
                const selectedBoardPasser = boardPasserFilter.value;
                
                filteredRows = allRows.filter(row => {
                    const cells = row.querySelectorAll('td');
                    if (cells.length === 0) return true; // Skip empty rows
                    
                    // Search term filter
                    let matchesSearch = true;
                    if (searchTerm) {
                        matchesSearch = Array.from(cells).some(cell => 
                            cell.textContent.toLowerCase().includes(searchTerm)
                        );
                    }
                    
                    // Degree filter
                    let matchesDegree = true;
                    if (selectedDegree) {
                        const degreeCell = cells[3]; // Degree column
                        matchesDegree = degreeCell && degreeCell.textContent.trim() === selectedDegree;
                    }
                    
                    // Employability filter
                    let matchesEmployability = true;
                    if (selectedEmployability) {
                        const employabilityCell = cells[11]; // Employability column
                        matchesEmployability = employabilityCell && employabilityCell.textContent.trim() === selectedEmployability;
                    }
                    
                    // Board passer filter
                    let matchesBoardPasser = true;
                    if (selectedBoardPasser !== '') {
                        const boardPasserCell = cells[12]; // Board Passer column
                        const isBoardPasser = boardPasserCell && boardPasserCell.textContent.trim() === 'Yes';
                        matchesBoardPasser = (selectedBoardPasser === '1' && isBoardPasser) || 
                                           (selectedBoardPasser === '0' && !isBoardPasser);
                    }
                    
                    return matchesSearch && matchesDegree && matchesEmployability && matchesBoardPasser;
                });
                
                updateTable();
                updateResultsCount();
            }
            
            // Update table display
            function updateTable() {
                // Hide all rows first
                allRows.forEach(row => {
                    row.style.display = 'none';
                });
                
                // Show filtered rows
                filteredRows.forEach(row => {
                    row.style.display = '';
                });
                
                // Show empty message if no results
                if (filteredRows.length === 0) {
                    showEmptyMessage();
                } else {
                    hideEmptyMessage();
                }
            }
            
            // Show empty message
            function showEmptyMessage() {
                let emptyRow = table.querySelector('.no-results-row');
                if (!emptyRow) {
                    emptyRow = document.createElement('tr');
                    emptyRow.className = 'no-results-row';
                    emptyRow.innerHTML = `
                        <td colspan="15" class="text-center text-muted">
                            <i class="fas fa-search fa-2x mb-2"></i>
                            <br>No records found matching your search criteria.
                        </td>
                    `;
                    table.appendChild(emptyRow);
                }
                emptyRow.style.display = '';
            }
            
            // Hide empty message
            function hideEmptyMessage() {
                const emptyRow = table.querySelector('.no-results-row');
                if (emptyRow) {
                    emptyRow.style.display = 'none';
                }
            }
            
            // Update results count
            function updateResultsCount() {
                const count = filteredRows.length;
                resultsCount.textContent = count;
            }
            
            // Clear all filters
            function clearAllFilters() {
                searchInput.value = '';
                degreeFilter.value = '';
                employabilityFilter.value = '';
                boardPasserFilter.value = '';
                performSearch();
            }
            
            // Export filtered data to CSV
            function exportToCSV() {
                const headers = [
                    'Student Number', 'Gender', 'Age', 'Degree', 'Year Graduated', 
                    'CGPA', 'Avg Prof Grade', 'Avg Elec Grade', 'OJT Grade', 
                    'Soft Skills', 'Hard Skills', 'Employability', 'Board Passer', 'Created At'
                ];
                
                const csvContent = [
                    headers.join(','),
                    ...filteredRows.map(row => {
                        const cells = row.querySelectorAll('td');
                        return Array.from(cells).slice(0, 14).map(cell => {
                            let content = cell.textContent.trim();
                            // Handle board passer column
                            if (content === 'Yes' || content === 'No') {
                                content = content === 'Yes' ? '1' : '0';
                            }
                            // Escape commas and quotes
                            if (content.includes(',') || content.includes('"')) {
                                content = '"' + content.replace(/"/g, '""') + '"';
                            }
                            return content;
                        }).join(',');
                    })
                ].join('\n');
                
                const blob = new Blob([csvContent], { type: 'text/csv' });
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `dataset_filtered_${new Date().toISOString().split('T')[0]}.csv`;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                window.URL.revokeObjectURL(url);
            }
            
            // Event listeners
            searchInput.addEventListener('input', performSearch);
            degreeFilter.addEventListener('change', performSearch);
            employabilityFilter.addEventListener('change', performSearch);
            boardPasserFilter.addEventListener('change', performSearch);
            clearFiltersBtn.addEventListener('click', clearAllFilters);
            exportCsvBtn.addEventListener('click', exportToCSV);
            refreshDataBtn.addEventListener('click', () => {
                window.location.reload();
            });
            
            // Initialize
            performSearch();
        });

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

        // Handle view skills details button clicks
        document.addEventListener('click', function(e) {
            if (e.target.closest('.view-skills-details')) {
                const button = e.target.closest('.view-skills-details');
                const data = button.dataset;
                
                // Debug: Log all data attributes
                console.log('All data attributes:', data);
                
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
                
                // Set employability badge
                const employabilityBadge = document.getElementById('modal-employability');
                employabilityBadge.textContent = data.employability;
                employabilityBadge.className = 'badge ' + (data.employability === 'Employable' ? 'bg-success' : 'bg-danger');
                
                // Set board passer badge
                const boardPasserBadge = document.getElementById('modal-board-passer');
                boardPasserBadge.textContent = data.boardPasser === '1' ? 'Yes' : 'No';
                boardPasserBadge.className = 'badge ' + (data.boardPasser === '1' ? 'bg-success' : 'bg-secondary');
                
                // Load skills based on degree
                loadSkillsForDegree(data.degree, data);
                
                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('skillsDetailsModal'));
                modal.show();
            }
        });

        function loadSkillsForDegree(degree, studentData) {
            const skillsContainer = document.getElementById('skills-container');
            const skills = getSkillsForDegree(degree);
            
            if (skills.length === 0) {
                skillsContainer.innerHTML = '<div class="alert alert-warning">No specific skills defined for this degree.</div>';
                return;
            }
            
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
    </script>
</x-admin-layout>
