<x-admin-layout>
    @section('title', 'Predict & Report')

    <div class="main-content">
        <div class="dashboard-header">
            <h1>Student Employment Prediction</h1>
            <p class="text-muted">Analyze and predict individual student employment probability</p>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="dashboard-card">
                    <h3 class="card-title mb-4">Data Input</h3>
                    <form action="{{ route('admin.student-forecast.processPrediction') }}" method="post" id="studentForecastForm" enctype="multipart/form-data">
                        @csrf
                        <div id="fileUploadSection" class="mb-3">
                            <label class="form-label">Student Data File</label>
                            <div class="upload-area-small" id="uploadArea">
                                <input type="file" name="csvFile" id="csvFile" accept=".csv" hidden>
                                <div class="upload-content-small text-center">
                                    <i class="fas fa-file-csv fa-2x mb-2"></i>
                                    <p class="mb-1">Drop your CSV file here</p>
                                    <button type="button" class="btn btn-outline-success btn-sm" onclick="document.getElementById('csvFile').click()">
                                        Browse
                                    </button>
                                </div>
                            </div>
                            <small class="text-muted d-block mt-2">Download template: 
                                <a href="#" class="text-success">student_template.csv</a>
                            </small>
                        </div>

                        <button type="submit" class="btn btn-success w-100 mb-3">
                            <i class="fas fa-calculator me-2"></i>Generate Predictions
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <div class="dashboard-card">
                            <div class="stat-card">
                                <div class="stat-icon bg-success-light">
                                    <i class="fas fa-user-check text-success"></i>
                                </div>
                                <div class="stat-details">
                                    <h4>High Probability</h4>
                                    <h2>75%</h2>
                                    <small class="text-success">{{ $highProbabilityCount }} Students</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="dashboard-card">
                            <div class="stat-card">
                                <div class="stat-icon bg-warning-light">
                                    <i class="fas fa-user-clock text-warning"></i>
                                </div>
                                <div class="stat-details">
                                    <h4>Medium Probability</h4>
                                    <h2>50%</h2>
                                    <small class="text-warning">{{ $mediumProbabilityCount }} Students</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="dashboard-card">
                            <div class="stat-card">
                                <div class="stat-icon bg-danger-light">
                                    <i class="fas fa-user-times text-danger"></i>
                                </div>
                                <div class="stat-details">
                                    <h4>Low Probability</h4>
                                    <h2>5%</h2>
                                    <small class="text-danger">{{ $lowProbabilityCount }} Students</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                            <th>Gender</th>
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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($csvData as $row)
                            <tr>
                                <td>{{ $row['Student Number'] }}</td>
                                <td>{{ $row['Gender'] }}</td>
                                <td>{{ $row['Age'] }}</td>
                                <td>{{ $row['Degree'] }}</td>
                                <td>{{ $row['CGPA'] }}</td>
                                <td>{{ $row['Average Prof Grade'] }}</td>
                                <td>{{ $row['Average Elec Grade'] }}</td>
                                <td>{{ $row['OJT Grade'] }}</td>
                                <td>{{ $row['Soft Skills Ave'] }}</td>
                                <td>{{ $row['Hard Skills Ave'] }}</td>
                                <td>{{ $row['Year Graduated'] }}</td>
                                <td class="{{ $row['Predicted_Employability'] == 'Not Employable' ? 'bg-success' : 'bg-danger' }}">
                                    <span class="badge">{{ $row['Predicted_Employability'] == 'Employable' ? 'Not Employable' : 'Employable' }}</span>
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
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="container mt-5">
            <h2>Prediction Visualizations</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="dashboard-card">
                        <img src="<?php echo asset('storage/predictions/employability_by_degree.png'); ?>" alt="Employability by Degree" class="img-fluid">
                        <h5 class="text-center">Predicted Employability by Degree</h5>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="dashboard-card">
                        <img src="<?php echo asset('storage/predictions/employment_rate_distribution.png'); ?>" alt="Employment Rate Distribution" class="img-fluid">
                        <h5 class="text-center">Distribution of Predicted Employment Rates</h5>
                    </div>
                </div>
                
            </div>
    
            <div class="row">
                <div class="col-md-12">
                    <div class="dashboard-card">
                        <img src="<?php echo asset('storage/predictions/top5_features.png'); ?>" alt="Top 5 Features" class="img-fluid">
                        <h5 class="text-center">Top 5 Factors Affecting Employability</h5>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        function printFilteredReport() {
            const yearFilter = document.getElementById('yearFilter').value;
            const degreeFilter = document.getElementById('degreeFilter').value;
            
            let url = '{{ route("admin.reports.print") }}?';
            if (yearFilter) url += 'year=' + encodeURIComponent(yearFilter) + '&';
            if (degreeFilter) url += 'degree=' + encodeURIComponent(degreeFilter);
            
            window.open(url, '_blank');
        }
        </script>

    <script src="{{ asset('assets/js/student_forecast.js') }}"></script>
</x-admin-layout>