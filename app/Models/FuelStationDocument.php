<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class FuelStationDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'station_id',
        'document_type',
        'document_file',
        'expiry_date',
        'document_status',
        'notes',
    ];

    /**
     * التحويل التلقائي للتواريخ
     */
    protected $casts = [
        'expiry_date' => 'date',
    ];

    /**
     * العلاقة مع محطة الوقود
     */
    public function station()
    {
        return $this->belongsTo(FuelStation::class, 'station_id');
    }

    /**
     * إرجاع رابط المستند الكامل عند الطلب
     */
    public function getDocumentUrlAttribute()
    {
        return $this->document_file
            ? Storage::url($this->document_file)
            : null;
    }
}
