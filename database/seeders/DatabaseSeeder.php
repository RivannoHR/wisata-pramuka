<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ProductSeeder::class,
            TouristAttractionSeeder::class,
            TouristAttractionImageSeeder::class, // Add this to seed tourist attraction images
            AccommodationSeeder::class,
            AccommodationImageSeeder::class, // Add this to seed accommodation images
            BookingSeeder::class,
        ]);
    }
}
