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
        Schema::create('distributors', function (Blueprint $table) {
            $table->id();
            
            // البيانات الأساسية (التي كانت مفقودة وتسببت في الخطأ)
            $table->string('name')->unique(); 
            $table->string('manager_name')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            
            // الموقع الجغرافي
            $table->text('address')->nullable();
            $table->decimal('latitude', 10, 8)->nullable(); 
            $table->decimal('longitude', 11, 8)->nullable(); 
            
            // حالة الشركة
            $table->boolean('is_active')->default(true); 
            
            // تواريخ التتبع
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distributors');
    }
};
