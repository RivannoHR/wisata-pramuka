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
                'is_active' => true,
                'is_featured' => true // Featured in carousel
            ],
            [
                'title' => 'Sabun Minyak Jelantah',
                'description' => 'Sabun ramah lingkungan yang terbuat dari minyak jelantah daur ulang. Baik untuk kulit dan lingkungan.',
                'price' => 15000,
                'stock' => 30,
                'image_path' => 'products/Sabun-minyak-jelantah.png',
                'is_active' => true,
                'is_featured' => true // Featured in carousel
            ],
            [
                'title' => 'Keripik Sukun',
                'description' => 'Keripik sukun renyah dan gurih, camilan sehat khas Pulau Pramuka yang terbuat dari sukun pilihan.',
                'price' => 20000,
                'stock' => 25,
                'image_path' => 'products/Keripik-sukun.png',
                'is_active' => true,
                'is_featured' => true // Featured in carousel
            ],
            [
                'title' => 'Olahan Ikan',
                'description' => 'Berbagai olahan ikan segar khas Kepulauan Seribu. Diproses dengan higienis dan cita rasa yang lezat.',
                'price' => 35000,
                'stock' => 15,
                'image_path' => 'products/Olahan-ikan.png',
                'is_active' => true,
                'is_featured' => true // Featured in carousel
            ],
            [
                'title' => 'Produk Plastik Daur Ulang',
                'description' => 'As the island\'s effort to conserve the island\'s environment and reduce plastic waste, plastic products that have been thrown away are clean and recycled into various unique and creative products that can be reused.',
                'price' => 20000,
                'stock' => 50,
                'image_path' => 'products/Daur-ulang-plastik.png',
                'is_active' => true,
                'is_featured' => false // Not featured in carousel
            ],
            [
                'title' => 'Ikan Kering Asin',
                'description' => 'As a small island, the commodities come from the sea. Dried salted fish is an Indonesian food that is especially common in regions near the sea.',
                'price' => 35000,
                'stock' => 25,
                'image_path' => 'products/Ikan-kering-asin.png',
                'is_active' => true,
                'is_featured' => false // Not featured in carousel
            ],
            [
                'title' => 'Abon Ikan',
                'description' => 'Fish meat floss is another sea food product that you can find in this island. Fish are processed and shredded into thin strands. Perfect to be consumed with other foods.',
                'price' => 25000,
                'stock' => 60,
                'image_path' => 'products/Abon-ikan.png',
                'is_active' => true,
                'is_featured' => false // Not featured in carousel
            ],
            [
                'title' => 'Krupuk Ikan',
                'description' => 'Krupuk is a popular Indonesian that is crispy to eat. This krupuk uses fish as its base ingredient. Some krupuk are ready to eat, while some are packaged raw where you have to fry it before eating.',
                'price' => 15000,
                'stock' => 100,
                'image_path' => 'products/Krupuk-ikan.png',
                'is_active' => true,
                'is_featured' => false // Not featured in carousel
            ],
            [
                'title' => 'Krupuk Udang',
                'description' => 'Similar to krupuk ikan, this one uses shrimps as its base ingredient. Despite the similarity, it has a distinct taste and aroma that makes it different from krupuk ikan.',
                'price' => 15000,
                'stock' => 60,
                'image_path' => 'products/Kerupuk-udang.png',
                'is_active' => true,
                'is_featured' => false // Not featured in carousel
            ],
            [
                'title' => 'Udang Rebon Kering',
                'description' => 'Dried rebon (acetes) prawn is a common commodity in Indonesia. It can be cooked as its own dish, or added into another dish for flavor.',
                'price' => 17500,
                'stock' => 35,
                'image_path' => 'products/Udang-rebon-kering.png',
                'is_active' => true,
                'is_featured' => false // Not featured in carousel
            ],
            [
                'title' => 'Cumi dan Sotong Kering',
                'description' => 'Dried squid and cuttlefish are another common commodity in Indonesia. Some of them can be eaten directly, while some needs to be cooked.',
                'price' => 22500,
                'stock' => 25,
                'image_path' => 'products/Cumi-dan-sotong-kering.png',
                'is_active' => true,
                'is_featured' => false // Not featured in carousel
            ],
            [
                'title' => 'Kerajinan Kerang',
                'description' => 'Various products made from seashells can be found in this island, ranging from home decoration to jewelry.',
                'price' => 10000,
                'stock' => 100,
                'image_path' => 'products/Kerajinan-kerang.png',
                'is_active' => true,
                'is_featured' => false // Not featured in carousel
            ],
            [
                'title' => 'Krupuk Kepiting',
                'description' => 'Plenty of things can be made into krupuk, crabs being one of them, offering you a new way to enjoy crabs.',
                'price' => 20000,
                'stock' => 25,
                'image_path' => 'products/Krupuk-kepiting.png',
                'is_active' => true,
                'is_featured' => false // Not featured in carousel
            ],
            [
                'title' => 'Souvenirs',
                'description' => 'You can\'t leave Pulau Pramuka without buying some of their souvenirs. These souvenirs are made with various things, such as seashells, sand, or other materials.',
                'price' => 25000,
                'stock' => 150,
                'image_path' => 'products/Souvenirs.png',
                'is_active' => true,
                'is_featured' => false // Not featured in carousel
            ]
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}
