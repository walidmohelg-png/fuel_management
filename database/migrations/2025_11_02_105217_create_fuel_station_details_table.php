<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fuel_station_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('station_id')->constrained('fuel_stations')->onDelete('cascade');

            // 🔹 بيانات التشغيل
            $table->string('fuel_type')->nullable();
            $table->string('fuel_quantity')->nullable(); // ← نص بدل رقم لتجنب الخطأ عند كتابة وحدات أو رموز
            $table->string('tank_count')->nullable();   // ← قد يُكتب نصيًّا
            $table->string('meter_before')->nullable(); // ← نحوله لنص لتجنب Out of range
            $table->string('meter_after')->nullable();  // ← كذلك هنا
            $table->string('supply_days')->nullable();  // ← لتخزين أيام التزويد مثل "19-11-2025 , 20-11-2025"

            // 🔹 بيانات السلامة والتجهيزات
            $table->boolean('fire_equipment')->default(false);
            $table->boolean('signs')->default(false);
            $table->boolean('lighting')->default(false);
            $table->boolean('flooring')->default(false);
            $table->boolean('electrical_materials')->default(false);
            $table->boolean('cameras')->default(false);
            $table->boolean('cleanliness')->default(false);

            // 🔹 بيانات إضافية
            $table->string('station_contract')->nullable();
            $table->string('license')->nullable();
            $table->string('license_status')->nullable();         // ← أضفتها لأنك تستخدمها في النموذج
            $table->string('station_contract_status')->nullable(); // ← أضفتها أيضًا
            $table->date('last_calibration')->nullable();
            $table->date('last_inspection')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fuel_station_details');
    }
};
