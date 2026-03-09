<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admins = [
            [
                'name'     => 'Admin One',
                'email'    => 'admin1@taboc.edu.ph',  // ← change this
                'password' => Hash::make('TabocAdmin@1234'), // ← change this
            ],
            [
                'name'     => 'Admin Two',
                'email'    => 'admin2@taboc.edu.ph',  // ← change this
                'password' => Hash::make('TabocAdmin@5678'), // ← change this
            ],
        ];

        foreach ($admins as $admin) {
            User::updateOrCreate(
                ['email' => $admin['email']],  // match by email
                [
                    'name'              => $admin['name'],
                    'password'          => $admin['password'],
                    'email_verified_at' => now(),
                ]
            );

            $this->command->info('Admin created: ' . $admin['email']);
        }
    }
}