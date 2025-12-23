<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return Inertia::render('cart/Index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function addItem(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|min:1',
            'weight' => 'nullable|integer',
            'freebie_id' => 'nullable|exists:freebies,id',
        ]);
        
        $this->cartService->addItem(
            $validated['product_id'],
            $validated['quantity'],  
            $validated['weight'],
            $validated['freebie_id'] 
        );
    }
}
