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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_id')->unique(); // e.g., BK0001
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('accommodation_id')->constrained()->onDelete('cascade');
            $table->string('room_type')->nullable()->default('standard');
            $table->integer('rooms_count')->default(1);
            $table->date('booking_date');
            $table->date('check_in_date')->nullable();
            $table->date('check_out_date')->nullable();
            $table->date('checkin_date')->nullable();
            $table->date('checkout_date')->nullable();
            $table->integer('duration_days')->default(1);
            $table->decimal('total_price', 12, 2);
            $table->enum('status', ['pending', 'active', 'cancelled'])->default('pending');
            $table->text('notes')->nullable();
            $table->text('special_requests')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
