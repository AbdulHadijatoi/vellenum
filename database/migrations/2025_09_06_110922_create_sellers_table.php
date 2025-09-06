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
            
            // Operating Hours
            $table->json('operating_hours')->nullable(); // Store as JSON for flexibility
            
            // Menu/Products/Services (JSON for flexibility)
            $table->json('menu_items')->nullable();
            $table->json('service_packages')->nullable();
            $table->json('insurance_offerings')->nullable();
            $table->json('books_details')->nullable();
            $table->json('property_details')->nullable();
            $table->json('vehicle_information')->nullable();
            
            // Delivery Partner Details
            $table->string('delivery_partner_name')->nullable();
            $table->string('delivery_partner_phone')->nullable();
            $table->string('delivery_partner_ssn')->nullable();
            
            // Documentation & Licensing
            $table->string('text_identification')->nullable();
            $table->string('proof_of_business_registration')->nullable();
            $table->string('food_safety_certifications')->nullable();
            $table->string('government_issued_id')->nullable();
            $table->string('business_registration_certificate')->nullable();
            $table->string('professional_license')->nullable();
            $table->string('insurance_license_number')->nullable();
            $table->date('license_expiry_date')->nullable();
            $table->string('bar_association_number')->nullable();
            $table->integer('years_of_experience')->nullable();
            $table->string('legal_certifications')->nullable();
            
            // Professional Details
            $table->json('specialization')->nullable(); // Store as JSON array
            $table->string('pricing_model')->nullable(); // Flat Fee, Hourly Rate
            $table->decimal('price', 10, 2)->nullable();
            $table->text('service_description')->nullable();
            
            // Cuisine/Service Types
            $table->string('cuisine_type')->nullable();
            $table->string('service_name')->nullable();
            $table->string('service_category')->nullable();
            $table->string('insurance_offering_name')->nullable();
            $table->string('insurance_type')->nullable();
            $table->json('coverage_options')->nullable(); // Store as JSON array
            $table->decimal('rate_basic', 10, 2)->nullable();
            
            // Property Details
            $table->string('property_title')->nullable();
            $table->string('property_type')->nullable();
            $table->json('property_features')->nullable(); // Store as JSON array
            $table->string('property_listing_type')->nullable(); // Sale, Rent
            $table->decimal('property_price', 12, 2)->nullable();
            $table->text('property_address')->nullable();
            $table->string('property_city')->nullable();
            $table->string('property_zipcode')->nullable();
            $table->string('property_size')->nullable();
            $table->integer('bedrooms')->nullable();
            $table->text('other_features')->nullable();
            
            // Vehicle Details
            $table->integer('number_of_vehicles')->nullable();
            $table->string('vehicle_name')->nullable();
            $table->string('vehicle_photos')->nullable();
            $table->string('vehicle_make')->nullable();
            $table->string('vehicle_model')->nullable();
            $table->year('vehicle_year')->nullable();
            $table->integer('vehicle_mileage')->nullable();
            $table->string('vehicle_license_number')->nullable();
            $table->date('vehicle_registration_date')->nullable();
            $table->string('vehicle_registration_document')->nullable();
            $table->string('vehicle_insurance_document')->nullable();
            $table->string('rate_start_time')->nullable();
            $table->decimal('rate_amount', 10, 2)->nullable();
            $table->string('rate_type')->nullable(); // Hourly, Daily, etc.
            
            // Book Details
            $table->string('book_title')->nullable();
            $table->string('book_author')->nullable();
            $table->decimal('book_price', 8, 2)->nullable();
            $table->string('book_genre')->nullable();
            $table->string('book_cover')->nullable();
            $table->string('book_format')->nullable();
            $table->string('book_file')->nullable();
            
            // Seafood Details
            $table->json('what_you_sell')->nullable(); // Store as JSON array
            $table->string('product_photo')->nullable();
            $table->decimal('product_price', 8, 2)->nullable();
            $table->integer('product_quantity')->nullable();
            
            // Status and verification
            $table->boolean('is_approved')->default(false);
            $table->text('rejection_reason')->nullable();
            $table->timestamp('approved_at')->nullable();
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