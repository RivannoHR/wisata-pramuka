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
        Schema::table('site_statistics', function (Blueprint $table) {
            // Add columns for item-specific visit tracking
            $table->string('item_type')->nullable(); // 'product', 'accommodation', 'tourist_attraction'
            $table->unsignedBigInteger('item_id')->nullable(); // ID of the specific item
            $table->string('item_name')->nullable(); // Name of the item for easier querying
            $table->unsignedBigInteger('visits')->default(0); // Visit count for this specific item
            
            // Make the key column nullable since we'll use item_type/item_id for new records
            $table->string('key')->nullable(true)->change();
            
            // Add index for better performance
            $table->index(['item_type', 'item_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_statistics', function (Blueprint $table) {
            $table->dropColumn(['item_type', 'item_id', 'item_name', 'visits']);
            $table->dropIndex(['item_type', 'item_id', 'date']);
            $table->string('key')->nullable(false)->change();
        });
    }
};
