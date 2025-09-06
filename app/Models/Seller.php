<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'seller_category_id',
        'operating_hours',
        'menu_items',
        'service_packages',
        'insurance_offerings',
        'books_details',
        'property_details',
        'vehicle_information',
        'delivery_partner_name',
        'delivery_partner_phone',
        'delivery_partner_ssn',
        'license_number',
        'proof_of_business_registration_file_id',
        'food_safety_certifications_file_id',
        'government_issued_id_file_id',
        'business_registration_certificate_file_id',
        'professional_license_file_id',
        'insurance_license_number',
        'license_expiry_date',
        'bar_association_number',
        'years_of_experience',
        'legal_certifications_file_id',
        'specialization',
        'pricing_model',
        'price',
        'service_description',
        'cuisine_type',
        'service_name',
        'service_category',
        'insurance_offering_name',
        'insurance_type',
        'coverage_options',
        'rate_basic',
        'property_title',
        'property_type',
        'property_features',
        'property_listing_type',
        'property_price',
        'property_address',
        'property_city',
        'property_zipcode',
        'property_size',
        'bedrooms',
        'other_features',
        'number_of_vehicles',
        'vehicle_name',
        'vehicle_photos',
        'vehicle_make',
        'vehicle_model',
        'vehicle_year',
        'vehicle_mileage',
        'vehicle_license_number',
        'vehicle_registration_date',
        'vehicle_registration_document_file_id',
        'vehicle_insurance_document_file_id',
        'rate_start_time',
        'rate_amount',
        'rate_type',
        'book_title',
        'book_author',
        'book_price',
        'book_genre',
        'book_cover_file_id',
        'book_format',
        'book_file_id',
        'what_you_sell',
        'product_photo_file_id',
        'product_price',
        'product_quantity',
        'is_approved',
        'rejection_reason',
        'approved_at',
    ];

    protected $casts = [
        'operating_hours' => 'array',
        'menu_items' => 'array',
        'service_packages' => 'array',
        'insurance_offerings' => 'array',
        'books_details' => 'array',
        'property_details' => 'array',
        'vehicle_information' => 'array',
        'specialization' => 'array',
        'coverage_options' => 'array',
        'property_features' => 'array',
        'what_you_sell' => 'array',
        'is_approved' => 'boolean',
        'license_expiry_date' => 'date',
        'vehicle_registration_date' => 'date',
        'approved_at' => 'datetime',
        'price' => 'decimal:2',
        'rate_basic' => 'decimal:2',
        'property_price' => 'decimal:2',
        'rate_amount' => 'decimal:2',
        'book_price' => 'decimal:2',
        'product_price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sellerCategory()
    {
        return $this->belongsTo(SellerCategory::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function proofOfBusinessRegistrationFile()
    {
        return $this->belongsTo(File::class, 'proof_of_business_registration_file_id');
    }

    public function foodSafetyCertificationsFile()
    {
        return $this->belongsTo(File::class, 'food_safety_certifications_file_id');
    }

    public function governmentIssuedIdFile()
    {
        return $this->belongsTo(File::class, 'government_issued_id_file_id');
    }

    public function businessRegistrationCertificateFile()
    {
        return $this->belongsTo(File::class, 'business_registration_certificate_file_id');
    }

    public function professionalLicenseFile()
    {
        return $this->belongsTo(File::class, 'professional_license_file_id');
    }

    public function legalCertificationsFile()
    {
        return $this->belongsTo(File::class, 'legal_certifications_file_id');
    }

    public function vehicleRegistrationDocumentFile()
    {
        return $this->belongsTo(File::class, 'vehicle_registration_document_file_id');
    }

    public function vehicleInsuranceDocumentFile()
    {
        return $this->belongsTo(File::class, 'vehicle_insurance_document_file_id');
    }

    public function bookCoverFile()
    {
        return $this->belongsTo(File::class, 'book_cover_file_id');
    }

    public function bookFile()
    {
        return $this->belongsTo(File::class, 'book_file_id');
    }

    public function productPhotoFile()
    {
        return $this->belongsTo(File::class, 'product_photo_file_id');
    }
}