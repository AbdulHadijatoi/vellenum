<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InsuranceOffering extends Model
{
    protected $guarded = [
        // 'name',
        // 'type',
        // 'coverage_options',
        // 'rate_basic',
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
}
