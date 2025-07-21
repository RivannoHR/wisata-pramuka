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
                'name' => 'Labirin Hutan Mangrove',
                'description' => 'Walk along the labyrinthine pathways above the shore, shaded by lush mangroves. Enjoy the sound of chirping birds and waves as they hit the roots of the mangrove trees.',
                'type' => 'tourist_spot',
                'location' => 'Eastern Side of Pulau Pramuka, Kepulauan Seribu',
                'rating' => 4.8,
                'operating_hours' => [
                    'monday' => '10:00 - 16:00',
                    'tuesday' => '10:00 - 16:00',
                    'wednesday' => '10:00 - 16:00',
                    'thursday' => '10:00 - 16:00',
                    'friday' => '10:00 - 16:00',
                    'saturday' => '09:00 - 18:00',
                    'sunday' => '09:00 - 18:00'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Hutan Eduwisata Rumah Literasi Hijau',
                'description' => 'Enrich yourself with the culture and history of Pulau Pramuka and participate in joyful and insightful activities with locals and fellow tourists.',
                'type' => 'tourist_spot',
                'location' => 'Hutan Eduwisata, Pulau Pramuka, Kepulauan Seribu',
                'rating' => 5.0,
                'operating_hours' => [
                    'monday' => 'Closed',
                    'tuesday' => '14:00 - 17:00',
                    'wednesday' => 'Closed',
                    'thursday' => 'Closed',
                    'friday' => 'Closed',
                    'saturday' => '08:00 - 13:00',
                    'sunday' => '18:00 - 21:00'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Pantai Sunrise',
                'description' => 'Be the witness of a majestic sunrise as the sun lights up the horizon and brightens up the vast blue sea.',
                'type' => 'tourist_spot',
                'location' => 'Eastern Side of Pulau Pramuka, Kepulauan Seribu',
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
            ],
            [
                'name' => 'Coral Education Center',
                'description' => 'Learn more about the beautiful corals that decorate our seas and oceans with a team of knowledgeable and enthusiastic experts.',
                'type' => 'tourist_spot',
                'location' => 'Western Side of Pulau Pramuka, Kepulauan Seribu',
                'rating' => 4.6,
                'operating_hours' => [
                    'monday' => '09:00 - 15:00',
                    'tuesday' => '09:00 - 15:00',
                    'wednesday' => '09:00 - 15:00',
                    'thursday' => '09:00 - 15:00',
                    'friday' => '09:00 - 15:00',
                    'saturday' => '08:00 - 12:00',
                    'sunday' => '08:00 - 12:00'
                ],
                'is_active' => true,
            ],

            // Restaurants
            [
                'name' => 'Resto Alam Nusantara',
                'description' => 'Indulge yourself with the various cuisines of Indonesia, ranging from simplicity like nasi goreng, to something rich in spice like rendang.',
                'type' => 'restaurant',
                'location' => 'Southern Beach, Pulau Pramuka, Kepulauan Seribu',
                'rating' => 4.9,
                'operating_hours' => [
                    'monday' => '09:00 - 18:00',
                    'tuesday' => '09:00 - 18:00',
                    'wednesday' => '09:00 - 18:00',
                    'thursday' => '09:00 - 18:00',
                    'friday' => '09:00 - 18:00',
                    'saturday' => '09:00 - 18:00',
                    'sunday' => '09:00 - 18:00'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Scuba Coffee',
                'description' => 'Energize yourself with various refreshing beverages and soothe your eyes with the sea view offered by this beachside cafe.',
                'type' => 'restaurant',
                'location' => 'Eastern Beach, Pulau Pramuka, Kepulauan Seribu',
                'rating' => 4.6,
                'operating_hours' => [
                    'monday' => '09:00 - 20:00',
                    'tuesday' => '09:00 - 20:00',
                    'wednesday' => '09:00 - 20:00',
                    'thursday' => '09:00 - 20:00',
                    'friday' => '09:00 - 20:00',
                    'saturday' => '09:00 - 20:00',
                    'sunday' => '09:00 - 20:00'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Warung Bu Rahma',
                'description' => 'Embrace the warmth of this local legendary traditional Indonesian restaurant as it serves plenty of delightful seafoods and appetizers.',
                'type' => 'restaurant',
                'location' => 'Western Beach, Pulau Pramuka, Kepulauan Seribu',
                'rating' => 4.8,
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
            ],

            // Shops
            [
                'name' => 'Coral Souvenir',
                'description' => 'Cherish your experiences and memories in Pulau Pramuka with various marine souvenirs offered by this store.',
                'type' => 'shop',
                'location' => 'Eastern Beach, Pulau Pramuka, Kepulauan Seribu',
                'rating' => 4.4,
                'operating_hours' => [
                    'monday' => '10:00 - 18:00',
                    'tuesday' => '10:00 - 18:00',
                    'wednesday' => '10:00 - 18:00',
                    'thursday' => '10:00 - 18:00',
                    'friday' => '10:00 - 18:00',
                    'saturday' => '10:00 - 18:00',
                    'sunday' => '10:00 - 18:00'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Toko Azura',
                'description' => 'As blue and tranquil as the sea. Purchase souvenirs from this store and bring the vast azure sea into your very home.',
                'type' => 'shop',
                'location' => 'Jl. Ikan Belong, Pulau Pramuka, Kepulauan Seribu',
                'rating' => 4.6,
                'operating_hours' => [
                    'monday' => '10:00 - 19:00',
                    'tuesday' => '10:00 - 19:00',
                    'wednesday' => '10:00 - 19:00',
                    'thursday' => '10:00 - 19:00',
                    'friday' => '10:00 - 19:00',
                    'saturday' => '10:00 - 19:00',
                    'sunday' => '10:00 - 19:00'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Toko Tepi Pantai',
                'description' => 'Satisfy your needs in this local convenience store, which provides items such as snacks, vacation essentials, and various souvenirs.',
                'type' => 'shop',
                'location' => 'Northern Beach, Pulau Pramuka, Kepulauan Seribu',
                'rating' => 4.5,
                'operating_hours' => [
                    'monday' => '09:00 - 19:00',
                    'tuesday' => '09:00 - 19:00',
                    'wednesday' => '09:00 - 19:00',
                    'thursday' => '09:00 - 19:00',
                    'friday' => '09:00 - 19:00',
                    'saturday' => '09:00 - 19:00',
                    'sunday' => '09:00 - 19:00'
                ],
                'is_active' => true,
            ],
        ];

        foreach ($attractions as $attractionData) {
            TouristAttraction::create($attractionData);
        }
    }
}
