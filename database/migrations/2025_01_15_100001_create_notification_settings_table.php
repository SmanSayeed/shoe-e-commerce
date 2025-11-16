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
        Schema::create('notification_settings', function (Blueprint $table) {
            $table->id();
            $table->string('pusher_app_id')->nullable();
            $table->string('pusher_key')->nullable();
            $table->text('pusher_secret')->nullable(); // Will be encrypted
            $table->string('pusher_cluster')->default('ap2');
            $table->boolean('is_enabled')->default(true);
            $table->timestamps();
        });
        
        // Insert default record
        DB::table('notification_settings')->insert([
            'pusher_app_id' => null,
            'pusher_key' => null,
            'pusher_secret' => null,
            'pusher_cluster' => 'ap2',
            'is_enabled' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_settings');
    }
};

