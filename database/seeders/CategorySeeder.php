<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Lechon Fiesta',
                'description' => 'For Large Occassions',
            ],
            [
                'name' => 'Lechon Familia',
                'description' => 'For Family/Any Occassions',
            ],
            [
                'name' => 'Food Trays',
                'description' => 'Perfect Pair For Lechon',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
