<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('employment_status', ['yes', 'no', 'other']);
            $table->string('company_name')->nullable();
            $table->string('position')->nullable();
            $table->string('employment_duration')->nullable();
            $table->text('improvements')->nullable();
            $table->text('additional_comments')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('feedback');
    }
};
