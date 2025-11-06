<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('fuel_station_details', function (Blueprint $table) {
            $table->string('supply_days', 255)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('fuel_station_details', function (Blueprint $table) {
            $table->integer('supply_days')->nullable()->change();
        });
    }

};
