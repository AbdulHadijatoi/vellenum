<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehicle;
use App\Models\Seller;

class VehicleSeeder extends Seeder
{
    public function run(): void
    {
        $seller = Seller::first();
        if (!$seller) return;

        Vehicle::create([
            'name' => 'Van A',
            'make' => 'Ford',
            'model' => 'Transit',
            'year' => 2018,
            'mileage' => 50000,
            'hourly_rate' => 25.00,
            'license_number' => 'ABC-123',
            'registration_date' => now()->toDateString(),
            'seller_id' => $seller->id,
        ]);
    }
}
