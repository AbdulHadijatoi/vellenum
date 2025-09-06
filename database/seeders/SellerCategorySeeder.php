<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SellerCategory;

class SellerCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Restaurant',
                'slug' => 'restaurant',
                'description' => 'Food and beverage services',
                'is_active' => true,
            ],
            [
                'name' => 'Apparel',
                'slug' => 'apparel',
                'description' => 'Clothing and fashion items',
                'is_active' => true,
            ],
            [
                'name' => 'Fleet',
                'slug' => 'fleet',
                'description' => 'Fleet management services',
                'is_active' => true,
            ],
            [
                'name' => 'Automobile Sales Representative',
                'slug' => 'automobile-sales-representative',
                'description' => 'Automobile sales and representation',
                'is_active' => true,
            ],
            [
                'name' => 'Car Rental Marketplace',
                'slug' => 'car-rental-marketplace',
                'description' => 'Car rental services',
                'is_active' => true,
            ],
            [
                'name' => 'Car Wash',
                'slug' => 'car-wash',
                'description' => 'Vehicle cleaning services',
                'is_active' => true,
            ],
            [
                'name' => 'Insurance Marketplace',
                'slug' => 'insurance-marketplace',
                'description' => 'Insurance services and products',
                'is_active' => true,
            ],
            [
                'name' => 'Digital Bookstore',
                'slug' => 'digital-bookstore',
                'description' => 'Digital books and publications',
                'is_active' => true,
            ],
            [
                'name' => 'Real Estate Broker',
                'slug' => 'real-estate-broker',
                'description' => 'Real estate services',
                'is_active' => true,
            ],
            [
                'name' => 'Black Clothing Lines & Accessories',
                'slug' => 'black-clothing-lines-accessories',
                'description' => 'Black-owned clothing and accessories',
                'is_active' => true,
            ],
            [
                'name' => 'LegalShield Marketplace',
                'slug' => 'legalshield-marketplace',
                'description' => 'Legal services and protection',
                'is_active' => true,
            ],
            [
                'name' => 'Barber Beauty Salon',
                'slug' => 'barber-beauty-salon',
                'description' => 'Hair and beauty services',
                'is_active' => true,
            ],
            [
                'name' => 'Personal Injury Attorney',
                'slug' => 'personal-injury-attorney',
                'description' => 'Personal injury legal services',
                'is_active' => true,
            ],
            [
                'name' => 'Mississippi Catfish Company',
                'slug' => 'mississippi-catfish-company',
                'description' => 'Fresh seafood and catfish products',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            SellerCategory::create($category);
        }
    }
}