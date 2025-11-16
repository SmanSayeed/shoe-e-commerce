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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null');
            $table->integer('rating'); // 1-5 stars
            $table->string('title')->nullable();
            $table->text('comment')->nullable();
            $table->json('images')->nullable();
            $table->boolean('is_verified_purchase')->default(false);
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->integer('helpful_count')->default(0);
            $table->integer('not_helpful_count')->default(0);
            
            // Admin fields for testimonials
            $table->string('reviewer_name')->nullable();
            $table->string('reviewer_email')->nullable();
            $table->string('reviewer_location')->nullable();
            $table->string('product_display_name')->nullable();
            $table->date('reviewed_at')->nullable();
            $table->boolean('show_on_homepage')->default(true);
            $table->unsignedInteger('display_order')->default(0);
            
            $table->timestamps();

            // Removed unique constraint on product_id and customer_id to allow admin-authored testimonials
            $table->index(['product_id', 'is_approved']);
            $table->index(['customer_id']);
            $table->index(['rating']);
            $table->index(['created_at']);
            $table->index(['show_on_homepage', 'is_approved'], 'reviews_homepage_visibility_index');
            $table->index('display_order', 'reviews_display_order_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
