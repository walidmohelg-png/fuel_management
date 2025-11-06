<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('beneficiary_companies')->onDelete('cascade');
            $table->string('document_type')->nullable(); // نوع المستند
            $table->string('document_status')->default('غير محدد'); // حالة المستند
            $table->date('expiry_date')->nullable(); // تاريخ الانتهاء
            $table->string('document_file')->nullable(); // مسار الملف
            $table->text('notes')->nullable(); // الملاحظات
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_documents');
    }
};
