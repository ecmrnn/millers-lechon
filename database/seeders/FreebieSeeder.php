<?php

namespace Database\Seeders;

use App\Models\Freebie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FreebieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $freebies = [
            ['name' => 'Dinuguan'],
            ['name' => 'Adobong Laman-loob'],
            ['name' => 'Bopis'],
        ];

        foreach ($freebies as $freebie) {
            Freebie::create($freebie);
        }
    }
}
