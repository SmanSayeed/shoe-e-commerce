<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify payment_status enum to include 'partially_paid'
        DB::statement("ALTER TABLE orders MODIFY COLUMN payment_status ENUM('pending', 'paid', 'failed', 'refunded', 'partially_paid') DEFAULT 'pending'");
        
        // Change default currency from USD to BDT
        DB::statement("ALTER TABLE orders MODIFY COLUMN currency VARCHAR(3) DEFAULT 'BDT'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert payment_status enum (remove 'partially_paid')
        DB::statement("ALTER TABLE orders MODIFY COLUMN payment_status ENUM('pending', 'paid', 'failed', 'refunded') DEFAULT 'pending'");
        
        // Revert default currency to USD
        DB::statement("ALTER TABLE orders MODIFY COLUMN currency VARCHAR(3) DEFAULT 'USD'");
    }
};
