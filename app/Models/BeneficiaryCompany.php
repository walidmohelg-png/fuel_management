<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeneficiaryCompany extends Model
{
    use HasFactory;

        protected $fillable = [
        'distributor_id', 
        'name',
        'activity_type',
        'fuel_code',
        'current_status',
        'address',
        'nearest_landmark',
        'latitude', 
        'longitude', 
    ];


    // العلاقة: الشركة المستفيدة تنتمي لموزع واحد
    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }

    // العلاقة: الشركة الواحدة لديها تفاصيل واحدة (المخصصات، المفوض، المندوب)
    public function details()
    {
        return $this->hasOne(CompanyDetails::class, 'company_id');
    }

    // العلاقة: الشركة الواحدة لديها عدة وثائق
    public function documents()
    {
        return $this->hasMany(CompanyDocument::class, 'company_id');
    }
}