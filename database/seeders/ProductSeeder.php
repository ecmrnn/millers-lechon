<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lechonFiestaProducts = [
            [
                'name' => 'Lechon 10kg.',
                'description' => 'Our small, classic whole roast. Provides generous servings for 40 to 50 guests, perfect for intimate family celebrations and gatherings. (Cooked Weight: 10kg)',
                'price' => 9000,
            ],
            [
                'name' => 'Lechon 12kg.',
                'description' => 'Ideal for mid-sized events. Guaranteed crisp skin and juicy meat, serving 50 to 60 people with ease. A popular choice for anniversaries. (Cooked Weight: 12kg)',
                'price' => 11000,
            ],
            [
                'name' => 'Lechon 15kg.',
                'description' => 'A substantial feast that comfortably serves 60 to 70 guests. Great value for larger birthdays or reunions. (Cooked Weight: 15kg)',
                'price' => 13000,
            ],
            [
                'name' => 'Lechon 18kg.',
                'description' => 'Excellent choice for bigger parties, accommodating 70 to 90 guests. Our traditional roast prepared with signature spices. (Cooked Weight: 18kg)',
                'price' => 16000,
            ],
            [
                'name' => 'Lechon 20kg.',
                'description' => 'The true party starter! Serves between 90 to 100 people. Order this size to receive a complimentary Dinuguan or Adobong Tarapilya. (Cooked Weight: 20kg)',
                'price' => 17000,
            ],
            [
                'name' => 'Lechon 23kg.',
                'description' => 'Ready for a major event, easily satisfying 100 to 120 guests. Provides maximum visual impact and superior flavor. (Cooked Weight: 23kg)',
                'price' => 19000,
            ],
            [
                'name' => 'Lechon 25kg.',
                'description' => 'A massive roast capable of feeding 120 to 150 people. The perfect centerpiece for weddings, fiestas, and company events. (Cooked Weight: 25kg)',
                'price' => 21000,
            ],
            [
                'name' => 'Lechon 26kg.+',
                'description' => 'Our largest offering, serving 150 to 200+ guests. Ideal for grand celebrations. Contact us for custom quotes on even larger roasts. (Cooked Weight: 26kg+)',
                'price' => 23000,
            ],
        ];

        $lechonFamilia = [
            [
                'name' => 'lechon tilad',
                'description' => 'The perfect serving of our crispy-skinned, savory roast, already chopped and ready to eat. Ideal for small, casual gatherings of 8–10 people.',
                'price' => 1000,
                'unit_type' => 'kg'
            ],
            [
                'name' => 'lechon belly',
                'description' => 'Boneless and rolled with special herbs and spices for maximum flavor and easy carving. A decadent, presentation-ready centerpiece that serves 10–15 guests.',
                'price' => 1000,
                'unit_type' => 'kg'
            ],
            [
                'name' => 'lechon head',
                'description' => 'The crispiest part of the whole roast, often used for celebratory presentations. Includes the head and collar, providing rich meat and ultra-crisp skin. Best for small groups of 4–6.',
                'price' => 700,
                'unit_type' => 'kg'
            ],
        ];

        $foodTrays = [
            [
                'name' => 'menudo',
                'description' => 'Traditional Filipino pork stew slow-cooked in a rich tomato-based sauce with savory chorizo, tender potatoes, and carrots. A delicious and classic side dish.',
                'price' => 1000,
            ],
            [
                'name' => 'pancit bihon',
                'description' => 'Stir-fried thin rice noodles mixed with fresh vegetables, pork, shrimp, and chicken. Cooked to perfection and ideal for any celebration.',
                'price' => 1000,
            ],
            [
                'name' => 'bopis',
                'description' => 'A flavorful, spicy Filipino dish made from minced pork lung and heart, sautéed with onions, peppers, and vinegar. A guaranteed favorite for those who love bold flavors.',
                'price' => 1000,
            ],
        ];

        foreach ($lechonFiestaProducts as $product) {
            $category = Category::whereName('Lechon Fiesta')->first();
            
            if (!empty($category)) {
                $category->products()->create($product);
            }
        }

        foreach ($lechonFamilia as $product) {
            $category = Category::whereName('Lechon Familia')->first();
            if (!empty($category)) {
                $category->products()->create($product);
            }
        }

        foreach ($foodTrays as $product) {
            $category = Category::whereName('Food Trays')->first();

            if (!empty($category)) {
                $category->products()->create($product);
            }
        }
    }
}
