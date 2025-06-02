<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Flower;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // <--- Add this import

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a specific admin user for testing
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // <--- Hashed password for the specific admin
            'user_type' => 'admin', // Ensure this matches your admin user type
            'email_verified_at' => now(),
        ]);

        // Create 5 flower categories
        $categories = Category::factory(5)->create();

        // Create 9 more users (because we already made one admin above)
        // If you want 10 *additional* users, keep User::factory(10)->create();
        // If you want 10 users *total* including the admin, change this to 9.
        // For simplicity, let's keep it creating 10 more for now, so you have admin@example.com + 10 random.
        User::factory(10)->create();


        Flower::factory(20)->create()->each(function ($flower) use ($categories) {
            // Assign to random category
            $flower->category()->associate($categories->random())->save();
        });

        // Create 30 orders with order items
        Order::factory(30)->create()->each(function ($order) {
            // Add 1-5 flower items to each order
            OrderItem::factory(rand(1, 5))->create([
                'order_id' => $order->id,
                'flower_id' => Flower::inRandomOrder()->first()->id,
            ]);

            // Update order total (sum of all items)
            $order->update([
                'total_amount' => $order->orderItems->sum(function ($item) {
                    return $item->quantity * $item->unit_price;
                })
            ]);
        });
    }
}