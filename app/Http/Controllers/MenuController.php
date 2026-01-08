<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MenuController extends Controller
{
    public function index() {
        $categories = Category::with('products')->get();
        $highlight = Product::whereName('lechon belly')->first();
        
        if (!$highlight) {
            $highlight = Product::first();
        }

        return Inertia::render('site/Menu', [
            'categories' => $categories,
            'highlight' => $highlight,
        ]);
    }
}
