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
        Schema::table('product_variants', function (Blueprint $table) {
            $table->unsignedBigInteger('color_id')->nullable()->after('product_id');
            $table->string('sku')->nullable()->after('color_id');
            $table->string('name')->nullable()->after('sku');
            $table->json('attributes')->nullable()->after('name');
            $table->decimal('price', 10, 2)->nullable()->after('attributes');
            $table->decimal('sale_price', 10, 2)->nullable()->after('price');
            $table->string('image')->nullable()->after('sale_price');
            $table->decimal('weight', 8, 2)->nullable()->after('image');
            $table->integer('sort_order')->default(0)->after('weight');

            // Add foreign key constraints
            $table->foreign('color_id')->references('id')->on('colors')->onDelete('set null');

            // Add indexes
            $table->index(['color_id']);
            $table->index(['sku']);
            $table->index(['is_active', 'stock_quantity']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropForeign(['color_id']);
            $table->dropIndex(['color_id']);
            $table->dropIndex(['sku']);
            $table->dropIndex(['is_active', 'stock_quantity']);

            $table->dropColumn([
                'color_id',
                'sku',
                'name',
                'attributes',
                'price',
                'sale_price',
                'image',
                'weight',
                'sort_order'
            ]);
        });
    }
};
