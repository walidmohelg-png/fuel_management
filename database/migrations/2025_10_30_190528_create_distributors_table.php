<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('distributors', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم شركة التوزيع
            $table->string('manager_name')->nullable(); // اسم المدير
            $table->string('email')->nullable(); // البريد الإلكتروني
            $table->string('phone')->nullable(); // رقم الهاتف

            $table->string('delegate_name')->nullable(); // اسم المفوض
            $table->string('delegate_phone')->nullable(); // رقم هاتف المفوض

            $table->string('region')->nullable(); // المنطقة
            $table->string('city')->nullable();   // المدينة

            $table->text('address')->nullable(); // العنوان التفصيلي
            $table->string('latitude')->nullable(); // خط العرض
            $table->string('longitude')->nullable(); // خط الطول
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('distributors');
    }
};
