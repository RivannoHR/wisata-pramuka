<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'title' => 'Lilin Aromatherapy',
                'description' => 'Lilin aromatherapy alami dengan berbagai aroma yang menenangkan. Terbuat dari bahan-bahan berkualitas tinggi dan ramah lingkungan.',
                'price' => 25000,
                'stock' => 50,
                'image_path' => 'products/Lilin-aromatherapy.png',
                'is_active' => true // Featured in carousel
            ],
            [
                'title' => 'Sabun Minyak Jelantah',
                'description' => 'Sabun ramah lingkungan yang terbuat dari minyak jelantah daur ulang. Baik untuk kulit dan lingkungan.',
                'price' => 15000,
                'stock' => 30,
                'image_path' => 'products/Sabun-minyak-jelantah.png',
                'is_active' => true // Featured in carousel
            ],
            [
                'title' => 'Keripik Sukun',
                'description' => 'Keripik sukun renyah dan gurih, camilan sehat khas Pulau Pramuka yang terbuat dari sukun pilihan.',
                'price' => 20000,
                'stock' => 25,
                'image_path' => 'products/Keripik-sukun.png',
                'is_active' => true // featured in carousel
            ],
            [
                'title' => 'Olahan Ikan',
                'description' => 'Berbagai olahan ikan segar khas Kepulauan Seribu. Diproses dengan higienis dan cita rasa yang lezat.',
                'price' => 35000,
                'stock' => 15,
                'image_path' => 'products/Olahan-ikan.png',
                'is_active' => true // Featured in carousel
            ]
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}
