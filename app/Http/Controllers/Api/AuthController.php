<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Seller;
use App\Models\SellerCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'business_name' => 'required|string|max:255',
            'business_email' => 'required|string|email|max:255',
            'business_phone' => 'required|string|max:20',
            'business_address' => 'required|string',
            'country' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'zip_code' => 'required|string|max:20',
            'seller_category_id' => 'required|exists:seller_categories,id',
            'role' => 'required|in:admin,seller,buyer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'business_name' => $request->business_name,
            'business_email' => $request->business_email,
            'business_phone' => $request->business_phone,
            'business_address' => $request->business_address,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'zip_code' => $request->zip_code,
        ]);

        // Assign role
        $user->assignRole($request->role);

        // If seller, create seller record
        if ($request->role === 'seller') {
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

            $sellerData['user_id'] = $user->id;
            $sellerData['seller_category_id'] = $request->seller_category_id;

            Seller::create($sellerData);
        }

        // Generate OTP for email verification
        $otp = rand(100000, 999999);
        $user->update([
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(10)
        ]);

        // TODO: Send OTP via email when SMTP is configured
        // For now, return OTP in response as requested
        return response()->json([
            'success' => true,
            'message' => 'User registered successfully. Please verify your email.',
            'data' => [
                'user' => $user,
                'otp' => $otp, // Remove this when email is implemented
                'otp_expires_at' => $user->otp_expires_at
            ]
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        if (!$user->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Account is deactivated'
            ], 401);
        }

        $token = $user->createToken('auth_token')->accessToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'user' => $user,
                'token' => $token,
                'token_type' => 'Bearer'
            ]
        ]);
    }

    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();
        $otp = rand(100000, 999999);

        $user->update([
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(10)
        ]);

        // TODO: Send OTP via email when SMTP is configured
        // For now, return OTP in response as requested
        return response()->json([
            'success' => true,
            'message' => 'OTP sent successfully',
            'data' => [
                'otp' => $otp, // Remove this when email is implemented
                'otp_expires_at' => $user->otp_expires_at
            ]
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|string|size:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user->otp || $user->otp !== $request->otp) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP'
            ], 400);
        }

        if ($user->otp_expires_at < Carbon::now()) {
            return response()->json([
                'success' => false,
                'message' => 'OTP has expired'
            ], 400);
        }

        $user->update([
            'is_verified' => true,
            'otp' => null,
            'otp_expires_at' => null
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Email verified successfully'
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();
        $otp = rand(100000, 999999);

        $user->update([
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(10)
        ]);

        // TODO: Send OTP via email when SMTP is configured
        // For now, return OTP in response as requested
        return response()->json([
            'success' => true,
            'message' => 'Password reset OTP sent successfully',
            'data' => [
                'otp' => $otp, // Remove this when email is implemented
                'otp_expires_at' => $user->otp_expires_at
            ]
        ]);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|string|size:6',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user->otp || $user->otp !== $request->otp) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP'
            ], 400);
        }

        if ($user->otp_expires_at < Carbon::now()) {
            return response()->json([
                'success' => false,
                'message' => 'OTP has expired'
            ], 400);
        }

        $user->update([
            'password' => Hash::make($request->password),
            'otp' => null,
            'otp_expires_at' => null
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password reset successfully'
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ]);
    }
}