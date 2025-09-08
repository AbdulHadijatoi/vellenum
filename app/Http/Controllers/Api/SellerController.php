<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\Seller;
use App\Models\SellerCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SellerController extends Controller
{
    public function getSellerCategories()
    {
        $categories = SellerCategory::where('status', true)->get();
        
        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    public function getSellers(){
        $sellers = Seller::with([
            'user',
            'sellerCategory',
            'governmentIssuedId',
            'businessRegistrationCertificate',
            'foodSafetyCertifications',
            'professionalLicense',
            'legalCertifications',
            'vehicles',
            'books'
        ])->get();

        return response()->json([
            'success' => true,
            'data' => $sellers
        ]);
    }

    public function getSellerProfile(Request $request)
    {
        $user = $request->user();
        $seller = $user->seller;

        if (!$seller) {
            return response()->json([
                'success' => false,
                'message' => 'Seller profile not found'
            ], 404);
        }

        $seller->load('sellerCategory');

        return response()->json([
            'success' => true,
            'data' => [
                'user' => $user,
                'seller' => $seller
            ]
        ]);
    }

    public function updateSellerProfile(Request $request)
    {
        $user = $request->user();
        $seller = $user->seller;

        if (!$seller) {
            return response()->json([
                'success' => false,
                'message' => 'Seller profile not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'phone' => 'sometimes|string|max:20',
            'business_name' => 'sometimes|string|max:255',
            'business_email' => 'sometimes|string|email|max:255',
            'business_phone' => 'sometimes|string|max:20',
            'business_address' => 'sometimes|string',
            'country' => 'sometimes|string|max:100',
            'state' => 'sometimes|string|max:100',
            'city' => 'sometimes|string|max:100',
            'zip_code' => 'sometimes|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        // Update user fields
        $user->update($request->only([
            'name', 'phone', 'business_name', 'business_email', 'business_phone',
            'business_address', 'country', 'state', 'city', 'zip_code'
        ]));

        // Update seller-specific fields
        $sellerData = $request->only([
            'operating_hours', 'menu_items', 'service_packages', 'insurance_offerings',
            'books_details', 'property_details', 'vehicle_information',
            'delivery_partner_name', 'delivery_partner_phone', 'delivery_partner_ssn',
            'text_identification', 'proof_of_business_registration', 'food_safety_certifications',
            'government_issued_id', 'business_registration_certificate', 'professional_license',
            'insurance_license_number', 'license_expiry_date', 'bar_association_number',
            'years_of_experience', 'legal_certifications', 'specialization', 'pricing_model',
            'price', 'service_description', 'cuisine_type', 'service_name', 'service_category',
            'insurance_offering_name', 'insurance_type', 'coverage_options', 'rate_basic',
            'property_title', 'property_type', 'property_features', 'property_listing_type',
            'property_price', 'property_address', 'property_city', 'property_zipcode',
            'property_size', 'bedrooms', 'other_features', 'number_of_vehicles',
            'vehicle_name', 'vehicle_photos', 'vehicle_make', 'vehicle_model',
            'vehicle_year', 'vehicle_mileage', 'vehicle_license_number',
            'vehicle_registration_date', 'vehicle_registration_document',
            'vehicle_insurance_document', 'rate_start_time', 'rate_amount', 'rate_type',
            'book_title', 'book_author', 'book_price', 'book_genre', 'book_cover',
            'book_format', 'book_file', 'what_you_sell', 'product_photo',
            'product_price', 'product_quantity'
        ]);

        $seller->update($sellerData);

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'data' => [
                'user' => $user->fresh(),
                'seller' => $seller->fresh()
            ]
        ]);
    }

    
}