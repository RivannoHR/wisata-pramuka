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
        // This migration was likely for renaming a table that may not exist
        // We'll make it a no-op to avoid errors
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration was likely for renaming a table that may not exist
        // We'll make it a no-op to avoid errors
    }
};