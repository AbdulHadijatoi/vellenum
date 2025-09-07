<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        // 'seller_id',
        // 'product_category_id',
        // 'title',
        // 'description',
        // 'price',
        // 'quantity',
        // 'image_file_id',
        // 'type',
        // 'attributes',
        // 'is_active',
        // 'is_featured',
    ];

    // protected $casts = [
    //     'attributes' => 'array',
    //     'is_active' => 'boolean',
    //     'is_featured' => 'boolean',
    //     'price' => 'decimal:2',
    // ];

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function imageFile()
    {
        return $this->belongsTo(File::class, 'image_file_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->ordered();
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }
}