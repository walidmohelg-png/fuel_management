<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyDetails extends Model
{
    use HasFactory;

     protected $fillable = [
        'company_id',
        'fuel_type',
        'monthly_allowance',
        'supply_warehouse',
        'effective_date',
        'authorized_person_name',
        'authorized_person_phone',
        'authorized_person_email',
        'authorized_person_photo_path',
        'representative_name',
        'representative_phone',
        'representative_email',
        'representative_photo_path',
        'notes',
    ];
    
    // العلاقة: بيانات التفاصيل تنتمي لشركة مستفيدة واحدة
    public function company()
    {
        return $this->belongsTo(BeneficiaryCompany::class, 'company_id');
    }
}