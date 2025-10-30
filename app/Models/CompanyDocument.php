<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'document_type',
        'file_path',
        'status',
        'expiry_date',
    ];
    
    // العلاقة: الوثيقة تنتمي لشركة مستفيدة واحدة
    public function company()
    {
        return $this->belongsTo(BeneficiaryCompany::class, 'company_id');
    }
}