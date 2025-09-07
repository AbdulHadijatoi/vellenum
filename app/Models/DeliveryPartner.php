<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryPartner extends Model
{
    protected $guarded = [
        'name',
        'phone',
        'ssn',
    ];

    public $timestamps = false;

    public function sellers()
    {
        return $this->hasMany(Seller::class);
    }
}
