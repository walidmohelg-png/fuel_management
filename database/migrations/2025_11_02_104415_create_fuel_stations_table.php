<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fuel_stations', function (Blueprint $table) {
            $table->id();
            
            // 🔹 ربط المحطة بشركة توزيع
            $table->foreignId('distributor_id')->constrained('distributors')->onDelete('cascade');
            
            // 🔹 بيانات عامة
            $table->string('station_name');
            $table->string('station_number')->unique();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();

            // 🔹 بيانات صاحب المحطة
            $table->string('owner_name')->nullable();
            $table->string('owner_phone')->nullable();
            $table->string('owner_nid')->nullable();
            $table->string('owner_passport')->nullable();
            $table->string('owner_photo')->nullable();

            // 🔹 بيانات المشرف على المحطة
            $table->string('supervisor_name')->nullable();
            $table->string('supervisor_phone')->nullable();
            $table->string('supervisor_nid')->nullable();
            $table->string('supervisor_passport')->nullable();
            $table->string('supervisor_photo')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fuel_stations');
    }
};
