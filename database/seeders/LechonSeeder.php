<?php

namespace Database\Seeders;

use App\Models\Lechon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LechonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lechons = collect([
            [
                'weight' => 10,
                'price' => 9000,
            ],
            [
                'weight' => 12,
                'price' => 11000,
            ],
            [
                'weight' => 15,
                'price' => 13000,
            ],
            [
                'weight' => 18,
                'price' => 16000,
            ],
            [
                'weight' => 20,
                'price' => 17000,
            ],
            [
                'weight' => 23,
                'price' => 19000,
            ],
            [
                'weight' => 25,
                'price' => 21000,
            ],
            [
                'weight' => 26,
                'price' => 23000,
            ],
        ]);

        $lechons->each(function ($lechon) {
            Lechon::create([
                'weight' => $lechon['weight'],
                'price' => $lechon['price'],
            ]);
        });
    }
}
