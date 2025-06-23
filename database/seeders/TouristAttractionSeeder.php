<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TouristAttraction;
use App\Models\TouristAttractionImage;

class TouristAttractionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $attractions = [
            // Tourist Spots
            [
                'name' => 'Pantai Pramuka',
                'description' => 'Beautiful white sand beach perfect for swimming, snorkeling, and enjoying stunning sunset views. The crystal-clear waters offer excellent visibility for underwater activities, making it a paradise for marine life enthusiasts.',
                'type' => 'tourist_spot',
                'location' => 'Pulau Pramuka, Kepulauan Seribu',
                'rating' => 4.5,
                'operating_hours' => [
                    'monday' => '24 hours',
                    'tuesday' => '24 hours',
                    'wednesday' => '24 hours',
                    'thursday' => '24 hours',
                    'friday' => '24 hours',
                    'saturday' => '24 hours',
                    'sunday' => '24 hours'
                ],
                'is_active' => true,
                'images' => [
                    ['image_path' => 'attractions/pantai-pramuka-1.jpg', 'alt_text' => 'Pantai Pramuka main beach view', 'is_featured' => true, 'sort_order' => 1],
                    ['image_path' => 'attractions/pantai-pramuka-2.jpg', 'alt_text' => 'Crystal clear waters at Pantai Pramuka', 'is_featured' => false, 'sort_order' => 2],
                    ['image_path' => 'attractions/pantai-pramuka-3.jpg', 'alt_text' => 'Sunset view at Pantai Pramuka', 'is_featured' => false, 'sort_order' => 3],
                ]
            ],
            [
                'name' => 'Penangkaran Penyu',
                'description' => 'Sea turtle conservation center where visitors can learn about marine conservation efforts and witness baby turtle releases. Educational programs available for groups and families.',
                'type' => 'tourist_spot',
                'location' => 'Pulau Pramuka Conservation Area',
                'rating' => 4.8,
                'operating_hours' => [
                    'monday' => '08:00 - 17:00',
                    'tuesday' => '08:00 - 17:00',
                    'wednesday' => '08:00 - 17:00',
                    'thursday' => '08:00 - 17:00',
                    'friday' => '08:00 - 17:00',
                    'saturday' => '08:00 - 17:00',
                    'sunday' => '08:00 - 17:00'
                ],
                'is_active' => true,
                'images' => [
                    ['image_path' => 'attractions/penangkaran-penyu-1.jpg', 'alt_text' => 'Sea turtle conservation center', 'is_featured' => true, 'sort_order' => 1],
                    ['image_path' => 'attractions/penangkaran-penyu-2.jpg', 'alt_text' => 'Baby sea turtles', 'is_featured' => false, 'sort_order' => 2],
                ]
            ],
            [
                'name' => 'Mangrove Forest Trail',
                'description' => 'Explore the natural mangrove ecosystem through wooden walkways. Perfect for bird watching and learning about coastal ecology. Guided tours available with local experts.',
                'type' => 'tourist_spot',
                'location' => 'East Side of Pulau Pramuka',
                'rating' => 4.3,
                'operating_hours' => [
                    'monday' => '06:00 - 18:00',
                    'tuesday' => '06:00 - 18:00',
                    'wednesday' => '06:00 - 18:00',
                    'thursday' => '06:00 - 18:00',
                    'friday' => '06:00 - 18:00',
                    'saturday' => '06:00 - 18:00',
                    'sunday' => '06:00 - 18:00'
                ],
                'is_active' => true,
                'images' => [
                    ['image_path' => 'attractions/mangrove-1.jpg', 'alt_text' => 'Mangrove forest walkway', 'is_featured' => true, 'sort_order' => 1],
                    ['image_path' => 'attractions/mangrove-2.jpg', 'alt_text' => 'Mangrove ecosystem', 'is_featured' => false, 'sort_order' => 2],
                    ['image_path' => 'attractions/mangrove-3.jpg', 'alt_text' => 'Bird watching in mangroves', 'is_featured' => false, 'sort_order' => 3],
                ]
            ],

            // Restaurants
            [
                'name' => 'Restoran Pramuka',
                'description' => 'Traditional Indonesian seafood restaurant serving fresh catch of the day. Specializes in grilled fish, calamari, and local island delicacies. Ocean view dining experience.',
                'type' => 'restaurant',
                'location' => 'Main Street, Pulau Pramuka',
                'rating' => 4.4,
                'operating_hours' => [
                    'monday' => '06:00 - 22:00',
                    'tuesday' => '06:00 - 22:00',
                    'wednesday' => '06:00 - 22:00',
                    'thursday' => '06:00 - 22:00',
                    'friday' => '06:00 - 22:00',
                    'saturday' => '06:00 - 22:00',
                    'sunday' => '06:00 - 22:00'
                ],
                'is_active' => true,
                'images' => [
                    ['image_path' => 'attractions/restoran-pramuka-1.jpg', 'alt_text' => 'Restaurant exterior with ocean view', 'is_featured' => true, 'sort_order' => 1],
                    ['image_path' => 'attractions/restoran-pramuka-2.jpg', 'alt_text' => 'Fresh seafood dishes', 'is_featured' => false, 'sort_order' => 2],
                ]
            ],
            [
                'name' => 'Warung Sunset',
                'description' => 'Casual beachside cafe offering Indonesian comfort food and refreshing drinks. Perfect spot to enjoy the sunset while savoring local snacks and fresh coconut water.',
                'type' => 'restaurant',
                'location' => 'West Beach, Pulau Pramuka',
                'rating' => 4.2,
                'operating_hours' => [
                    'monday' => '10:00 - 21:00',
                    'tuesday' => '10:00 - 21:00',
                    'wednesday' => '10:00 - 21:00',
                    'thursday' => '10:00 - 21:00',
                    'friday' => '10:00 - 21:00',
                    'saturday' => '10:00 - 21:00',
                    'sunday' => '10:00 - 21:00'
                ],
                'is_active' => true,
                'images' => [
                    ['image_path' => 'attractions/warung-sunset-1.jpg', 'alt_text' => 'Beachside dining area', 'is_featured' => true, 'sort_order' => 1],
                    ['image_path' => 'attractions/warung-sunset-2.jpg', 'alt_text' => 'Sunset view from warung', 'is_featured' => false, 'sort_order' => 2],
                ]
            ],

            // Shops
            [
                'name' => 'Toko Pramuka',
                'description' => 'Local convenience store offering island essentials, snorkeling gear, souvenirs, and handmade crafts. One-stop shop for all your island adventure needs.',
                'type' => 'shop',
                'location' => 'Village Center, Pulau Pramuka',
                'rating' => 4.0,
                'operating_hours' => [
                    'monday' => '07:00 - 21:00',
                    'tuesday' => '07:00 - 21:00',
                    'wednesday' => '07:00 - 21:00',
                    'thursday' => '07:00 - 21:00',
                    'friday' => '07:00 - 21:00',
                    'saturday' => '07:00 - 21:00',
                    'sunday' => '07:00 - 21:00'
                ],
                'is_active' => true,
                'images' => [
                    ['image_path' => 'attractions/toko-pramuka-1.jpg', 'alt_text' => 'Store front view', 'is_featured' => true, 'sort_order' => 1],
                ]
            ],
            [
                'name' => 'Souvenir Corner',
                'description' => 'Authentic local handicrafts and souvenirs made by island artisans. Features shell jewelry, woven bags, local paintings, and traditional Indonesian gifts.',
                'type' => 'shop',
                'location' => 'Near Harbor, Pulau Pramuka',
                'rating' => 4.1,
                'operating_hours' => [
                    'monday' => '08:00 - 20:00',
                    'tuesday' => '08:00 - 20:00',
                    'wednesday' => '08:00 - 20:00',
                    'thursday' => '08:00 - 20:00',
                    'friday' => '08:00 - 20:00',
                    'saturday' => '08:00 - 20:00',
                    'sunday' => '08:00 - 20:00'
                ],
                'is_active' => true,
                'images' => [
                    ['image_path' => 'attractions/souvenir-corner-1.jpg', 'alt_text' => 'Handmade crafts display', 'is_featured' => true, 'sort_order' => 1],
                    ['image_path' => 'attractions/souvenir-corner-2.jpg', 'alt_text' => 'Local artisan at work', 'is_featured' => false, 'sort_order' => 2],
                ]
            ]
        ];

        foreach ($attractions as $attractionData) {
            $images = $attractionData['images'] ?? [];
            unset($attractionData['images']);
            
            $attraction = TouristAttraction::create($attractionData);
            
            // Create images for this attraction
            foreach ($images as $imageData) {
                $imageData['tourist_attraction_id'] = $attraction->id;
                TouristAttractionImage::create($imageData);
            }
        }
    }
}
