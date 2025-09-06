<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OTPCode extends Model
{
    use HasFactory;

    protected $table = 'otp_codes';
    protected $guarded = [];
    public $timestamps = false;

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    // create function to check otp is used or expired
    public function isValid()
    {
        return !$this->is_used && $this->expires_at->isFuture();
    }

    // create otp function
    public static function generateOtp($email = null, $phone = null)
    {
        $otp = rand(100000, 999999);
        $expiresAt = now()->addMinutes(10); // OTP valid for 10 minutes

        return self::create([
            'email' => $email,
            'phone' => $phone,
            'otp_code' => $otp,
            'expires_at' => $expiresAt,
            'is_used' => false,
        ]);
    }
}