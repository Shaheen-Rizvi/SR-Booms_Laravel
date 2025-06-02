<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // Check if column doesn't exist before adding
            if (!Schema::hasColumn('categories', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // Only remove if column exists
            if (Schema::hasColumn('categories', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
};