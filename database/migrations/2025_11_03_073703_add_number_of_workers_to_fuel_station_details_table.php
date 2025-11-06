<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('fuel_station_details', function (Blueprint $table) {
            $table->integer('number_of_workers')->nullable()->after('last_inspection'); // أو بعد أي عمود تراه مناسباً
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fuel_station_details', function (Blueprint $table) {
            $table->dropColumn('number_of_workers');
        });
    }
};