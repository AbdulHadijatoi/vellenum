<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerSpecialization extends Model
{
    protected $guarded = [];

    protected $table = 'seller_specializations';
    public $timestamps = false;

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }
}
