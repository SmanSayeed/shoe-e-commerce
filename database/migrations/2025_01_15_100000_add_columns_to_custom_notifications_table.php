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
        Schema::table('custom_notifications', function (Blueprint $table) {
            // Add new columns if they don't exist
            if (!Schema::hasColumn('custom_notifications', 'title')) {
                $table->string('title')->nullable()->after('type');
            }
            if (!Schema::hasColumn('custom_notifications', 'message')) {
                $table->text('message')->nullable()->after('title');
            }
            if (!Schema::hasColumn('custom_notifications', 'order_id')) {
                $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('cascade')->after('message');
            }
            if (!Schema::hasColumn('custom_notifications', 'is_read')) {
                $table->boolean('is_read')->default(false)->after('order_id');
            }
            if (!Schema::hasColumn('custom_notifications', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade')->after('is_read');
            }
            
            // Add indexes
            $table->index(['user_id', 'is_read']);
            $table->index(['order_id']);
            $table->index(['type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('custom_notifications', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropForeign(['user_id']);
            $table->dropColumn(['title', 'message', 'order_id', 'is_read', 'user_id']);
        });
    }
};

