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
        Schema::table('bookings', function (Blueprint $table) {
            // Drop the existing enum constraint and recreate it with the 'completed' status
            $table->dropColumn('status');
        });
        
        Schema::table('bookings', function (Blueprint $table) {
            $table->enum('status', ['pending', 'active', 'completed', 'cancelled'])->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Revert back to the original enum without 'completed'
            $table->dropColumn('status');
        });
        
        Schema::table('bookings', function (Blueprint $table) {
            $table->enum('status', ['pending', 'active', 'cancelled'])->default('pending');
        });
    }
};
