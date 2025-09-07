<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyImage extends Model
{
    protected $guarded = [];
    
    protected $with = [
        'image'
    ];

    public $timestamps = false;

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function image()
    {
        return $this->belongsTo(File::class,'file_id');
    }

    // add image attribute from file


}
