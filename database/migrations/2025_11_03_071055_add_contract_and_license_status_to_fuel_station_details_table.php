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
            $table->enum('station_contract_status', ['ساري', 'منتهي'])->nullable()->after('station_contract');
            $table->enum('license_status', ['صالح', 'منتهي الصلاحية'])->nullable()->after('license');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fuel_station_details', function (Blueprint $table) {
            $table->dropColumn('station_contract_status');
            $table->dropColumn('license_status');
        });
    }
};