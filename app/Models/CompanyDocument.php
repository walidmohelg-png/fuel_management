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
        'document_file',
        'expiry_date',
        'document_status',
        'notes',
        // 'document_number', // ❌ تم إزالته من fillable
    ];

    public function company()
    {
        return $this->belongsTo(BeneficiaryCompany::class, 'company_id');
    }
}