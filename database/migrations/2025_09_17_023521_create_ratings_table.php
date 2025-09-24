<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->morphs('ratable'); // This will create ratable_type and ratable_id columns
            $table->tinyInteger('rating')->unsigned(); // 1-5 stars
            $table->timestamps();
            
            // Ensure one rating per user per item
            $table->unique(['user_id', 'ratable_type', 'ratable_id']);
            $table->index(['ratable_type', 'ratable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
