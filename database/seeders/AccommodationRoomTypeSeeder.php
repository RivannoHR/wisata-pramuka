<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AccommodationRoomType;
use Illuminate\Support\Facades\DB;

class AccommodationRoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('accommodation_room_types')->truncate();

        $rooms = [];
        for ($i = 1; $i <= 10; $i++) {
            $rooms[] = [
                'accommodation_id' => $i,
                'name' => 'AC' . $i . '-room',
                'image_path' => 'accommodations/' . $i . '/rooms/sample-room-image.png',
                'price' => $i * 1000, 
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        AccommodationRoomType::insert($rooms);
    }
}
