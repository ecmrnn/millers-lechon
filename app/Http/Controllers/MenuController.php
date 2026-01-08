<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MenuController extends Controller
{
    public function index() {
        $categories = Category::with('products')->get();
        
        // dd($categories->first()->products);
        return Inertia::render('site/Menu', [
            'categories' => $categories
        ]);
    }
}
