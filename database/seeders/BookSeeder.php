<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Seller;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $seller = Seller::first();
        if (!$seller) return;

        Book::create([
            'title' => 'The Great Book',
            'author' => 'A. Author',
            'price' => 9.99,
            'genre' => 'Fiction',
            'format' => 'epub',
            'seller_id' => $seller->id,
        ]);
    }
}
