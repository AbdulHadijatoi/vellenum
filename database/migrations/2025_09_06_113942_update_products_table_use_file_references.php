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
        Schema::table('products', function (Blueprint $table) {
            // Drop existing file path columns
            $table->dropColumn(['image', 'images']);

            // Add file reference columns
            $table->foreignId('image_file_id')->nullable()->constrained('files')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop file reference columns
            $table->dropForeign(['image_file_id']);
            $table->dropColumn(['image_file_id']);

            // Restore original file path columns
            $table->string('image')->nullable();
            $table->json('images')->nullable();
        });
    }
};