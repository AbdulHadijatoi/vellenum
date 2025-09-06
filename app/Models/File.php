<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'original_name',
        'filename',
        'path',
        'mime_type',
        'extension',
        'size',
        'disk',
        'category',
        'description',
        'metadata',
        'uploaded_by',
        'is_public',
        'is_active',
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_public' => 'boolean',
        'is_active' => 'boolean',
        'size' => 'integer',
    ];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function sellers()
    {
        return $this->hasMany(Seller::class, 'proof_of_business_registration_file_id')
            ->orWhere('food_safety_certifications_file_id', $this->id)
            ->orWhere('government_issued_id_file_id', $this->id)
            ->orWhere('business_registration_certificate_file_id', $this->id)
            ->orWhere('professional_license_file_id', $this->id)
            ->orWhere('legal_certifications_file_id', $this->id)
            ->orWhere('vehicle_registration_document_file_id', $this->id)
            ->orWhere('vehicle_insurance_document_file_id', $this->id)
            ->orWhere('book_cover_file_id', $this->id)
            ->orWhere('book_file_id', $this->id)
            ->orWhere('product_photo_file_id', $this->id);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'image_file_id');
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Get the full URL for the file
     */
    public function getUrlAttribute()
    {
        return Storage::disk($this->disk)->url($this->path);
    }

    /**
     * Get the full path for the file
     */
    public function getFullPathAttribute()
    {
        return Storage::disk($this->disk)->path($this->path);
    }

    /**
     * Check if file exists on disk
     */
    public function exists()
    {
        return Storage::disk($this->disk)->exists($this->path);
    }

    /**
     * Delete the file from disk
     */
    public function deleteFromDisk()
    {
        if ($this->exists()) {
            Storage::disk($this->disk)->delete($this->path);
        }
    }

    /**
     * Get file size in human readable format
     */
    public function getHumanSizeAttribute()
    {
        $bytes = $this->size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Scope for public files
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope for active files
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope by category
     */
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}