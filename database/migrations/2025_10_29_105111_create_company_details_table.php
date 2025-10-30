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
        Schema::create('company_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')
                  ->constrained('beneficiary_companies')
                  ->onDelete('cascade'); 
            
            // بيانات المخصصات
            $table->string('fuel_type')->nullable(); 
            $table->unsignedInteger('monthly_allowance')->default(0); 
            $table->string('supply_warehouse')->nullable(); 
            $table->date('effective_date')->nullable(); 

            // بيانات المفوض والمندوب
            $table->string('authorized_person_name')->nullable();
            $table->string('authorized_person_phone')->nullable();
            $table->string('authorized_person_email')->nullable();
            $table->string('authorized_person_photo_path')->nullable(); 

            $table->string('representative_name')->nullable();
            $table->string('representative_phone')->nullable();
            $table->string('representative_email')->nullable();
            $table->string('representative_photo_path')->nullable(); 
            
            $table->text('notes')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_details');
    }
};
