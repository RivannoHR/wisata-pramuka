<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Accommodation;
use App\Models\AccommodationImage;
use Illuminate\Support\Facades\DB;

class AccommodationImageSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('accommodation_images')->truncate();
        $accommodationImages = [
            1 => [ // Dermaga Resort
                ['image_path' => 'accommodations/1/dermaga-resort-1.png', 'alt_text' => 'Dermaga Resort - Main Building', 'is_featured' => true],
                ['image_path' => 'accommodations/1/dermaga-resort-2.png', 'alt_text' => 'Dermaga Resort - Room Interior', 'is_featured' => false],
                ['image_path' => 'accommodations/1/dermaga-resort-3.png', 'alt_text' => 'Dermaga Resort - Restaurant Area', 'is_featured' => false]
            ],
            2 => [ // Seribu Resort Thousand Island
                ['image_path' => 'accommodations/2/seribu-resort-1.png', 'alt_text' => 'Seribu Resort - Ocean View', 'is_featured' => true],
                ['image_path' => 'accommodations/2/seribu-resort-2.png', 'alt_text' => 'Seribu Resort - Luxury Suite', 'is_featured' => false],
                ['image_path' => 'accommodations/2/seribu-resort-3.png', 'alt_text' => 'Seribu Resort - Spa Area', 'is_featured' => false]
            ],
            3 => [ // Villa Delima
                ['image_path' => 'accommodations/3/villa-delima-1.png', 'alt_text' => 'Villa Delima - Garden View', 'is_featured' => true],
                ['image_path' => 'accommodations/3/villa-delima-2.png', 'alt_text' => 'Villa Delima - Private Pool', 'is_featured' => false],
                ['image_path' => 'accommodations/3/villa-delima-3.png', 'alt_text' => 'Villa Delima - Living Area', 'is_featured' => false]
            ],
            4 => [ // Penginapan Permata
                ['image_path' => 'accommodations/4/penginapan-permata-1.png', 'alt_text' => 'Penginapan Permata - Main Building', 'is_featured' => true],
                ['image_path' => 'accommodations/4/penginapan-permata-2.png', 'alt_text' => 'Penginapan Permata - Clean Room', 'is_featured' => false],
                ['image_path' => 'accommodations/4/penginapan-permata-3.png', 'alt_text' => 'Penginapan Permata - Common Area', 'is_featured' => false]
            ],
            5 => [ // Royal Mermaid
                ['image_path' => 'accommodations/5/royal-mermaid-1.png', 'alt_text' => 'Royal Mermaid - Beachfront View', 'is_featured' => true],
                ['image_path' => 'accommodations/5/royal-mermaid.png', 'alt_text' => 'Royal Mermaid - Elegant Exterior', 'is_featured' => false],
                ['image_path' => 'accommodations/5/royal-mermaid-3.png', 'alt_text' => 'Royal Mermaid - Room Interior', 'is_featured' => false]
            ],
            6 => [ // Homestay Kedaton
                ['image_path' => 'accommodations/6/homestay-kedaton-1.png', 'alt_text' => 'Homestay Kedaton - Traditional Style', 'is_featured' => true],
                ['image_path' => 'accommodations/6/homestay-kedaton-2.png', 'alt_text' => 'Homestay Kedaton - Cozy Room', 'is_featured' => false],
                ['image_path' => 'accommodations/6/homestay-kedaton-3.png', 'alt_text' => 'Homestay Kedaton - Common Space', 'is_featured' => false]
            ],
            7 => [ // Homestay Sunrise
                ['image_path' => 'accommodations/7/homestay-sunrise-1.png', 'alt_text' => 'Homestay Sunrise - Morning View', 'is_featured' => true],
                ['image_path' => 'accommodations/7/homestay-sunrise-2.png', 'alt_text' => 'Homestay Sunrise - Comfortable Room', 'is_featured' => false],
                ['image_path' => 'accommodations/7/homestay-sunrise-3.png', 'alt_text' => 'Homestay Sunrise - Terrace Area', 'is_featured' => false]
            ],
            8 => [ // Homestay Alex
                ['image_path' => 'accommodations/8/homestay-alex-1.png', 'alt_text' => 'Homestay Alex - Welcoming Entrance', 'is_featured' => true],
                ['image_path' => 'accommodations/8/homestay-alex-2.png', 'alt_text' => 'Homestay Alex - Simple Room', 'is_featured' => false],
                ['image_path' => 'accommodations/8/homestay-alex-3.png', 'alt_text' => 'Homestay Alex - Shared Kitchen', 'is_featured' => false]
            ],
            9 => [ // Homestay Haris (Note: files are named homestay-harris)
                ['image_path' => 'accommodations/9/homestay-harris-1.png', 'alt_text' => 'Homestay Haris - Family Friendly', 'is_featured' => true],
                ['image_path' => 'accommodations/9/homestay-harris-2.png', 'alt_text' => 'Homestay Haris - Local Experience', 'is_featured' => false],
                ['image_path' => 'accommodations/9/homestay-harris-3.png', 'alt_text' => 'Homestay Haris - Authentic Setting', 'is_featured' => false]
            ],
            10 => [ // Dolphin's Villa
                ['image_path' => 'accommodations/10/Dolphin-1.png', 'alt_text' => 'Dolphin\'s Villa - Main View', 'is_featured' => true],
                ['image_path' => 'accommodations/10/Dolphin-2.png', 'alt_text' => 'Dolphin\'s Villa - Interior', 'is_featured' => false],
                ['image_path' => 'accommodations/10/Dolphin-3.png', 'alt_text' => 'Dolphin\'s Villa - Pool Area', 'is_featured' => false]
            ]
        ];

        foreach ($accommodationImages as $accommodationId => $images) {
            $accommodation = Accommodation::find($accommodationId);
            if ($accommodation) {
                foreach ($images as $index => $imageData) {
                    AccommodationImage::create([
                        'accommodation_id' => $accommodationId,
                        'image_path' => $imageData['image_path'],
                        'alt_text' => $imageData['alt_text'],
                        'sort_order' => $index + 1,
                        'is_featured' => $imageData['is_featured']
                    ]);
                }
                echo "Added " . count($images) . " images for {$accommodation->name}.\n";
            }
        }
    }
}
