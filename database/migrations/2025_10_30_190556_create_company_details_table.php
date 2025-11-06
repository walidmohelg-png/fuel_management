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
            $table->foreignId('company_id')->constrained('beneficiary_companies')->onDelete('cascade');

            // نوع الوقود والمخصص الشهري
            $table->string('fuel_type')->nullable();
            $table->integer('monthly_allowance')->nullable();
            $table->string('supply_warehouse')->nullable();

            // بيانات المفوض
            $table->string('authorized_person_name')->nullable();
            $table->string('authorized_person_phone')->nullable();
            $table->string('authorized_person_email')->nullable();

            // بيانات المندوب
            $table->string('representative_name')->nullable();
            $table->string('representative_phone')->nullable();
            $table->string('representative_email')->nullable();

            // بيانات المفوض الإضافية
            $table->string('authorized_person_nid')->nullable();
            $table->string('authorized_person_passport')->nullable();
            $table->string('authorized_person_photo')->nullable();

            // بيانات المندوب الإضافية
            $table->string('representative_nid')->nullable();
            $table->string('representative_passport')->nullable();
            $table->string('representative_photo')->nullable();

            // ملاحظات عامة
            $table->date('effective_date')->nullable();
            $table->text('notes')->nullable();

            // الموقع الجغرافي (اختياري)
            $table->string('region')->nullable();
            $table->string('city')->nullable();

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
