<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InsuranceOffering;
use App\Models\Seller;

class InsuranceOfferingSeeder extends Seeder
{
    public function run(): void
    {
        $seller = Seller::first();
        if (!$seller) return;

        InsuranceOffering::create([
            'insurance_name' => 'Basic Liability',
            'insurance_type' => 'Liability',
            'rate_basic' => 49.99,
            'description' => 'Basic liability plan',
            'seller_id' => $seller->id,
        ]);
    }
}
