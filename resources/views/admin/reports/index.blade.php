<x-admin-layout>
    @section('title', 'Reports Generation')

    <div class="main-content">
        <div class="dashboard-header">
            <h1>Reports Generation</h1>
            <p class="text-muted">Filter and export comprehensive employment reports</p>
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