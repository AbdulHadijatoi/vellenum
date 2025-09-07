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
                'description' => 'Food and beverage services',
                'status' => true,
            ],
            [
                'name' => 'Apparel',
                'description' => 'Clothing and fashion items',
                'status' => true,
            ],
            [
                'name' => 'Fleet',
                'description' => 'Fleet management services',
                'status' => true,
            ],
            [
                'name' => 'Automobile Sales Representative',
                'description' => 'Automobile sales and representation',
                'status' => true,
            ],
            [
                'name' => 'Car Rental Marketplace',
                'description' => 'Car rental services',
                'status' => true,
            ],
            [
                'name' => 'Car Wash',
                'description' => 'Vehicle cleaning services',
                'status' => true,
            ],
            [
                'name' => 'Insurance Marketplace',
                'description' => 'Insurance services and products',
                'status' => true,
            ],
            [
                'name' => 'Digital Bookstore',
                'description' => 'Digital books and publications',
                'status' => true,
            ],
            [
                'name' => 'Real Estate Broker',
                'description' => 'Real estate services',
                'status' => true,
            ],
            [
                'name' => 'Black Clothing Lines & Accessories',
                'description' => 'Black-owned clothing and accessories',
                'status' => true,
            ],
            [
                'name' => 'LegalShield Marketplace',
                'description' => 'Legal services and protection',
                'status' => true,
            ],
            [
                'name' => 'Retail Store',
                'description' => 'Retail services and products',
                'status' => true,
            ],
            [
                'name' => 'Barber Beauty Salon',
                'description' => 'Hair and beauty services',
                'status' => true,
            ],
            [
                'name' => 'Personal Injury Attorney',
                'description' => 'Personal injury legal services',
                'status' => true,
            ],
            [
                'name' => 'Mississippi Catfish Company',
                'description' => 'Fresh seafood and catfish products',
                'status' => true,
            ],
        ];

        foreach ($categories as $category) {
            SellerCategory::create($category);
        }
    }
}