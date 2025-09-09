<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DeliveryPartner;
use App\Models\OTPCode;
use App\Models\User;
use App\Models\Seller;
use App\Models\SellerCategory;
use App\Models\File;
use App\Models\ReferalCode;
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
            'address' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'referal_code' => 'nullable|string|max:8',

            'seller_category_id' => 'nullable|exists:seller_categories,id',
            'license_number' => 'nullable|string',
            'operating_hours' => 'nullable|string',
            'years_of_experience' => 'nullable|string',
            'bar_association_number' => 'nullable|string',
            'delivery_partner_name' => 'nullable|string',
            'delivery_partner_phone' => 'nullable|string',
            'social_security_number' => 'nullable|string',
            // File uploads (optional) - accept common document/image types up to 10MB
            'government_issued_id' => 'nullable|file|max:10240',
            'business_registration_certificate' => 'nullable|file|max:10240',
            'food_safety_certifications' => 'nullable|file|max:10240',
            'professional_license' => 'nullable|file|max:10240',
            'legal_certifications' => 'nullable|file|max:10240',
            'role' => 'required|in:seller,buyer',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $getReferalCode = ReferalCode::where('code', $request->referal_code)->first();

        // Create user
        $createUserData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'zip_code' => $request->zip_code,
            'referal_code_id' => $getReferalCode?$getReferalCode->id:null,
        ];


        $user = User::create($createUserData);


        // Assign role
        $user->assignRole($request->role);
        $referalCode = ReferalCode::create([
            'user_id' => $user->id,
            'code' => ReferalCode::generateCode(8)
        ]);


        // If seller, create seller record
        if ($request->role === 'seller') {


            // Only include columns that exist on the sellers table to avoid SQL errors
            $allowedSellerFields = [
                "license_number",
                "operating_hours",
                "years_of_experience",
                "bar_association_number",
            ];

            $sellerData = [
                'user_id' => $user->id,
                'seller_category_id' => $request->seller_category_id,
            ];

            foreach ($allowedSellerFields as $field) {
                if ($request->has($field)) {
                    $sellerData[$field] = $request->input($field);
                }
            }

            // Map only files that correspond to actual seller foreign keys in the migration
            $fileFieldMap = [
                'government_issued_id' => 'government_issued_id',
                'business_registration_certificate' => 'business_registration_certificate',
                'food_safety_certifications' => 'food_safety_certifications',
                'professional_license' => 'professional_license',
                'legal_certifications' => 'legal_certifications',
            ];

            

            // All incoming file keys we validate for registration - we'll create File records for any uploaded
            $allFileKeys = [
                'food_safety_certifications',
                'government_issued_id',
                'business_registration_certificate',
                'professional_license',
                'legal_certifications',
                // 'vehicle_registration_document_file',
                // 'vehicle_insurance_document_file',
                // 'book_cover_file',
                // 'book_file',
                // 'product_photo_file',
                // 'text_identification_file'
            ];

            foreach ($allFileKeys as $reqKey) {
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

                    // Attach to seller only when the file maps to a seller column
                    if (isset($fileFieldMap[$reqKey])) {
                        $sellerColumn = $fileFieldMap[$reqKey];
                        $sellerData[$sellerColumn] = $file->id;
                    }
                }
            }

            $seller = Seller::create($sellerData);

            //restaurant
            if($request->seller_category_id == 1){
                $deliveryPartner = DeliveryPartner::where('name', $request->delivery_partner_name)
                                    ->where('phone', $request->delivery_partner_phone)
                                    ->where('ssn', $request->social_security_number)
                                    ->first();
                if(!$deliveryPartner){
                    $deliveryPartner = new DeliveryPartner();
                    $deliveryPartner->name = $request->delivery_partner_name;
                    $deliveryPartner->phone = $request->delivery_partner_phone;
                    $deliveryPartner->ssn = $request->social_security_number;
                    $deliveryPartner->save();
                }
                $seller->delivery_partner_id = $deliveryPartner->id;
                $seller->save();
            }

            // create products or services
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
                'referal_code' => $referalCode->code??null
                // 'otp' => $otp, // Remove this when email is implemented
                // 'otp_expires_at' => $user->otp_expires_at
            ]
        ], 200);
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

        if (!$user->status) {
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