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
            // نغير نوع البيانات إلى bigInteger لاستيعاب الأرقام الكبيرة
            // إذا كنت متأكداً أن القيم لن تكون سالبة، يمكنك إضافة ->unsigned()
            $table->bigInteger('meter_before')->nullable()->change();
            $table->bigInteger('meter_after')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fuel_station_details', function (Blueprint $table) {
            // عند التراجع، نرجع نوع البيانات إلى ما كان عليه (string في حالتك الأصلية)
            // كن حذراً: هذا قد يسبب فقدان بيانات إذا كانت القيم المخزنة تتجاوز حدود string.
            $table->string('meter_before')->nullable()->change();
            $table->string('meter_after')->nullable()->change();
        });
    }
};