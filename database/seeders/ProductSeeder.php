<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->truncate();

        $products = [
            [
                'title' => 'Snorkeling Adventure',
                'description' => 'Explore the crystal-clear waters around Pulau Pramuka with guided snorkeling tours. Discover vibrant coral reefs and tropical marine life in one of Indonesia\'s most pristine underwater environments.',
                'order' => 1,
                'is_active' => true
            ],
            [
                'title' => 'Island Hopping Tour',
                'description' => 'Experience the beauty of Thousand Islands with our comprehensive island hopping package. Visit multiple pristine islands, enjoy white sandy beaches, and witness stunning sunset views.',
                'order' => 2,
                'is_active' => true
            ],
            [
                'title' => 'Turtle Conservation Program',
                'description' => 'Join our turtle conservation efforts and learn about marine wildlife protection. Participate in turtle release programs and contribute to preserving these magnificent creatures.',
                'order' => 3,
                'is_active' => true
            ],
            [
                'title' => 'Traditional Fishing Experience',
                'description' => 'Learn traditional fishing techniques from local fishermen. Experience authentic island life while contributing to sustainable tourism and supporting the local community.',
                'order' => 4,
                'is_active' => true
            ],
            [
                'title' => 'Mangrove Forest Tour',
                'description' => 'Explore the unique mangrove ecosystem surrounding Pulau Pramuka. Discover diverse wildlife, learn about environmental conservation, and enjoy peaceful boat rides through nature.',
                'order' => 5,
                'is_active' => true
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
