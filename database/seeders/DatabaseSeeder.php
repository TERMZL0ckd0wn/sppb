<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'password' => Hash::make('admin123'),
                'plain_password' => Crypt::encryptString('admin123'),
                'level' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['username' => 'staff'],
            [
                'password' => Hash::make('staff123'),
                'plain_password' => Crypt::encryptString('staff123'),
                'level' => 'staff',
            ]
        );
    }
}
