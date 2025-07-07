<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlumniPredictionModel extends Model
{
    protected $fillable = [
        'model_name',
        'total_alumni',
        'prediction_accuracy',
        'employment_rate_forecast_line_image',
        'last_updated',
        'rmse',
        'mae',
        'r2',
        'aic',
        'confidence_interval',
        'actual_rate',
        'predicted_rate',
        'margin_of_error',
        'employment_rate_comparison_image',
        'predicted_employability_by_degree_image',
        'distribution_of_predicted_employment_rates_image'
    ];

    protected $casts = [
        'prediction_accuracy' => 'float',
        'rmse' => 'float',
        'mae' => 'float',
        'r2' => 'float',
        'aic' => 'float',
        'confidence_interval' => 'float',
        'actual_rate' => 'float',
        'predicted_rate' => 'float',
        'margin_of_error' => 'float',
        'last_updated' => 'datetime'
    ];
} 