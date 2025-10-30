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
        Schema::create('company_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')
                  ->constrained('beneficiary_companies')
                  ->onDelete('cascade'); 
            
            // بيانات الوثيقة
            $table->enum('document_type', ['contract', 'safety', 'tax', 'release', 'license']); 
            $table->string('file_path')->nullable(); 
            
            // حالة الوثيقة (ساري، منتهي، لا يوجد، محضر اتفاق، الخ...)
            $table->string('status')->default('لا يوجد'); 
            $table->date('expiry_date')->nullable(); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_documents');
    }
};
