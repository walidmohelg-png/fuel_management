<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // الخطوة 1: أنشئ عمود مؤقت
        Schema::table('fuel_station_details', function (Blueprint $table) {
            $table->string('supply_days_text')->nullable();
        });

        // الخطوة 2: انسخ القيم القديمة (الأرقام) إلى النصوص (بشكل مؤقت)
        DB::table('fuel_station_details')->update([
            'supply_days_text' => DB::raw('supply_days')
        ]);

        // الخطوة 3: احذف العمود القديم
        Schema::table('fuel_station_details', function (Blueprint $table) {
            $table->dropColumn('supply_days');
        });

        // الخطوة 4: أعد تسميه العمود الجديد إلى الاسم الأصلي
        Schema::table('fuel_station_details', function (Blueprint $table) {
            $table->renameColumn('supply_days_text', 'supply_days');
        });
    }

    public function down(): void
    {
        Schema::table('fuel_station_details', function (Blueprint $table) {
            $table->integer('supply_days')->nullable()->change();
        });
    }
};
