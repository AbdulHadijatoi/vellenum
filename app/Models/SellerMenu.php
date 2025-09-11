<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerMenu extends Model
{
    protected $guarded = [];

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function images()
    {
        return $this->hasMany(MenuImage::class)->ordered();
    }

    public function category(){
        return $this->belongsTo(MenuCategory::class,'menu_category_id');
    }

    public function primaryImage()
    {
        return $this->hasOne(MenuImage::class)->where('is_primary', true);
    }
}
