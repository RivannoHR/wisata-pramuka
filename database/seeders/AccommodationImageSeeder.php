<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Accommodation;
use App\Models\AccommodationImage;

class AccommodationImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing accommodation images first
        AccommodationImage::truncate();
        
        // Get Dolphin's Villa accommodation
        $dolphinVilla = Accommodation::where('name', 'Dolphin\'s Villa')->first();
        
        if ($dolphinVilla) {
            // Create 3 images for Dolphin's Villa with your actual image files
            $images = [
                [
                    'accommodation_id' => $dolphinVilla->id,
                    'image_path' => 'accommodations/Dolphin-1.png',
                    'alt_text' => 'Dolphin\'s Villa - Main View',
                    'sort_order' => 1,
                    'is_featured' => true // Main featured image
                ],
                [
                    'accommodation_id' => $dolphinVilla->id,
                    'image_path' => 'accommodations/Dolphin-2.png',
                    'alt_text' => 'Dolphin\'s Villa - Interior',
                    'sort_order' => 2,
                    'is_featured' => false
                ],
                [
                    'accommodation_id' => $dolphinVilla->id,
                    'image_path' => 'accommodations/Dolphin-3.png',
                    'alt_text' => 'Dolphin\'s Villa - Pool Area',
                    'sort_order' => 3,
                    'is_featured' => false
                ]
            ];

            foreach ($images as $imageData) {
                AccommodationImage::create($imageData);
            }

            echo "Created 3 images for Dolphin's Villa accommodation.\n";
        }
        
        // Create placeholder images for other accommodations (you can add actual images later)
        $otherAccommodations = Accommodation::where('name', '!=', 'Dolphin\'s Villa')->get();
        
        foreach ($otherAccommodations as $accommodation) {
            $baseImageName = str_replace([' ', '\''], ['-', ''], strtolower($accommodation->name));
            
            for ($i = 1; $i <= 3; $i++) {
                AccommodationImage::create([
                    'accommodation_id' => $accommodation->id,
                    'image_path' => "accommodations/{$baseImageName}-{$i}.jpg", // Placeholder - you can add actual images later
                    'alt_text' => "{$accommodation->name} - Image {$i}",
                    'sort_order' => $i,
                    'is_featured' => $i === 1 // First image is featured
                ]);
            }
        }
        
        echo "Accommodation images seeded successfully!\n";
    }
}
