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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('original_name');
            $table->string('filename'); // Generated unique filename
            $table->string('path'); // Storage path
            $table->string('mime_type');
            $table->string('extension');
            $table->bigInteger('size'); // File size in bytes
            $table->string('disk')->default('public'); // Storage disk
            $table->string('category')->nullable(); // e.g., 'profile_image', 'product_image', 'document'
            $table->text('description')->nullable();
            $table->json('metadata')->nullable(); // Additional file metadata
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->boolean('is_public')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};