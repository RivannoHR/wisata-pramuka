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
            AccommodationSeeder::class,
            BookingSeeder::class,
        ]);
    }
}
