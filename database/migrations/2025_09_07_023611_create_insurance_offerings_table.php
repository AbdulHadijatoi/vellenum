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
        Schema::create('insurance_offerings', function (Blueprint $table) {
            $table->id();
            $table->string('insurance_name');
            $table->string('insurance_type');
            $table->decimal('rate_basic', 10, 2)->nullable();
            $table->decimal('rate_standard', 10, 2)->nullable();
            $table->decimal('rate_premium', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->foreignId('seller_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurance_offerings');
    }
};
