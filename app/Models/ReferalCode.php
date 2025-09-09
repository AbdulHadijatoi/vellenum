<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ReferalCode extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public static function generateCode($length = 8): string
    {
        do {
            // Example: 8-char alphanumeric code (e.g., A1B2C3D4)
            $code = strtoupper(Str::random($length));
        } while (self::where('code', $code)->exists());

        return $code;
    }
}
