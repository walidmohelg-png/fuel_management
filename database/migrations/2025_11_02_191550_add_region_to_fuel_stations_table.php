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
        Schema::table('fuel_stations', function (Blueprint $table) {
            // إضافة عمود 'region' من نوع string ويمكن أن يكون فارغاً
            // وضعه بعد عمود 'city' ليكون التسلسل منطقياً
            if (!Schema::hasColumn('fuel_stations', 'region')) { // هذا الشرط يمنع تكرار إضافة العمود لو كان موجوداً
                $table->string('region')->nullable()->after('city');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fuel_stations', function (Blueprint $table) {
            // حذف عمود 'region' عند التراجع عن الهجرة
            if (Schema::hasColumn('fuel_stations', 'region')) { // هذا الشرط يمنع الخطأ لو كان العمود غير موجود
                $table->dropColumn('region');
            }
        });
    }
};