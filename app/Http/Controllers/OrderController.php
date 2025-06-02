<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index()
    {
        $orders = Order::with(['user', 'orderItems.flower'])->paginate(10);
        return OrderResource::collection($orders);
    }

    /**
     * Store a newly created order.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'flowers' => 'required|array|min:1',
            'flowers.*.id' => 'required|exists:flowers,id',
            'flowers.*.quantity' => 'required|integer|min:1',
            'delivery_date' => 'required|date|after:today'
        ]);

        // Calculate total
        $total = collect($validated['flowers'])->sum(function($item) {
            $flower = Flower::find($item['id']);
            return $flower->price * $item['quantity'];
        });

        // Create order
        $order = Order::create([
            'user_id' => $validated['user_id'],
            'total_amount' => $total,
            'status' => 'pending',
            'delivery_date' => $validated['delivery_date']
        ]);

        // Create order items
        foreach ($validated['flowers'] as $item) {
            $flower = Flower::find($item['id']);
            
            $order->orderItems()->create([
                'flower_id' => $item['id'],
                'quantity' => $item['quantity'],
                'unit_price' => $flower->price
            ]);
        }

        return new OrderResource($order->load(['user', 'orderItems.flower']));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        return new OrderResource($order->load(['user', 'orderItems.flower']));
    }

    /**
     * Update order status.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $order->update($validated);
        return new OrderResource($order->fresh()->load(['user', 'orderItems.flower']));
    }

    /**
     * Remove the specified order.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(['message' => 'Order deleted successfully'], 200);
    }
}