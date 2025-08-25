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
                'check_in_date' => now()->addDays(5),
                'check_out_date' => now()->addDays(8),
                'duration_days' => 3,
                'total_price' => 1500000.00,
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
                'check_in_date' => now()->subDays(3),
                'check_out_date' => now()->addDays(2),
                'duration_days' => 5,
                'total_price' => 3750000.00,
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
                'check_in_date' => now()->subDays(10),
                'check_out_date' => now()->subDays(8),
                'duration_days' => 2,
                'total_price' => 600000.00,
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
                'check_in_date' => now()->addDays(3),
                'check_out_date' => now()->addDays(7),
                'duration_days' => 4,
                'total_price' => 1800000.00,
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
                'check_in_date' => now()->addDays(7),
                'check_out_date' => now()->addDays(14),
                'duration_days' => 7,
                'total_price' => 2450000.00,
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
