<x-admin-layout>
    @section('title', 'Forecasting')
    
    <div class="main-content">
        <div class="dashboard-header">
            <h1>Employment Rate Forecasting</h1>
            <p class="text-muted">Generate and analyze employment rate predictions using ARIMA model</p>
        </div>
        
        <div class="row mb-5">
            <!-- Main Forecast Display -->
            <div class="col-md-12 mb-4">
                <div class="dashboard-card">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="card-title mb-0">How many alumni are employable in the next 3 years?</h3>
                    </div>
                    <div id="forecastChart" >
                        <img src="https://cawdbumigiwafukejndb.supabase.co/storage/v1/object/public/adminfiles//employment_rate_comparison.png" 
                            class="img-fluid" alt="Employment Rate Forecast">
                    </div>
                </div>
            </div>

            <!-- Model Information -->
            <div class="col-md-4">
                <div class="dashboard-card">
                    <h3 class="card-title mb-3">Model Information</h3>
                    <div class="model-info">
                        <div class="info-item">
                            <span class="info-label">Last Updated:</span>
                            <span class="info-value">{{ $modelData ? \Carbon\Carbon::parse($modelData['last_updated'])->format('F d, Y') : 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Accuracy Score:</span>
                            <span class="info-value">{{ number_format($modelData['prediction_accuracy'] ?? 0, 1) }}%</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Total Alumni:</span>
                            <span class="info-value">{{ number_format($modelData['total_alumni'] ?? 0) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Key Metrics -->
            <div class="col-md-4">
                <div class="dashboard-card">
                    <h3 class="card-title mb-3">Key Metrics</h3>
                    <div class="metric-grid">
                        <div class="metric-item">
                            <span class="metric-label">RMSE</span>
                            <span class="metric-value">{{ number_format($modelData['rmse'] ?? 0, 4) }}</span>
                        </div>
                        <div class="metric-item">
                            <span class="metric-label">MAE</span>
                            <span class="metric-value">{{ number_format($modelData['mae'] ?? 0, 4) }}</span>
                        </div>
                        {{-- <div class="metric-item">
                            <span class="metric-label">R²</span>
                            <span class="metric-value">{{ number_format($modelData->r2, 3) }}</span>
                        </div> --}}
                        <div class="metric-item">
                            <span class="metric-label">AIC</span>
                            <span class="metric-value">{{ number_format($modelData['aic'] ?? 0, 1) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Forecast Summary -->
            <div class="col-md-4">
                <div class="dashboard-card">
                    <h3 class="card-title mb-3">Forecast Summary</h3>
                    <div class="forecast-summary">
                        <div class="summary-item">
                            <i class="fas fa-arrow-trend-up text-success"></i>
                            <div>
                                <h4>{{ number_format($modelData['predicted_rate'] ?? 0, 1) }}%</h4>
                                <span>Predicted Employment Rate</span>
                            </div>
                        </div>
                        <div class="summary-item">
                            <i class="fas fa-plus-minus text-primary"></i>
                            <div>
                                <h4>±{{ number_format($modelData['confidence_interval'] ?? 0, 1) }}%</h4>
                                <span>Confidence Interval</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .dashboard-card {
            height: 100%;
            margin-bottom: 20px;
        }

        .model-info .info-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .model-info .info-item:last-child {
            border-bottom: none;
        }

        .metric-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .metric-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
        }

        .metric-label {
            display: block;
            color: #6c757d;
            font-size: 0.875rem;
            margin-bottom: 5px;
        }

        .metric-value {
            display: block;
            font-size: 1.25rem;
            font-weight: 600;
            color: #198754;
        }

        .forecast-summary .summary-item {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .forecast-summary .summary-item i {
            font-size: 1.5rem;
            padding: 12px;
            background: #fff;
            border-radius: 50%;
        }

        .forecast-summary .summary-item h4 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
        }

        .forecast-summary .summary-item span {
            color: #6c757d;
            font-size: 0.875rem;
        }

        #forecastChart {
            width: 100%;
            margin: 0 auto;
        }

        #forecastChart img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
    </style>
    @endpush
</x-admin-layout> 
