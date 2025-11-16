<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->string('reviewer_name')->nullable()->after('customer_id');
            $table->string('reviewer_email')->nullable()->after('reviewer_name');
            $table->string('reviewer_location')->nullable()->after('reviewer_email');
            $table->string('product_display_name')->nullable()->after('reviewer_location');
            $table->date('reviewed_at')->nullable()->after('comment');
            $table->boolean('show_on_homepage')->default(true)->after('is_approved');
            $table->unsignedInteger('display_order')->default(0)->after('show_on_homepage');
        });

        // Allow admin-authored testimonials without linking to a specific customer/product.
        // SQLite does not support MODIFY COLUMN, so only run these statements on MySQL.
        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE reviews MODIFY COLUMN product_id BIGINT UNSIGNED NULL');
            DB::statement('ALTER TABLE reviews MODIFY COLUMN customer_id BIGINT UNSIGNED NULL');

            Schema::table('reviews', function (Blueprint $table) {
                $table->dropUnique('reviews_product_id_customer_id_unique');
            });
        }

        Schema::table('reviews', function (Blueprint $table) {
            $table->index(['show_on_homepage', 'is_approved'], 'reviews_homepage_visibility_index');
            $table->index('display_order', 'reviews_display_order_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropIndex('reviews_homepage_visibility_index');
            $table->dropIndex('reviews_display_order_index');

            $table->dropColumn([
                'reviewer_name',
                'reviewer_email',
                'reviewer_location',
                'product_display_name',
                'reviewed_at',
                'show_on_homepage',
                'display_order',
            ]);
        });

        if (Schema::getConnection()->getDriverName() === 'mysql') {
            Schema::table('reviews', function (Blueprint $table) {
                $table->unique(['product_id', 'customer_id']);
            });

            DB::statement('ALTER TABLE reviews MODIFY COLUMN product_id BIGINT UNSIGNED NOT NULL');
            DB::statement('ALTER TABLE reviews MODIFY COLUMN customer_id BIGINT UNSIGNED NOT NULL');
        }
    }
};
