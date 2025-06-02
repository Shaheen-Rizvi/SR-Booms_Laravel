<?php

namespace App\Http\Controllers;

use App\Models\Flower;
use App\Http\Resources\FlowerResource;
use Illuminate\Http\Request;

class FlowerController extends Controller
{
    /**
     * Display a listing of flowers.
     */
    public function index()
    {
        $flowers = Flower::with('category')->paginate(10);
        return FlowerResource::collection($flowers);
    }

    /**
     * Store a newly created flower.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'color' => 'required|string|max:30',
            'stock_quantity' => 'required|integer|min:0',
            'image_url' => 'nullable|url',
            'category_id' => 'required|exists:categories,id'
        ]);

        $flower = Flower::create($validated);
        return new FlowerResource($flower->load('category'));
    }

    /**
     * Display the specified flower.
     */
    public function show(Flower $flower)
    {
        return new FlowerResource($flower->load('category'));
    }

    /**
     * Update the specified flower.
     */
    public function update(Request $request, Flower $flower)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0',
            'color' => 'sometimes|string|max:30',
            'stock_quantity' => 'sometimes|integer|min:0',
            'image_url' => 'nullable|url',
            'category_id' => 'sometimes|exists:categories,id'
        ]);

        $flower->update($validated);
        return new FlowerResource($flower->fresh()->load('category'));
    }

    /**
     * Remove the specified flower.
     */
    public function destroy(Flower $flower)
    {
        $flower->delete();
        return response()->json(['message' => 'Flower deleted successfully'], 200);
    }
}