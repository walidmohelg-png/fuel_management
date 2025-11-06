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
        Schema::table('company_details', function (Blueprint $table) {
            if (!Schema::hasColumn('company_details', 'authorized_person_national_id')) {
                $table->string('authorized_person_national_id')->nullable()->after('authorized_person_email');
            }
            if (!Schema::hasColumn('company_details', 'authorized_person_passport_no')) {
                $table->string('authorized_person_passport_no')->nullable()->after('authorized_person_national_id');
            }
            if (!Schema::hasColumn('company_details', 'representative_national_id')) {
                $table->string('representative_national_id')->nullable()->after('representative_email');
            }
            if (!Schema::hasColumn('company_details', 'representative_passport_no')) {
                $table->string('representative_passport_no')->nullable()->after('representative_national_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_details', function (Blueprint $table) {
            if (Schema::hasColumn('company_details', 'authorized_person_national_id')) {
                $table->dropColumn('authorized_person_national_id');
            }
            if (Schema::hasColumn('company_details', 'authorized_person_passport_no')) {
                $table->dropColumn('authorized_person_passport_no');
            }
            if (Schema::hasColumn('company_details', 'representative_national_id')) {
                $table->dropColumn('representative_national_id');
            }
            if (Schema::hasColumn('company_details', 'representative_passport_no')) {
                $table->dropColumn('representative_passport_no');
            }
        });
    }
};