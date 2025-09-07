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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('make');
            $table->string('model');
            $table->year('year');
            $table->integer('mileage')->nullable();
            $table->decimal('hourly_rate', 8, 2);
            $table->string('license_number')->nullable();
            $table->date('registration_date')->nullable();
            $table->foreignId('registration_document')->nullable()->constrained('files')->onDelete('set null');
            $table->foreignId('insurance_document')->nullable()->constrained('files')->onDelete('set null');
            $table->foreignId('seller_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
