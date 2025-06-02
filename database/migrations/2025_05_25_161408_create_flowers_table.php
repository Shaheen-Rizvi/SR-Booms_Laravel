<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flowers', function (Blueprint $table) {
            $table->id();
            $table->string('name');               // e.g., "Red Roses"
            $table->text('description');
            $table->decimal('price', 8, 2);       // e.g., 29.99
            $table->string('color');              // Primary color
            $table->integer('stock_quantity');
            $table->string('image_url')->nullable();
            
            // Fixed foreign key definition (only one needed)
            $table->foreignId('category_id')
                  ->constrained()  // References 'categories' table by convention
                  ->onDelete('cascade');  // Add cascade delete behavior
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flowers');
    }
};