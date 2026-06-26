<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;

class SubscriberController extends Controller
{
    public function store (Request $request) {
        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'unique:subscribers,email'],
        ]);

        Subscriber::create($validated);

        return response()->json([
            'message' => 'Thank you for subscribing! You will receive your first email tomorrow morning.'
        ], 201);
    }
}
