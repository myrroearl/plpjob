<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'is_board_passer')) {
                $table->boolean('is_board_passer')->nullable()->default(null)->after('leadership');
                $table->string('board_exam_name', 150)->nullable()->after('is_board_passer');
                $table->integer('board_exam_year')->nullable()->after('board_exam_name');
                $table->string('license_number', 100)->nullable()->after('board_exam_year');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_board_passer', 'board_exam_name', 'board_exam_year', 'license_number']);
        });
    }
};
