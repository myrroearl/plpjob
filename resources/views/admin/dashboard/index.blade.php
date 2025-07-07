<x-admin-layout>
    @section('title', 'Dashboard')
    <div class="main-content">
        <div class="dashboard-header">
            <h1>Admin Dashboard</h1>
        </div>
        
        <div class="row">
            <!-- Quick Stats Cards -->
            <div class="col-md-3">
                <div class="dashboard-card">
                    <h4>Total Alumni</h4>
                    <h2>{{ number_format($modelData->total_alumni) }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="dashboard-card">
                    <h4>Employment Rate</h4>
                    <h2>{{ number_format($modelData->actual_rate, 1) }}%</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="dashboard-card">
                    <h4>Prediction Accuracy</h4>
                    <h2>{{ number_format($modelData->prediction_accuracy, 1) }}%</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="dashboard-card">
                    <h4>Margin of Error</h4>
                    <h2>±{{ number_format($modelData->margin_of_error, 1) }}%</h2>
                </div>
            </div>
        </div>
        
        <!-- Main Content Area -->
        <div class="row mt-4">
            <div class="col-md-8">
                <div class="dashboard-card">
                    <h3>Employment Rate Forecast</h3>
                    <img src="{{ asset('assets/figures/' . $modelData->employment_rate_forecast_line_image) }}" 
                         class="img-fluid" alt="Employment Rate Forecast">
                </div>
            </div>
            <div class="col-md-4">
                <div class="dashboard-card">
                    <h3>Quick Actions</h3>
                    <div class="action-buttons">
                        <a href="{{ route('admin.model-upload.index') }}" class="btn btn-success mb-2 w-100">Upload Data Model</a>
                        <a href="{{ route('admin.forecasting.index') }}" class="btn btn-success mb-2 w-100">Forecasting</a>
                        <a href="{{ route('admin.student-forecast.index') }}" class="btn btn-success mb-2 w-100">Generate Reports</a>
                        
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

