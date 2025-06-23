<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Accommodation;

class AccommodationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accommodations = [
            [
                'name' => 'Hotel Pramuka',
                'description' => 'Welcome to Hotel Pramuka, located on the beautiful Pramuka Island. Our hotel offers comfortable accommodations with stunning ocean views. Enjoy modern amenities while being surrounded by the natural beauty of the Thousand Islands. Perfect for families and couples looking for a peaceful island getaway.',
                'type' => 'hotel',
                'location' => 'Pulau Pramuka, Kepulauan Seribu',
                'rating' => 4.5,
                'capacity' => 4,
                'facilities' => ['AC', 'WiFi', 'Private Bathroom', 'Ocean View', 'Restaurant', 'Terrace'],
                'price_per_night' => 450000,
                'is_active' => true
            ],
            [
                'name' => 'Villa Sunset Pramuka',
                'description' => 'Experience luxury at Villa Sunset Pramuka, a premium accommodation offering spacious rooms and exclusive amenities. Located on the western side of the island, enjoy breathtaking sunset views from your private balcony. Features include a private beach area, outdoor pool, and personalized service.',
                'type' => 'villa',
                'location' => 'West Beach, Pulau Pramuka',
                'rating' => 4.8,
                'capacity' => 8,
                'facilities' => ['AC', 'WiFi', 'Private Pool', 'Kitchen', 'Beach Access', 'BBQ Area', 'Garden'],
                'price_per_night' => 850000,
                'is_active' => true
            ],
            [
                'name' => 'Guesthouse Bahari',
                'description' => 'Budget-friendly accommodation with a homely atmosphere. Guesthouse Bahari offers clean and comfortable rooms with basic amenities. Perfect for backpackers and budget travelers who want to explore the island without breaking the bank. Located near the village center for easy access to local attractions.',
                'type' => 'guesthouse',
                'location' => 'Village Center, Pulau Pramuka',
                'rating' => 4.2,
                'capacity' => 2,
                'facilities' => ['Fan', 'Shared Bathroom', 'WiFi', 'Common Area', 'Breakfast'],
                'price_per_night' => 180000,
                'is_active' => true
            ],
            [
                'name' => 'Resort Kepulauan Seribu',
                'description' => 'Luxury resort offering world-class amenities and services. Resort Kepulauan Seribu features multiple restaurants, spa services, water sports facilities, and beautifully landscaped grounds. Each room comes with premium furnishings and modern amenities for the ultimate tropical getaway experience.',
                'type' => 'resort',
                'location' => 'North Shore, Pulau Pramuka',
                'rating' => 4.9,
                'capacity' => 6,
                'facilities' => ['AC', 'WiFi', 'Spa', 'Multiple Restaurants', 'Pool', 'Water Sports', 'Concierge', 'Gym'],
                'price_per_night' => 1200000,
                'is_active' => true
            ],
            [
                'name' => 'Hotel Marina',
                'description' => 'Conveniently located near the harbor, Hotel Marina offers comfortable accommodation with easy access to boat transfers and island tours. Features modern rooms with harbor views, an on-site restaurant serving fresh seafood, and helpful staff to assist with your island adventures.',
                'type' => 'hotel',
                'location' => 'Harbor Area, Pulau Pramuka',
                'rating' => 4.3,
                'capacity' => 3,
                'facilities' => ['AC', 'WiFi', 'Harbor View', 'Restaurant', 'Tour Desk', 'Laundry'],
                'price_per_night' => 380000,
                'is_active' => true
            ],
            [
                'name' => 'Coral Villa',
                'description' => 'Beachfront villa with direct access to pristine coral reefs. Coral Villa is perfect for diving and snorkeling enthusiasts. The property features spacious rooms, a private beach, and equipment rental for water activities. Enjoy the tranquility of island life while being close to some of the best diving spots.',
                'type' => 'villa',
                'location' => 'East Beach, Pulau Pramuka',
                'rating' => 4.6,
                'capacity' => 6,
                'facilities' => ['AC', 'WiFi', 'Beach Access', 'Dive Equipment', 'Kitchen', 'Terrace', 'Snorkeling Gear'],
                'price_per_night' => 650000,
                'is_active' => true
            ],
            [
                'name' => 'Mangrove Lodge',
                'description' => 'Eco-friendly accommodation nestled among the mangroves. Mangrove Lodge offers a unique stay experience with nature-inspired design and sustainable practices. Perfect for eco-tourists and nature lovers who want to experience the islands biodiversity up close.',
                'type' => 'guesthouse',
                'location' => 'Mangrove Area, Pulau Pramuka',
                'rating' => 4.4,
                'capacity' => 4,
                'facilities' => ['Eco-Friendly', 'WiFi', 'Nature Tours', 'Bird Watching', 'Kayak Rental', 'Organic Meals'],
                'price_per_night' => 320000,
                'is_active' => true
            ]
        ];

        foreach ($accommodations as $accommodation) {
            Accommodation::create($accommodation);
        }
    }
}
