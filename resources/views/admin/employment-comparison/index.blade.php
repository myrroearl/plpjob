<x-admin-layout>
    @section('title', 'Employment Rate Comparison')
    
    <div class="main-content">
        <div class="dashboard-header">
            <h1>Employment Rate Comparison</h1>
            <p class="text-muted">Actual vs Predicted Employment Rate Analysis</p>
        </div>

        <!-- Overview Cards -->
        <div class="row">
            <div class="col-md-3">
                <div class="dashboard-card">
                    <div class="stat-card">
                        <div class="stat-icon bg-success-light">
                            <i class="fas fa-chart-line text-success"></i>
                        </div>
                        <div class="stat-details">
                            <h4>Actual Rate</h4>
                            <h2>{{ number_format($modelData->actual_rate, 1) }}%</h2>
                            <small class="text-success">Current Year</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="dashboard-card">
                    <div class="stat-card">
                        <div class="stat-icon bg-primary-light">
                            <i class="fas fa-robot text-primary"></i>
                        </div>
                        <div class="stat-details">
                            <h4>Predicted Rate</h4>
                            <h2>{{ number_format($modelData->predicted_rate, 1) }}%</h2>
                            <small class="text-primary">AI Forecast</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="dashboard-card">
                    <div class="stat-card">
                        <div class="stat-icon bg-info-light">
                            <i class="fas fa-bullseye text-info"></i>
                        </div>
                        <div class="stat-details">
                            <h4>Accuracy</h4>
                            <h2>{{ number_format($modelData->prediction_accuracy, 1) }}%</h2>
                            <small class="text-info">Prediction Accuracy</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="dashboard-card">
                    <div class="stat-card">
                        <div class="stat-icon bg-warning-light">
                            <i class="fas fa-percentage text-warning"></i>
                        </div>
                        <div class="stat-details">
                            <h4>Margin of Error</h4>
                            <h2>{{ number_format($modelData->margin_of_error, 1) }}%</h2>
                            <small class="text-warning">Average Deviation</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Comparison Chart -->
        <div class="row">
            <div class="col-md-12">
                <div class="dashboard-card mb-5">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="card-title">Employment Rate Comparison</h3>
                    </div>
                    <div id="comparisonChart">
                        <img src="{{ asset('assets/figures/' . $modelData->employment_rate_forecast_line_image) }}" 
                            class="img-fluid" alt="Employment Rate Forecast">
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .stat-card {
            display: flex;
            align-items: center;
            padding: 1rem;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
        }

        .bg-success-light {
            background-color: rgba(25, 135, 84, 0.1);
        }

        .bg-primary-light {
            background-color: rgba(13, 110, 253, 0.1);
        }

        .bg-info-light {
            background-color: rgba(13, 202, 240, 0.1);
        }

        .bg-warning-light {
            background-color: rgba(255, 193, 7, 0.1);
        }

        .stat-details h4 {
            margin: 0;
            font-size: 0.875rem;
            color: #6c757d;
        }

        .stat-details h2 {
            margin: 0.25rem 0;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .stat-details small {
            font-size: 0.75rem;
        }

        #comparisonChart {
            width: 100%;
            height: 400px;
        }

        #comparisonChart img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .dashboard-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
    </style>
    @endpush
</x-admin-layout> 