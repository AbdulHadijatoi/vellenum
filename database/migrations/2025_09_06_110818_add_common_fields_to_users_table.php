<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Common fields for all user types
            $table->string('phone')->nullable();
            $table->string('business_name')->nullable();
            $table->string('business_email')->nullable();
            $table->string('business_phone')->nullable();
            $table->text('business_address')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('otp')->nullable();
            $table->timestamp('otp_expires_at')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_active')->default(true);
            $table->string('profile_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'business_name',
                'business_email',
                'business_phone',
                'business_address',
                'country',
                'state',
                'city',
                'zip_code',
                'otp',
                'otp_expires_at',
                'is_verified',
                'is_active',
                'profile_image'
            ]);
        });
    }
};