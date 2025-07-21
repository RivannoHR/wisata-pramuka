<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Regular User - Kevin
        User::create([
            'name' => 'Kevin',
            'username' => 'Kevin727',
            'email' => 'kevinaja@gmail.com',
            'address' => 'Jl. Tanjung Duren Utara, Kec. Grogol Petamburan, Kota Jakarta Barat',
            'password' => Hash::make('TestPassword'),
            'is_admin' => false,
        ]);

        // Admin User - Dewi Santika Citra Lesmana
        User::create([
            'name' => 'Dewi Santika Citra Lesmana',
            'username' => 'Site Administrator 1',
            'email' => 'rumahliterasihijau@yahoo.com',
            'address' => 'Pulau Pramuka, Kepulauan Seribu Utara, Kabupaten Administrasi Kepulauan Seribu',
            'password' => Hash::make('pulaupramuka'),
            'is_admin' => true,
        ]);
    }
}
