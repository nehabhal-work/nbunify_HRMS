<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'email' => 'admin@els.com',
                'level' => 1,
                'name' => 'IT Dept 1',
                'password' => 'password',
            ],
            [
                'email' => 'admin2@els.com',
                'level' => 2,
                'name' => 'IT Dept 2',
                'password' => 'password',
            ],
            [
                'email' => 'admin3@els.com',
                'level' => 3,
                'name' => 'IT Dept 3',
                'password' => 'password',
            ],
            [
                'email' => 'sanjanajrcl@els.com',
                'level' => 1,
                'name' => 'Sanjana - JR CL',
                'password' => 'K8mN2pQ7xZ9v',
            ],
            [
                'email' => 'sulochana@els.com',
                'level' => 1,
                'name' => 'Sulochana - JR CR',
                'password' => 'R5tY8uI3oP1a',
            ],
            [
                'email' => 'sanjanam@els.com',
                'level' => 1,
                'name' => 'Sanjana M - SR CR',
                'password' => 'L9wE6rT4yU2i',
            ],
            [
                'email' => 'sulochanab@els.com',
                'level' => 1,
                'name' => 'Sulochana B - SR CR',
                'password' => 'M3nB7vC1xZ5k',
            ],
            [
                'email' => 'mandar@els.com',
                'level' => 2,
                'name' => 'Mandar - Supervisor',
                'password' => 'Q6hJ9gF2dS8a',
            ],
            [
                'email' => 'mandard@els.com',
                'level' => 2,
                'name' => 'Mandard - JR Officer',
                'password' => 'P4kL7mN0bV3c',
            ],
            [
                'email' => 'mandark@els.com',
                'level' => 3,
                'name' => 'Mandark - SR Officer',
                'password' => 'X8zA5sD2fG9h',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate([
                'email' => $user['email']
            ], [
                'level' => $user['level'],
                'name' => $user['name'],
                'password' => Hash::make($user['password']),
                'email_verified_at' => now(),
            ]);
        }
    }
}
