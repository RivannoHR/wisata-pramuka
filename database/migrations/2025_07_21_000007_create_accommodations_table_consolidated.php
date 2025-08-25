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
        Schema::create('accommodations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('type')->default('hotel'); // hotel, villa, guesthouse, etc.
            $table->text('location')->nullable();
            $table->decimal('rating', 2, 1)->nullable();
            $table->integer('capacity');
            $table->json('facilities')->nullable(); // amenities like wifi, ac, pool, etc.
            $table->string('image_path')->nullable();
            $table->decimal('price_per_night', 10, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accommodations');
    }
};
