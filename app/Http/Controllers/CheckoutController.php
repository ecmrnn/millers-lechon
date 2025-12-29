<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Services\CheckoutService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use PhpParser\Node\Stmt\TryCatch;

class CheckoutController extends Controller
{
    protected $checkoutService;

    public function __construct(CheckoutService $_checkoutService)
    {
        $this->checkoutService = $_checkoutService;
    }

    public function index(Request $request)
    {
        $request->validate([
            'shipping_mode' => 'required|enum:pickup,delivery',
            'cart_id' => 'required|exists:carts,id',
            'cart_items' => 'required|array|min:1',
        ]);

        // return Inertia::render('checkout/Index');
    }

    public function checkout(Request $request)
    {
        $validated = $request->validate([
            // Order details
            'cart_id' => 'required|exists:carts,id',
            'order_date' => 'required|date|after:today',
            'order_time' => 'required|string|date_format:H:i',
            'shipping_mode' => 'required|in:pickup,delivery',
            'note' => 'nullable|string|max:200',
            // Delivery address fields
            'deliver_street' => 'required_if:shipping_mode,delivery|string',
            'deliver_city' => 'required_if:shipping_mode,delivery|string',
            'deliver_province' => 'required_if:shipping_mode,delivery|string',
            // Payment and Transaction info
            'paid_amount' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $cart = Cart::findOrFail($validated['cart_id']);

        try {
            if (Auth::check() && Auth::user()->customer->id !== $cart->customer_id) {
                return response()->json([
                    'message' => 'Error 403: Unauthorized Action'
                ], 403);
            }
    
            $order = $this->checkoutService->checkout($cart, $validated);

            return response()->json(['order' => $order], 201);
        } catch (\Throwable $th) {
            Log::error("Checkout Error: " . $th->getMessage());

            return response()->json([
                'message' => 'Something went wrong during checkout. Please try again alter.'
                ], 500);
        }
    }
}
