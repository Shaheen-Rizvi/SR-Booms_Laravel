<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');       // e.g., "Roses", "Bouquets"
            $table->string('color');      // e.g., "#FF9EB5" for UI
            $table->timestamps();
            $table->softDeletes(); // For the SoftDeletes functionality
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};