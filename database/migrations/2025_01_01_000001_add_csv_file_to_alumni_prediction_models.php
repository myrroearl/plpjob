<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alumni_prediction_models', function (Blueprint $table) {
            $table->string('csv_filename')->nullable()->after('model_name');
            $table->text('csv_url')->nullable()->after('csv_filename');
        });
    }

    public function down(): void
    {
        Schema::table('alumni_prediction_models', function (Blueprint $table) {
            $table->dropColumn(['csv_filename', 'csv_url']);
        });
    }
}; 
