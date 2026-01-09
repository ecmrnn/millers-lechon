<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Freebie;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MenuController extends Controller
{
    public function index() {
        $categories = Category::with('products.category')->get();
        $highlight = Product::with('category')->whereName('lechon belly')->first();
        $freebies = Freebie::get();
        
        if (!$highlight) {
            $highlight = Product::with('category')->first();
        }

        return Inertia::render('site/Menu', [
            'categories' => $categories,
            'highlight' => $highlight,
            'freebies' => $freebies,
        ]);
    }
}
