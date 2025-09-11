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
        Schema::create('seller_menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->unsignedBigInteger('menu_category_id')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('duration')->nullable(); // e.g., "30 mins", "1 hour"
            $table->string('discount')->nullable(); // e.g., "10%",
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_menus');
    }
};
