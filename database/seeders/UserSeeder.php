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
            'name' => 'Site Administrator 1',
            'username' => 'Site Administrator 1',
            'email' => 'rlhwisatapramuka@gmail.com',
            'address' => 'Pulau Pramuka, Kepulauan Seribu Utara, Kabupaten Administrasi Kepulauan Seribu',
            'password' => Hash::make('g3R4k@nH1JaU#'),
            'is_admin' => true,
        ]);
    }
}
