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
            TouristAttractionImageSeeder::class, 
            AccommodationSeeder::class,
            AccommodationImageSeeder::class, 
            BookingSeeder::class,
            ArticleSeeder::class,
            ArticleImageSeeder::class
        ]);
    }
}
