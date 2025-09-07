<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\Seller;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        $seller = Seller::first();
        if (!$seller) return;

        Property::create([
            'title' => 'Cozy Cottage',
            'property_type' => 'House',
            'features' => json_encode(['garden', 'fireplace']),
            'listing_type' => 'Sale',
            'rental_type' => 'N/A',
            'price' => 250000.00,
            'address' => '1 Ocean View',
            'city' => 'San Diego',
            'zipcode' => '92101',
            'size' => '1200 sqft',
            'bedrooms' => 3,
            'bathrooms' => 2,
            'seller_id' => $seller->id,
        ]);
    }
}
