<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Food & Beverage',
                'slug' => 'food-beverage',
                'description' => 'Food and beverage products',
                'is_active' => true,
            ],
            [
                'name' => 'Clothing & Accessories',
                'slug' => 'clothing-accessories',
                'description' => 'Clothing and fashion accessories',
                'is_active' => true,
            ],
            [
                'name' => 'Automotive',
                'slug' => 'automotive',
                'description' => 'Automotive products and services',
                'is_active' => true,
            ],
            [
                'name' => 'Insurance',
                'slug' => 'insurance',
                'description' => 'Insurance products and services',
                'is_active' => true,
            ],
            [
                'name' => 'Books & Media',
                'slug' => 'books-media',
                'description' => 'Books and digital media',
                'is_active' => true,
            ],
            [
                'name' => 'Real Estate',
                'slug' => 'real-estate',
                'description' => 'Real estate properties and services',
                'is_active' => true,
            ],
            [
                'name' => 'Beauty & Wellness',
                'slug' => 'beauty-wellness',
                'description' => 'Beauty and wellness services',
                'is_active' => true,
            ],
            [
                'name' => 'Legal Services',
                'slug' => 'legal-services',
                'description' => 'Legal services and consultation',
                'is_active' => true,
            ],
            [
                'name' => 'Seafood',
                'slug' => 'seafood',
                'description' => 'Fresh seafood and fish products',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            ProductCategory::create($category);
        }
    }
}
