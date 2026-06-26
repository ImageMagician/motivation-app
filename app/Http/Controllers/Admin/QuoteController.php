<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Quote::latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'body'  => ['required', 'string', 'max:500'],
            'author' => ['required', 'string', 'max:255'],
        ]);

        return response()->json(Quote::create($validated), 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quote $quote)
    {
        $validated = $request->validate([
            'body'  => ['required', 'string', 'max:500'],
            'author' => ['required', 'string', 'max:255'],
        ]);

        $quote->update($validated);

        return response()->json($quote);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quote $quote)
    {
        $quote->delete();

        return response()->json(['message'=>"Quote deleted"], 204);
    }
}
