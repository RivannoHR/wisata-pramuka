<?php

use App\Models\Accommodation;
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
        Schema::create('accommodation_room_types', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Accommodation::class);
            $table->string('name');
            $table->string('image_path');
            $table->decimal('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accommodation_room_types');
    }
};
