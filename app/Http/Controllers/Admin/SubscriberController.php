<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Subscriber::latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email'     => ['required', 'email', 'unique:subscribers,email'],
            'name'      => ['nullable', 'string', 'max:255'],
            'is_active' => ['boolean'],
        ]);

        return response()->json(Subscriber::create($validated), 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subscriber $subscriber)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'unique:subscribers,email,' . $subscriber->id],
            'name'      => ['nullable', 'string', 'max:255'],
            'is_active' => ['boolean'],
        ]);

        $subscriber->update($validated);

        return response()->json($subscriber, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();

        return response()->json(['message' => 'Subscriber deleted.'], 204);
    }
}
