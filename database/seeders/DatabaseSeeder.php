<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin account
        User::create([
            'name' => 'Ec Maranan',
            'email' => 'admin@test.com',
            'password' => 'admin123',
        ]);

        $this->call([
            LechonSeeder::class,
            FreebieSeeder::class,
        ]);
    }
}
