<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $_cartService)
    {
        $this->cartService = $_cartService;
    }
    
    public function index()
    {
        $cart = $this->cartService->getCart();
        $totalSum = 0;

        foreach ($cart->items as $item) {
            $totalSum += ($item->quantity * $item->price * ($item->weight ? $item->weight : 1));
        }

        // Calculate delivery costs
        $deliveryCost = 0;

        return Inertia::render('site/Cart', [
            'cart' => $cart,
            'totalSum' => $totalSum,
            'deliveryCost' => $deliveryCost,
        ]);
    }

    public function addItem(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|min:1',
            'weight' => 'nullable|integer|min:1',
            'freebie_id' => 'nullable|exists:freebies,id',
        ]);

        $product = Product::find($validated['product_id']);
        $productName = $product->name;

        if ($product->category->has_freebies && $validated['freebie_id'] === null) {
            $request->validate(['freebie_id' => 'required']);
        }

        $this->cartService->addItem(
            $validated['product_id'],
            $validated['quantity'],  
            $validated['weight'] ?? 0,
            $validated['freebie_id'] ?? null
        );

        return back()->with('success', "$productName added to cart!");
    }

    public function removeItem(Request $request)
    {
        $validated = $request->validate([
            'cart_item_id' => 'exists:cart_items,id|required'
        ]);

        $cartItem = CartItem::find($validated['cart_item_id']);
        $productName = $cartItem->product->name;

        $this->cartService->removeItem($validated['cart_item_id']);

        return back()->with('success', "$productName removed from cart!");
    }

    public function clear(Request $request) {
        $this->cartService->removeAllItems();

        return back()->with('success', 'All items removed from cart!');
    }
}
