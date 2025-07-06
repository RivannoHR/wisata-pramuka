<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\User;
use App\Models\Accommodation;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users and accommodations
        $users = User::take(3)->get();
        $accommodations = Accommodation::take(3)->get();

        if ($users->isEmpty() || $accommodations->isEmpty()) {
            $this->command->info('Please run UserSeeder and AccommodationSeeder first');
            return;
        }

        $bookings = [
            // User 1 bookings
            [
                'booking_id' => 'BK0001',
                'user_id' => $users[0]->id,
                'accommodation_id' => $accommodations[0]->id,
                'room_type' => 'suite-master',
                'booking_date' => now()->addDays(5),
                'total_price' => 500000.00,
                'status' => 'pending',
                'notes' => null,
                'created_at' => now()->subDays(2),
            ],
            [
                'booking_id' => 'BK0002',
                'user_id' => $users[0]->id,
                'accommodation_id' => $accommodations[1]->id,
                'room_type' => 'deluxe',
                'booking_date' => now()->subDays(3),
                'total_price' => 750000.00,
                'status' => 'active',
                'notes' => null,
                'created_at' => now()->subDays(7),
            ],
            [
                'booking_id' => 'BK0003',
                'user_id' => $users[0]->id,
                'accommodation_id' => $accommodations[2]->id,
                'room_type' => 'standard',
                'booking_date' => now()->subDays(10),
                'total_price' => 300000.00,
                'status' => 'cancelled',
                'notes' => 'Cancelled due to weather conditions',
                'created_at' => now()->subDays(15),
            ],
            // User 2 bookings
            [
                'booking_id' => 'BK0004',
                'user_id' => $users[1]->id,
                'accommodation_id' => $accommodations[0]->id,
                'room_type' => 'deluxe',
                'booking_date' => now()->addDays(3),
                'total_price' => 450000.00,
                'status' => 'pending',
                'notes' => null,
                'created_at' => now()->subDays(1),
            ],
            [
                'booking_id' => 'BK0005',
                'user_id' => $users[1]->id,
                'accommodation_id' => $accommodations[1]->id,
                'room_type' => 'standard',
                'booking_date' => now()->addDays(7),
                'total_price' => 350000.00,
                'status' => 'active',
                'notes' => null,
                'created_at' => now()->subDays(5),
            ],
        ];

        foreach ($bookings as $booking) {
            Booking::create($booking);
        }

        $this->command->info('Sample bookings created successfully!');
    }
}
