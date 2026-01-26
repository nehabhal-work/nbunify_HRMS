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
                'email' => 'dataentry@els.com',
                'level' => 1,
                'name' => 'IT Dept 1',
                'password' => 'password',
                'role' => 'data-entry'
            ],
            [
                'email' => 'dataentr2@els.com',
                'level' => 1,
                'name' => 'IT Dept 1',
                'password' => 'password',
                'role' => 'data-entry'
            ],
            [
                'email' => 'accounts@els.com',
                'level' => 1,
                'name' => 'IT Dept - Accounts',
                'password' => 'password',
                'role' => 'accountant'
            ],
            [
                'email' => 'manager@els.com',
                'level' => 2,
                'name' => 'IT Dept 2',
                'password' => 'password',
                'role' => 'manager'
            ],
            [
                'email' => 'admin@els.com',
                'level' => 3,
                'name' => 'IT Dept 3',
                'password' => 'password',
                'role' => 'admin'
            ],
            [
                'email' => 'superadmin@els.com',
                'level' => 3,
                'name' => 'IT Dept 3',
                'password' => 'password',
                'role' => 'super-admin'
            ],
            [
                'email' => 'sanjanajrcl@els.com',
                'level' => 1,
                'name' => 'Sanjana - JR CL',
                'password' => 'K8mN2pQ7xZ9v',
                'role' => 'data-entry'
            ],
            [
                'email' => 'sulochana@els.com',
                'level' => 1,
                'name' => 'Sulochana - JR CR',
                'password' => 'R5tY8uI3oP1a',
                'role' => 'data-entry'
            ],
            [
                'email' => 'sanjanam@els.com',
                'level' => 1,
                'name' => 'Sanjana M - SR CR',
                'password' => 'L9wE6rT4yU2i',
                'role' => 'data-entry'
            ],
            [
                'email' => 'sulochanab@els.com',
                'level' => 1,
                'name' => 'Sulochana B - SR CR',
                'password' => 'M3nB7vC1xZ5k',
                'role' => 'data-entry'
            ],
            [
                'email' => 'mandar@els.com',
                'level' => 2,
                'name' => 'Mandar - Supervisor',
                'password' => 'Q6hJ9gF2dS8a',
                'role' => 'manager'
            ],
            [
                'email' => 'mandard@els.com',
                'level' => 2,
                'name' => 'Mandard - JR Officer',
                'password' => 'P4kL7mN0bV3c',
                'role' => 'manager'
            ],
            [
                'email' => 'mandark@els.com',
                'level' => 3,
                'name' => 'Mandark - SR Officer',
                'password' => 'X8zA5sD2fG9h',
                'role' => 'admin'
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
