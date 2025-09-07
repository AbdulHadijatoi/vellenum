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
        'status',
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_public' => 'boolean',
        'status' => 'boolean',
        'size' => 'integer',
    ];

    protected $appends = ['image_url'];
    protected $visible = ['image_url'];
    
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function sellers()
    {
        return $this->hasMany(Seller::class, 'government_issued_id')
            ->orWhere('business_registration_certificate', $this->id)
            ->orWhere('food_safety_certifications', $this->id)
            ->orWhere('professional_license', $this->id)
            ->orWhere('legal_certifications', $this->id);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'image_file_id');
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function getImageUrlAttribute()
    {
        // If you want to check for public visibility
        if ($this->is_public) {
            return Storage::disk($this->disk)->url($this->path);
        }

        // Optionally return null or signed URL if private
        return null;
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
        return $query->where('status', true);
    }

    /**
     * Scope by category
     */
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}