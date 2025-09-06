<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OTPCode;
use App\Models\User;
use App\Models\Seller;
use App\Models\SellerCategory;
use App\Models\File;
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
            'seller_category_id' => 'nullable|exists:seller_categories,id',
            // File uploads (optional) - accept common document/image types up to 10MB
            'text_identification_file' => 'nullable|file|max:10240',
            'proof_of_business_registration_file' => 'nullable|file|max:10240',
            'food_safety_certifications_file' => 'nullable|file|max:10240',
            'government_issued_id_file' => 'nullable|file|max:10240',
            'business_registration_certificate_file' => 'nullable|file|max:10240',
            'professional_license_file' => 'nullable|file|max:10240',
            'legal_certifications_file' => 'nullable|file|max:10240',
            'vehicle_registration_document_file' => 'nullable|file|max:10240',
            'vehicle_insurance_document_file' => 'nullable|file|max:10240',
            'book_cover_file' => 'nullable|file|max:10240',
            'book_file' => 'nullable|file|max:10240',
            'product_photo_file' => 'nullable|file|max:10240',
            'role' => 'required|in:seller,buyer',
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

            // Map uploaded files to File model records and set seller file_id columns
            $fileFieldMap = [
                'text_identification_file' => 'text_identification_file_id',
                'proof_of_business_registration_file' => 'proof_of_business_registration_file_id',
                'food_safety_certifications_file' => 'food_safety_certifications_file_id',
                'government_issued_id_file' => 'government_issued_id_file_id',
                'business_registration_certificate_file' => 'business_registration_certificate_file_id',
                'professional_license_file' => 'professional_license_file_id',
                'legal_certifications_file' => 'legal_certifications_file_id',
                'vehicle_registration_document_file' => 'vehicle_registration_document_file_id',
                'vehicle_insurance_document_file' => 'vehicle_insurance_document_file_id',
                'book_cover_file' => 'book_cover_file_id',
                'book_file' => 'book_file_id',
                'product_photo_file' => 'product_photo_file_id',
            ];

            foreach ($fileFieldMap as $reqKey => $sellerKey) {
                if ($request->hasFile($reqKey)) {
                    $uploaded = $request->file($reqKey);
                    $originalName = $uploaded->getClientOriginalName();
                    $extension = $uploaded->getClientOriginalExtension();
                    $mimeType = $uploaded->getMimeType();
                    $size = $uploaded->getSize();

                    $filename = Str::uuid() . '.' . $extension;
                    $path = $uploaded->storeAs('files', $filename, 'public');

                    $file = File::create([
                        'original_name' => $originalName,
                        'filename' => $filename,
                        'path' => $path,
                        'mime_type' => $mimeType,
                        'extension' => $extension,
                        'size' => $size,
                        'disk' => 'public',
                        'category' => 'seller_document',
                        'description' => null,
                        'uploaded_by' => $user->id,
                        'is_public' => true,
                    ]);

                    $sellerData[$sellerKey] = $file->id;
                }
            }

            Seller::create($sellerData);
        }

        // // Generate OTP for email verification
        // $otp = rand(100000, 999999);
        // $user->update([
        //     'otp' => $otp,
        //     'otp_expires_at' => Carbon::now()->addMinutes(10)
        // ]);

        // TODO: Send OTP via email when SMTP is configured
        // For now, return OTP in response as requested
        return response()->json([
            'success' => true,
            'message' => 'User registered successfully.',
            'data' => [
                'user' => $user,
                // 'otp' => $otp, // Remove this when email is implemented
                // 'otp_expires_at' => $user->otp_expires_at
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
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $otp = new OTPCode();

        $otp = $otp->generateOtp($request->email);

        // TODO: Send OTP via email when SMTP is configured
        // For now, return OTP in response as requested
        return response()->json([
            'success' => true,
            'message' => 'OTP sent successfully',
            'data' => [
                'otp' => $otp->otp_code,
                'otp_expires_at' => $otp->expires_at
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

        $otp = OTPCode::where('email', $request->email)->latest('id')->first();

        if (!$otp || $otp->otp_code !== $request->otp) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP'
            ], 400);
        }

        if (!$otp->isValid()) {
            return response()->json([
                'success' => false,
                'message' => 'OTP has expired'
            ], 400);
        }

        $otp->is_used = true;
        $otp->save();

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