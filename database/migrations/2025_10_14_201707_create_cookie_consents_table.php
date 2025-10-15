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
        Schema::create('cookie_consents', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->unique();
            $table->boolean('necessary')->default(true);
            $table->boolean('functional')->default(false);
            $table->boolean('analytics')->default(false);
            $table->boolean('marketing')->default(false);
            $table->json('preferences')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('consent_date');
            $table->timestamps();

            $table->index(['session_id']);
            $table->index(['consent_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cookie_consents');
    }
};
