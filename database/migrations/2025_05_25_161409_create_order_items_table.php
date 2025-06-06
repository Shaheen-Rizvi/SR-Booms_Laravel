<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            
            // Fixed: Single definition with cascade delete
            $table->foreignId('flower_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            $table->integer('quantity');
            $table->decimal('unit_price', 8, 2);  // Price at time of purchase
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};