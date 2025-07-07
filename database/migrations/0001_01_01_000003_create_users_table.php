<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 100);
            $table->string('middle_name', 100);
            $table->string('last_name', 100);
            $table->string('degree_name', 100);
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('age')->nullable();
            $table->decimal('average_grade', 5, 2)->nullable();
            $table->boolean('act_member')->nullable()->default(null);
            $table->boolean('leadership')->nullable()->default(null);
            $table->enum('role', ['user', 'recruiter', 'admin'])->nullable()->default(null);
            // Add board passer columns
            $table->boolean('is_board_passer')->nullable()->default(null);
            $table->string('board_exam_name', 150)->nullable();
            $table->integer('board_exam_year')->nullable();
            $table->string('license_number', 100)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};