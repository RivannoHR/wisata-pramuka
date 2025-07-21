<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TouristAttraction;
use App\Models\TouristAttractionImage;

class TouristAttractionImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing tourist attraction images first
        TouristAttractionImage::truncate();
        
        // Add all tourist attraction images with actual file paths
        $this->addAllTouristAttractionImages();
        
        echo "All tourist attraction images seeded successfully!\n";
    }
    
    /**
     * Add all tourist attraction images with correct file paths
     */
    private function addAllTouristAttractionImages()
    {
        // Define all tourist attraction images based on actual files
        $attractionImages = [
            1 => [ // Labirin Hutan Mangrove
                ['image_path' => 'attractions/labirin-mangrove-1.png', 'alt_text' => 'Labirin Hutan Mangrove - Wooden Walkway', 'is_featured' => true],
                ['image_path' => 'attractions/labirin-mangrove-2.png', 'alt_text' => 'Labirin Hutan Mangrove - Mangrove Trees', 'is_featured' => false],
                ['image_path' => 'attractions/labirin-mangrove-3.png', 'alt_text' => 'Labirin Hutan Mangrove - Nature Trail', 'is_featured' => false]
            ],
            2 => [ // Hutan Eduwisata Rumah Literasi Hijau
                ['image_path' => 'attractions/hutan-eduwisata-1.png', 'alt_text' => 'Hutan Eduwisata - Educational Center', 'is_featured' => true],
                ['image_path' => 'attractions/hutan-eduwisata-2.png', 'alt_text' => 'Hutan Eduwisata - Learning Activities', 'is_featured' => false],
                ['image_path' => 'attractions/hutan-eduwisata-3.png', 'alt_text' => 'Hutan Eduwisata - Green Library', 'is_featured' => false]
            ],
            3 => [ // Pantai Sunrise
                ['image_path' => 'attractions/pantai-sunrise-1.png', 'alt_text' => 'Pantai Sunrise - Beautiful Sunrise View', 'is_featured' => true],
                ['image_path' => 'attractions/pantai-sunrise-2.png', 'alt_text' => 'Pantai Sunrise - Beach Morning', 'is_featured' => false],
                ['image_path' => 'attractions/pantai-sunrise-3.png', 'alt_text' => 'Pantai Sunrise - Golden Hour', 'is_featured' => false]
            ],
            4 => [ // Coral Education Center
                ['image_path' => 'attractions/coral-education-center-1.png', 'alt_text' => 'Coral Education Center - Main Building', 'is_featured' => true],
                ['image_path' => 'attractions/coral-education-center-2.png', 'alt_text' => 'Coral Education Center - Learning Space', 'is_featured' => false],
                ['image_path' => 'attractions/coral-education-center-3.png', 'alt_text' => 'Coral Education Center - Marine Exhibits', 'is_featured' => false]
            ],
            5 => [ // Resto Alam Nusantara
                ['image_path' => 'attractions/resto-alam-1.png', 'alt_text' => 'Resto Alam Nusantara - Restaurant Exterior', 'is_featured' => true],
                ['image_path' => 'attractions/resto-alam-2.png', 'alt_text' => 'Resto Alam Nusantara - Dining Area', 'is_featured' => false],
                ['image_path' => 'attractions/resto-alam-3.png', 'alt_text' => 'Resto Alam Nusantara - Indonesian Cuisine', 'is_featured' => false]
            ],
            6 => [ // Scuba Coffee
                ['image_path' => 'attractions/scuba-coffee-1.png', 'alt_text' => 'Scuba Coffee - Beachside Cafe', 'is_featured' => true],
                ['image_path' => 'attractions/scuba-coffee-2.png', 'alt_text' => 'Scuba Coffee - Coffee Bar', 'is_featured' => false],
                ['image_path' => 'attractions/scuba-coffee-3.png', 'alt_text' => 'Scuba Coffee - Ocean View Seating', 'is_featured' => false]
            ],
            7 => [ // Warung Bu Rahma
                ['image_path' => 'attractions/warung-bu-rahma-1.png', 'alt_text' => 'Warung Bu Rahma - Traditional Restaurant', 'is_featured' => true],
                ['image_path' => 'attractions/warung-bu-rahma-2.png', 'alt_text' => 'Warung Bu Rahma - Local Food', 'is_featured' => false],
                ['image_path' => 'attractions/warung-bu-rahma-3.png', 'alt_text' => 'Warung Bu Rahma - Seafood Specialties', 'is_featured' => false]
            ],
            8 => [ // Coral Souvenir
                ['image_path' => 'attractions/coral-souvenir-1.png', 'alt_text' => 'Coral Souvenir - Shop Front', 'is_featured' => true],
                ['image_path' => 'attractions/coral-souvenir-2.png', 'alt_text' => 'Coral Souvenir - Marine Souvenirs', 'is_featured' => false],
                ['image_path' => 'attractions/coral-souvenir-3.png', 'alt_text' => 'Coral Souvenir - Gift Collection', 'is_featured' => false]
            ],
            9 => [ // Toko Azura
                ['image_path' => 'attractions/toko-azura-1.png', 'alt_text' => 'Toko Azura - Store Exterior', 'is_featured' => true],
                ['image_path' => 'attractions/toko-azura-2.png', 'alt_text' => 'Toko Azura - Product Display', 'is_featured' => false],
                ['image_path' => 'attractions/toko-azura-3.png', 'alt_text' => 'Toko Azura - Shopping Area', 'is_featured' => false]
            ],
            10 => [ // Toko Tepi Pantai
                ['image_path' => 'attractions/toko-tepi-pantai-1.png', 'alt_text' => 'Toko Tepi Pantai - Beachside Store', 'is_featured' => true],
                ['image_path' => 'attractions/toko-tepi-pantai-2.png', 'alt_text' => 'Toko Tepi Pantai - Convenience Items', 'is_featured' => false],
                ['image_path' => 'attractions/toko-tepi-pantai-3.png', 'alt_text' => 'Toko Tepi Pantai - Local Products', 'is_featured' => false]
            ]
        ];
        
        foreach ($attractionImages as $attractionId => $images) {
            $attraction = TouristAttraction::find($attractionId);
            if ($attraction) {
                foreach ($images as $index => $imageData) {
                    TouristAttractionImage::create([
                        'tourist_attraction_id' => $attractionId,
                        'image_path' => $imageData['image_path'],
                        'alt_text' => $imageData['alt_text'],
                        'sort_order' => $index + 1,
                        'is_featured' => $imageData['is_featured']
                    ]);
                }
                echo "Added " . count($images) . " images for {$attraction->name}.\n";
            }
        }
    }
}
