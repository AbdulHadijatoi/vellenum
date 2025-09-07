<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\Seller;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $seller = Seller::first();
        if (!$seller) return;

        Service::create([
            'name' => 'Personal Injury Consultation',
            'description' => 'One hour consultation with attorney',
            'pricing_model' => 'hourly',
            'price' => 200,
            'seller_id' => $seller->id,
        ]);
    }
}
