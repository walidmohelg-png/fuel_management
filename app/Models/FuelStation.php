<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FuelStationDocument;


class FuelStation extends Model
{
    use HasFactory;

    protected $fillable = [
        'distributor_id',
        'station_name',
        'station_number',
        'city',
        'region',
        'address',
        'latitude',
        'longitude',
        'owner_name',
        'owner_phone',
        'owner_nid',
        'owner_passport',
        'owner_photo',
        'supervisor_name',
        'supervisor_phone',
        'supervisor_nid',
        'supervisor_passport',
        'supervisor_photo',
    ];

    /**
     * شركة التوزيع
     */
    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }

    /**
     * تفاصيل المحطة (جدول fuel_station_details)
     */
    public function details()
    {
        return $this->hasOne(FuelStationDetail::class, 'station_id');
    }

    /**
     * مستندات المحطة (جدول fuel_station_documents)
     */
    public function documents()
    {
        return $this->hasMany(FuelStationDocument::class, 'station_id');
    }
}
