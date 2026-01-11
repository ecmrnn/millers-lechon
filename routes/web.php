<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PageController;
use App\Models\Cart;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', [PageController::class, 'welcome'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/menu', [MenuController::class, 'index'])->name('menu');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    
    Route::resource('customers', CustomerController::class);
});

Route::post('customers/register', [CustomerController::class, 'register'])->name('customers.register');
Route::group(['prefix' => 'cart'], function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add-item', [CartController::class, 'addItem'])->name('cart.addItem');
    Route::post('/remove-item', [CartController::class, 'removeItem'])->name('cart.removeItem');
    Route::post('/clear', [CartController::class, 'clear'])->name('cart.clear');
});

Route::get('/api/cart', function () {
    $cart = Cart::with('items')->where('session_id', Session::id())->firstOrFail();

    return response()->json($cart, 200);
});

require __DIR__.'/settings.php';
