<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MenuImage extends Model
{
     protected $fillable = [
        'seller_menu_id',
        'file_id',
        'sort_order',
        'is_primary',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function sellerMenu()
    {
        return $this->belongsTo(SellerMenu::class);
    }

    public function file()
    {
        return $this->belongsTo(File::class);
    }

    /**
     * Scope for primary images
     */
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    /**
     * Scope ordered by sort order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

     /**
     * Delete associated file from disk and database along with this record
     */
    public function deleteWithFile()
    {
        if ($this->file) {
            // Assuming your File model has a "path" column
            if (Storage::exists($this->file->path)) {
                Storage::delete($this->file->path);
            }

            // Delete file record
            $this->file->delete();
        }

        // Delete product image record itself
        return parent::delete();
    }
}
