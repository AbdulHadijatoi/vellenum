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
        Schema::table('sellers', function (Blueprint $table) {
            // Drop existing file path columns
            $table->dropColumn([
                'proof_of_business_registration',
                'food_safety_certifications',
                'government_issued_id',
                'business_registration_certificate',
                'professional_license',
                'legal_certifications',
                'vehicle_registration_document',
                'vehicle_insurance_document',
                'book_cover',
                'book_file',
                'product_photo'
            ]);

            // Add file reference columns
            $table->foreignId('proof_of_business_registration_file_id')->nullable()->constrained('files')->onDelete('set null');
            $table->foreignId('food_safety_certifications_file_id')->nullable()->constrained('files')->onDelete('set null');
            $table->foreignId('government_issued_id_file_id')->nullable()->constrained('files')->onDelete('set null');
            $table->foreignId('business_registration_certificate_file_id')->nullable()->constrained('files')->onDelete('set null');
            $table->foreignId('professional_license_file_id')->nullable()->constrained('files')->onDelete('set null');
            $table->foreignId('legal_certifications_file_id')->nullable()->constrained('files')->onDelete('set null');
            $table->foreignId('vehicle_registration_document_file_id')->nullable()->constrained('files')->onDelete('set null');
            $table->foreignId('vehicle_insurance_document_file_id')->nullable()->constrained('files')->onDelete('set null');
            $table->foreignId('book_cover_file_id')->nullable()->constrained('files')->onDelete('set null');
            $table->foreignId('book_file_id')->nullable()->constrained('files')->onDelete('set null');
            $table->foreignId('product_photo_file_id')->nullable()->constrained('files')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            // Drop file reference columns
            $table->dropForeign(['proof_of_business_registration_file_id']);
            $table->dropForeign(['food_safety_certifications_file_id']);
            $table->dropForeign(['government_issued_id_file_id']);
            $table->dropForeign(['business_registration_certificate_file_id']);
            $table->dropForeign(['professional_license_file_id']);
            $table->dropForeign(['legal_certifications_file_id']);
            $table->dropForeign(['vehicle_registration_document_file_id']);
            $table->dropForeign(['vehicle_insurance_document_file_id']);
            $table->dropForeign(['book_cover_file_id']);
            $table->dropForeign(['book_file_id']);
            $table->dropForeign(['product_photo_file_id']);

            $table->dropColumn([
                'proof_of_business_registration_file_id',
                'food_safety_certifications_file_id',
                'government_issued_id_file_id',
                'business_registration_certificate_file_id',
                'professional_license_file_id',
                'legal_certifications_file_id',
                'vehicle_registration_document_file_id',
                'vehicle_insurance_document_file_id',
                'book_cover_file_id',
                'book_file_id',
                'product_photo_file_id'
            ]);

            // Restore original file path columns
            $table->string('proof_of_business_registration')->nullable();
            $table->string('food_safety_certifications')->nullable();
            $table->string('government_issued_id')->nullable();
            $table->string('business_registration_certificate')->nullable();
            $table->string('professional_license')->nullable();
            $table->string('legal_certifications')->nullable();
            $table->string('vehicle_registration_document')->nullable();
            $table->string('vehicle_insurance_document')->nullable();
            $table->string('book_cover')->nullable();
            $table->string('book_file')->nullable();
            $table->string('product_photo')->nullable();
        });
    }
};