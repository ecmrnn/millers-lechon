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
        $freebies = collect([
            [
                'name' => 'Dinuguan',
            ],
            [
                'name' => 'Adobong Tarapilya',
            ],
        ]);

        $freebies->each(function ($freebie) {
            Freebie::create($freebie);
        });
    }
}
