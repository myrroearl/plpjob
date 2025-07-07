<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alumni_prediction_models', function (Blueprint $table) {
            $table->id();
            $table->string('model_name');
            $table->integer('total_alumni');
            $table->float('prediction_accuracy');
            $table->text('employment_rate_forecast_line_image');
            $table->timestamp('last_updated')->useCurrent()->useCurrentOnUpdate();
            $table->float('rmse')->nullable();
            $table->float('mae')->nullable();
            $table->float('r2')->nullable();
            $table->float('aic')->nullable();
            $table->float('confidence_interval')->nullable();
            $table->float('actual_rate')->nullable();
            $table->float('predicted_rate')->nullable();
            $table->float('margin_of_error')->nullable();
            $table->text('employment_rate_comparison_image');
            $table->text('predicted_employability_by_degree_image');
            $table->text('distribution_of_predicted_employment_rates_image');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumni_prediction_models');
    }
}; 