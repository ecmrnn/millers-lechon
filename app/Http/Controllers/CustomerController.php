<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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

    public function register(Request $request) {
        $validated = $request->validate([
            'email' => 'unique:users,email|required|email',
            'password' => 'required|min:8',
            'first_name' => 'required|min:2|string',
            'last_name' => 'required|min:2|string',
            'phone_number' => 'nullable|string|min:11',
            'street' => 'nullable|string',
            'city' => 'nullable|string',
            'province' => 'nullable|string',
        ]);

        return DB::transaction(function () use ($validated) {
            $user = User::create([
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            $customer = $user->customer()->create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'phone_number' => $validated['phone_number'] ?? null,
                'email' => $validated['email'],
                'street' => $validated['street'] ?? null,
                'city' => $validated['city'] ?? null,
                'province' => $validated['province'] ?? null,
            ]);

            return response()->json($customer, 201);
        });
    }
}
