<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Accommodation;

class AccommodationSeeder extends Seeder
{

    public function run(): void
    {
        $accommodations = [
            [
                'name' => 'Dermaga Resort',
                'description' => 'Strategic hotel situated near the island\'s port, hospital, restaurants, and tourist attractions. Contains plenty of cozy rooms, free WiFi, breakfast, and various other services.',
                'type' => 'hotel',
                'location' => 'Village Center, Pulau Pramuka, Kepulauan Seribu',
                'rating' => 4.6,
                'capacity' => 4,
                'price' => 750000,
                'facilities' => ['WiFi', 'Breakfast', 'Free Parking', 'AC', 'Beach Access', 'Laundry Service', 'Restaurant', 'Kid-friendly'],
                'is_active' => true
            ],
            [
                'name' => 'Seribu Resort Thousand Island',
                'description' => 'Premium resort offering luxury accommodations with stunning ocean views and modern amenities. Perfect for romantic getaways and family vacations.',
                'type' => 'resort',
                'location' => 'Beachfront, Pulau Pramuka, Kepulauan Seribu',
                'rating' => 4.8,
                'capacity' => 6,
                'price' => 1200000,
                'facilities' => ['WiFi', 'Breakfast', 'Pool', 'AC', 'Beach Access', 'Spa', 'Restaurant', 'Bar', 'Water Sports'],
                'is_active' => true
            ],
            [
                'name' => 'Villa Delima',
                'description' => 'Charming villa with traditional Indonesian architecture and modern comforts. Spacious rooms with garden views and peaceful atmosphere.',
                'type' => 'villa',
                'location' => 'Garden District, Pulau Pramuka, Kepulauan Seribu',
                'rating' => 4.3,
                'capacity' => 8,
                'price' => 950000,
                'facilities' => ['WiFi', 'Kitchen', 'Garden', 'AC', 'Private Pool', 'BBQ Area', 'Parking'],
                'is_active' => true
            ],
            [
                'name' => 'Penginapan Permata',
                'description' => 'Budget-friendly accommodation with clean, comfortable rooms and friendly service. Great value for money with essential amenities.',
                'type' => 'guesthouse',
                'location' => 'Central Area, Pulau Pramuka, Kepulauan Seribu',
                'rating' => 4.1,
                'capacity' => 3,
                'price' => 450000,
                'facilities' => ['WiFi', 'AC', 'Shared Kitchen', 'Laundry Service', 'Parking'],
                'is_active' => true
            ],
            [
                'name' => 'Royal Mermaid',
                'description' => 'Elegant beachfront hotel with nautical-themed decor and excellent service. Features spacious rooms with ocean views and modern amenities.',
                'type' => 'hotel',
                'location' => 'Beachfront, Pulau Pramuka, Kepulauan Seribu',
                'rating' => 4.5,
                'capacity' => 5,
                'price' => 850000,
                'facilities' => ['WiFi', 'Breakfast', 'AC', 'Beach Access', 'Restaurant', 'Room Service', 'Concierge'],
                'is_active' => true
            ],
            [
                'name' => 'Homestay Kedaton',
                'description' => 'Cozy family-run homestay offering authentic local experience with warm hospitality. Perfect for travelers seeking cultural immersion.',
                'type' => 'homestay',
                'location' => 'Residential Area, Pulau Pramuka, Kepulauan Seribu',
                'rating' => 4.2,
                'capacity' => 4,
                'price' => 300000,
                'facilities' => ['WiFi', 'Shared Kitchen', 'Fan', 'Laundry Service', 'Local Tours'],
                'is_active' => true
            ],
            [
                'name' => 'Homestay Sunrise',
                'description' => 'Peaceful homestay with beautiful sunrise views from the terrace. Simple but comfortable accommodations with friendly hosts.',
                'type' => 'homestay',
                'location' => 'East Coast, Pulau Pramuka, Kepulauan Seribu',
                'rating' => 4.0,
                'capacity' => 3,
                'price' => 250000,
                'facilities' => ['WiFi', 'Shared Kitchen', 'Terrace', 'Fan', 'Bicycle Rental'],
                'is_active' => true
            ],
            [
                'name' => 'Homestay Alex',
                'description' => 'Modern homestay with clean facilities and helpful staff. Located in a quiet neighborhood with easy access to attractions.',
                'type' => 'homestay',
                'location' => 'Quiet Street, Pulau Pramuka, Kepulauan Seribu',
                'rating' => 4.3,
                'capacity' => 4,
                'price' => 350000,
                'facilities' => ['WiFi', 'AC', 'Shared Kitchen', 'Parking', 'Laundry Service'],
                'is_active' => true
            ],
            [
                'name' => 'Homestay Haris',
                'description' => 'Traditional homestay offering genuine local hospitality and home-cooked meals. Experience island life with a local family.',
                'type' => 'homestay',
                'location' => 'Traditional Village, Pulau Pramuka, Kepulauan Seribu',
                'rating' => 4.1,
                'capacity' => 3,
                'price' => 280000,
                'facilities' => ['WiFi', 'Home-cooked Meals', 'Fan', 'Cultural Experience', 'Fishing Tours'],
                'is_active' => true
            ],
            [
                'name' => 'Dolphin\'s Villa',
                'description' => 'Cozy villa with an astounding sea view. Comfortable and affordable, perfect for tourists who\'d like to relax by the sea after an eventful day. Complete with an outdoor swimming pool, free WiFi, a restaurant & bar, and much more.',
                'type' => 'villa',
                'location' => 'Southeastern Beach, Pulau Pramuka, Kepulauan Seribu',
                'rating' => 4.2,
                'capacity' => 4,
                'price' => 800000,
                'facilities' => ['WiFi', 'Swimming Pool', 'Restaurant & Bar', 'AC', 'Beach Access', 'Souvenir Shop'],
                'is_active' => true
            ]
        ];

        foreach ($accommodations as $accommodation) {
            Accommodation::create($accommodation);
        }
    }
}
