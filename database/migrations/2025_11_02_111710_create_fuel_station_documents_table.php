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
        Schema::create('fuel_station_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('station_id')->constrained('fuel_stations')->onDelete('cascade');
            $table->string('document_type')->nullable();
            $table->enum('document_status', ['ساري', 'منتهي', 'غير مستوفي', 'لا يوجد'])->default('لا يوجد');
            $table->date('expiry_date')->nullable();
            $table->string('document_file')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuel_station_documents');
    }
};
