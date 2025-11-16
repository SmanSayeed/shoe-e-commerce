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
        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('advance_payment_status')->nullable()->after('advance_payment_amount');
            $table->string('bkash_number', 20)->nullable()->after('advance_payment_status');
            $table->string('transaction_id', 100)->nullable()->after('bkash_number');
            $table->decimal('advance_payment_paid_amount', 8, 2)->nullable()->after('transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'advance_payment_status',
                'bkash_number',
                'transaction_id',
                'advance_payment_paid_amount'
            ]);
        });
    }
};
