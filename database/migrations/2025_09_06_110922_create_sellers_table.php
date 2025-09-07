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
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('seller_category_id')->constrained()->onDelete('cascade');
            
            $table->string('operating_hours')->nullable();
            $table->string('license_number')->nullable();
            $table->integer('years_of_experience')->nullable();
            $table->string('bar_association_number')->nullable();
            $table->string('license_expiry_date')->nullable();
            $table->foreignId('government_issued_id')
                ->nullable()
                ->constrained('files', 'id')
                ->onDelete('set null');

            $table->foreignId('business_registration_certificate')
                ->nullable()
                ->constrained('files', 'id')
                ->onDelete('set null');

            $table->foreignId('food_safety_certifications')
                ->nullable()
                ->constrained('files', 'id')
                ->onDelete('set null');

            $table->foreignId('professional_license')
                ->nullable()
                ->constrained('files', 'id')
                ->onDelete('set null');

            $table->foreignId('legal_certifications')
                ->nullable()
                ->constrained('files', 'id')
                ->onDelete('set null');


            // Status and verification
            $table->boolean('status')->default(true);
            $table->text('rejection_reason')->nullable();
            $table->timestamp('approved_at')->nullable()->default(NOW());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sellers');
    }
};