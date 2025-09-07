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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('property_type');
            $table->json('features')->nullable(); // Store as JSON array
            $table->string('listing_type'); // Sale or Rent
            $table->string('rental_type'); // Annual or Monthly
            $table->decimal('price', 10, 2);
            $table->string('address');
            $table->string('city');
            $table->string('zipcode');
            $table->string('size')->nullable();
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->text('other_features')->nullable();
            $table->foreignId('seller_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
