<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function seller_menus()
    {
        return $this->hasMany(SellerMenu::class, 'menu_category_id');
    }

    public function categoryImage()
    {
        return $this->belongsTo(File::class, 'image');
    }
}
