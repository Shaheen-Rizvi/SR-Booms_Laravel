<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\OrderItem;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of flower categories.
     */
    public function index()
    {
        $categories = Category::with('flowers')->paginate(5);
        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created flower category.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:25',
            'color' => 'required|string|max:30'
        ]);

        $category = Category::create($validated);
        return new CategoryResource($category);
    }

    /**
     * Display the specified flower category.
     */
    public function show(string $id)
    {
        $category = Category::with('flowers')->findOrFail($id);
        return new CategoryResource($category);
    }

    /**
     * Update the specified flower category.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:25',
            'color' => 'required|string|max:30'
        ]);

        $category = Category::findOrFail($id);
        $category->update($validated);
        return new CategoryResource($category);
    }

    /**
     * Remove the specified flower category.
     */
    public function destroy(Category $category)
    {
        // Check if any flowers in this category are in orders
        $usedInOrders = OrderItem::whereHas('flower', function($query) use ($category) {
            $query->where('category_id', $category->id);
        })->exists();

        if ($usedInOrders) {
            return response()->json([
                'message' => 'Cannot delete category: Some flowers are used in orders',
                'solution' => [
                    'option1' => 'First delete related orders',
                    'option2' => 'Reassign flowers to another category first'
                ]
            ], 422);
        }

        $category->delete();
        return response()->json([
            'message' => 'Category deleted successfully',
            'deleted_at' => $category->deleted_at
        ]);
    }
}