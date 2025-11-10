<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::createOrFirst([
            'name' => 'Admin',
            'email' => 'admin@els.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
    }
}
