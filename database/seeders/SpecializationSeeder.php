<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Specialization;

class SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $specializations = [
            [
                'name' => 'Used Cars',
            ],
            [
                'name' => 'Luxury Vehicles',
            ],
            [
                'name' => 'New Cars',
            ],
            [
                'name' => 'Electric Vehicles',
            ],
        ];

        foreach ($specializations as $specialization) {
            Specialization::create($specialization);
        }
    }
}