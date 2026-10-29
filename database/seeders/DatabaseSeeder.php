<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@telecalling.com'],
            [
                'name' => 'System Admin',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
                'phone' => '9876543210',
            ]
        );

        User::updateOrCreate(
            ['email' => 'telecaller@telecalling.com'],
            [
                'name' => 'Demo Telecaller',
                'password' => bcrypt('telecaller123'),
                'role' => 'user',
                'phone' => '9123456780',
            ]
        );
    }
}
