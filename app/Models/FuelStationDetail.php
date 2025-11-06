<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuelStationDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'station_id',
        'fuel_type',
        'fuel_quantity',
        'tank_count',
        'meter_before',
        'meter_after',
        'supply_days',
        'fire_equipment',
        'signs',
        'lighting',
        'flooring',
        'electrical_materials',
        'cameras',
        'cleanliness',
        'station_contract',
        'station_contract_status',
        'license',
        'license_status',
        'workers_health_status',
        'last_calibration',
        'last_inspection',
        'number_of_workers', // 👈 تم إضافة هذا السطر
    ];

    /**
     * التحويل التلقائي للقيم المنطقية
     */
    protected $casts = [
        'fire_equipment' => 'boolean',
        'signs' => 'boolean',
        'lighting' => 'boolean',
        'flooring' => 'boolean',
        'electrical_materials' => 'boolean',
        'cameras' => 'boolean',
        'cleanliness' => 'boolean',
        'last_calibration' => 'date',
        'last_inspection' => 'date',
    ];

    /**
     * العلاقة مع محطة الوقود
     */
    public function station()
    {
        return $this->belongsTo(FuelStation::class, 'station_id');
    }
}