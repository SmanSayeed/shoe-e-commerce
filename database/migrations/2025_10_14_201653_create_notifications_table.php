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
        Schema::create('custom_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('title')->nullable()->after('type');
            $table->text('message')->nullable()->after('title');
            $table->string('notifiable_type')->nullable();
            $table->unsignedBigInteger('notifiable_id')->nullable();
            $table->text('data');
            $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('cascade')->after('message');
            $table->boolean('is_read')->default(false)->after('order_id');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade')->after('is_read');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->index(['read_at']);
            $table->index(['created_at']);
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
        Schema::dropIfExists('custom_notifications');
    }
};
