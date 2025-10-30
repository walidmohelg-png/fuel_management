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
        Schema::create('beneficiary_companies', function (Blueprint $table) {
            $table->id();
            
            // الربط بشركة التوزيع (Foreign Key) - هذا هو العمود المسبب للخطأ
            $table->foreignId('distributor_id')
                  ->constrained('distributors') 
                  ->onDelete('restrict');
                  
            // البيانات الأساسية
            $table->string('name');
            $table->string('activity_type')->nullable(); 
            $table->string('fuel_code')->unique()->nullable(); 
            
            // الموقع
            $table->text('address')->nullable();
            $table->string('nearest_landmark')->nullable();
            $table->decimal('latitude', 10, 8)->nullable(); // الإحداثيات
            $table->decimal('longitude', 11, 8)->nullable(); // الإحداثيات
            
            // نظام الحالة
            $table->enum('current_status', ['active', 'suspended', 'pending', 'expired'])
                  ->default('pending');
            
            // تواريخ التتبع
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiary_companies');
    }
};
