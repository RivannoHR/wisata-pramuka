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
                'title' => 'Lilin Aromatherapy',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sem neque, lobortis nec tempus non, ultrices quis urna. Nulla dignissim, urna ac luctus congue, elit.',
                'order' => 1,
                'stock' => 25,
                'is_active' => true
            ],
            [
                'title' => 'Sabun Minyak Jelantah',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sem neque, lobortis nec tempus non, ultrices quis urna. Nulla dignissim, urna ac luctus congue, elit.',
                'order' => 2,
                'stock' => 15,
                'is_active' => true
            ],
            [
                'title' => 'Keripik Sukun',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sem neque, lobortis nec tempus non, ultrices quis urna. Nulla dignissim, urna ac luctus congue, elit.',
                'order' => 3,
                'stock' => 10,
                'is_active' => true
            ],
            [
                'title' => 'Olahan Ikan',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sem neque, lobortis nec tempus non, ultrices quis urna. Nulla dignissim, urna ac luctus congue, elit.',
                'order' => 4,
                'stock' => 20,
                'is_active' => true
            ],
            [
                'title' => 'Mangrove Forest Tour',
                'description' => 'Explore the unique mangrove ecosystem surrounding Pulau Pramuka. Discover diverse wildlife, learn about environmental conservation, and enjoy peaceful boat rides through nature.',
                'order' => 5,
                'stock' => 12,
                'is_active' => true
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
