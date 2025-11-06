<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeneficiaryCompany extends Model
{
    use HasFactory;

    protected $fillable = [
        // 🧩 الخطوة الأولى
        'distributor_id',
        'name',
        'activity_type',
        'fuel_code',
        'current_status',
        'region',
        'city',
        'address',
        'latitude',
        'longitude',
        'email',
        'registration_number',

        // 🧩 الخطوة الثانية
        'fuel_type',
        'monthly_allowance',
        'supply_warehouse',
        'authorized_person_name',
        'authorized_person_phone',
        'authorized_person_email',
        'authorized_person_national_id',
        'authorized_person_passport_no',
        'authorized_person_photo_path',
        'representative_name',
        'representative_phone',
        'representative_email',
        'representative_national_id',
        'representative_passport_no',
        'representative_photo_path',
        'effective_date',
        'notes',

        // 🧩 بيانات إضافية
        'user_id',
    ];

    /**
     * العلاقة مع الموزع (Distributor)
     */
    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }

    /**
     * العلاقة مع تفاصيل الشركة (CompanyDetail)
     */
   public function companyDetail()
{
    return $this->hasOne(CompanyDetail::class, 'company_id'); // تأكد أن 'company_id' هو المفتاح الخارجي الصحيح
}

    /**
     * العلاقة مع المستندات (CompanyDocument)
     */
    public function documents()
    {
        return $this->hasMany(CompanyDocument::class, 'company_id');
    }
}
