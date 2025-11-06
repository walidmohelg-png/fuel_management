<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'fuel_type',
        'monthly_allowance',
        'supply_warehouse',
        'authorized_person_name',
        'authorized_person_phone',
        'authorized_person_email',
        'authorized_person_photo_path', // ✅ تأكد من الاسم المطابق للجدول
        'authorized_person_national_id', // ✅ تأكد من الاسم المطابق للجدول
        'authorized_person_passport_no', // ✅ تأكد من الاسم المطابق للجدول
        'representative_name',
        'representative_phone',
        'representative_email',
        'representative_photo_path',    // ✅ تأكد من الاسم المطابق للجدول
        'representative_national_id',   // ✅ تأكد من الاسم المطابق للجدول
        'representative_passport_no',   // ✅ تأكد من الاسم المطابق للجدول
        'notes',
        'effective_date',
        'region', // ✅ تأكد من وجوده
        'city',   // ✅ تأكد من وجوده
    ];

    public function company()
    {
        return $this->belongsTo(BeneficiaryCompany::class, 'company_id');
    }
}