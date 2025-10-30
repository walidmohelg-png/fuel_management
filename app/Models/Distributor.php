<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    use HasFactory;
    
    // ==========================================================
    // **الحل هنا:** يجب إضافة جميع أسماء الأعمدة إلى هذه القائمة
    // ==========================================================
   protected $fillable = [
        'name',
        'manager_name',
        'phone_number',
        'email',
        'address',
        'latitude',
        'longitude',
        'is_active',
    ];

    // العلاقة: الموزع الواحد لديه عدة شركات مستفيدة
    public function beneficiaryCompanies()
    {
        return $this->hasMany(BeneficiaryCompany::class);
    }
}