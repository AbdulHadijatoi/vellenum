<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SellerMenu;
use App\Models\Seller;

class SellerMenuSeeder extends Seeder
{
    public function run(): void
    {
        $seller = Seller::first();
        if (!$seller) return;

        SellerMenu::create([
            'seller_id' => $seller->id,
            'name' => 'Classic Haircut',
            'category' => 'Hair',
            'description' => 'Classic men\'s haircut',
            'price' => 25.00,
            'duration' => '30 mins',
            'discount' => null,
        ]);
    }
}
