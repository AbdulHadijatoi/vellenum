<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $guarded = [];
    
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function coverFile()
    {
        return $this->belongsTo(File::class, 'cover_file_id');
    }
    
    public function bookFile()
    {
        return $this->belongsTo(File::class, 'book_file_id');
    }
}
