<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AccommodationRoomType;

class AccommodationRoomTypeSeeder extends Seeder
{
    public function run(): void
    {
        $roomTypes = [
            [
                'accommodation_id' => 1,
                'name' => 'king room',
                'image_path' => 'products/Sabun-minyak-jelantah.png',
                'price' => 1000,
            ],
            [
                'accommodation_id' => 2,
                'name' => 'normal room',
                'image_path' => 'products/Sabun-minyak-jelantah.png',
                'price' => 1000,
            ],
            [
                'accommodation_id' => 1,
                'name' => 'bath room  (sigma)',
                'image_path' => 'products/Sabun-minyak-jelantah.png',
                'price' => 1000,
            ],
        ];
        foreach ($roomTypes as $roomType) {
            AccommodationRoomType::create($roomType);
        }
    }
}
