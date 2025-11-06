<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'manager_name', // ✅ تم التعديل ليتوافق مع migration 'manager_name'
        'email', // ✅ أضفته ليتوافق مع migration
        'phone',
        'delegate_name', // ✅ أضفته ليتوافق مع migration
        'delegate_phone', // ✅ أضفته ليتوافق مع migration
        'region',
        'city',
        'address',
        'latitude', // ✅ أضفته ليتوافق مع migration
        'longitude', // ✅ أضفته ليتوافق مع migration
    ];

    /**
     * العلاقة مع محطات الوقود
     * كل شركة توزيع تمتلك عدة محطات وقود
     */
    public function fuelStations()
    {
        return $this->hasMany(FuelStation::class);
    }
}