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
            // تغيير اسم العمود 'authorized_person_photo' إلى 'authorized_person_photo_path'
            $table->renameColumn('authorized_person_photo', 'authorized_person_photo_path');
            // تغيير اسم العمود 'representative_photo' إلى 'representative_photo_path'
            $table->renameColumn('representative_photo', 'representative_photo_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_details', function (Blueprint $table) {
            // عكس عملية إعادة التسمية عند التراجع عن الهجرة
            $table->renameColumn('authorized_person_photo_path', 'authorized_person_photo');
            $table->renameColumn('representative_photo_path', 'representative_photo');
        });
    }
};