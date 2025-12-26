<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $_cartService)
    {
        $this->cartService = $_cartService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return Inertia::render('cart/Index');
    }

    public function addItem(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|min:1',
            'weight' => 'nullable|integer',
            'freebie_id' => 'nullable|exists:freebies,id',
        ]);

        $cart = $this->cartService->addItem(
            $validated['product_id'],
            $validated['quantity'],  
            $validated['weight'],
            $validated['freebie_id'] 
        );

        return response()->json(['cart' => $cart], 201);
    }

    public function removeItem(Request $request)
    {
        $validated = $request->validate([
            'cart_item_id' => 'exists:cart_items,id|required'
        ]);

        $cart = $this->cartService->removeItem($validated['cart_item_id']);

        return response()->json(['cart' => $cart], 200);
    }

    public function clear(Request $request) {
        $cart = $this->cartService->removeAllItems();

        return response()->json(['cart' => $cart], 200);
    }
}
