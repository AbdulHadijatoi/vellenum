<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Seller;
use App\Models\SellerCategory;
use App\Models\File;
use Illuminate\Support\Str;

class SellerSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure there is at least one seller user
        $user = User::first() ?? User::factory()->create();

        $category = SellerCategory::first() ?? SellerCategory::create(['name' => 'Default', 'description' => 'Default category', 'status' => true]);

        // Create a dummy file record for references
        $file = File::first();

        $seller = Seller::create([
            'user_id' => $user->id,
            'seller_category_id' => $category->id,
            'operating_hours' => json_encode(['monday' => ['start' => '09:00', 'end' => '18:00']]),
            'license_number' => 'LIC-0001',
            'years_of_experience' => 2,
            'bar_association_number' => null,
            'license_expiry_date' => null,
            'government_issued_id' => $file?->id,
            'business_registration_certificate' => $file?->id,
            'food_safety_certifications' => $file?->id,
            'professional_license' => $file?->id,
            'legal_certifications' => $file?->id,
            'status' => true,
        ]);
    }
}
