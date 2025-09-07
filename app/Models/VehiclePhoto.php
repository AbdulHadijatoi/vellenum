<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehiclePhoto extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
