<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'email' => 'admin@hrms.com',
                'level' => 1,
                'name' => 'IT Dept 1',
                'password' => 'password',
                'role' => 'data-entry'
            ],

        ];

        foreach ($users as $userData) {
            $user = User::updateOrCreate([
                'email' => $userData['email']
            ], [
                'level' => $userData['level'],
                'name' => $userData['name'],
                'password' => Hash::make($userData['password']),
                'email_verified_at' => now(),
            ]);

            // Assign role
            $role = Role::where('slug', $userData['role'])->first();
            if ($role) {
                $user->roles()->sync([$role->id]);
            }
        }
    }
}
