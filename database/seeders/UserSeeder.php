<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Membuat admin pertama
        user::create([
            'first_name' => 'jonn',
            'last_name' => 'udin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('admin'),
            'role' => 'admin',
        ]);

        // Membuat admin kedua
        User::create([
            'first_name' => 'budi',
            'last_name' => 'santoso',
            'email' => 'user@mail.com',
            'password' => Hash::make('user'),
            'role' => 'user',

        ]);
    }
}
