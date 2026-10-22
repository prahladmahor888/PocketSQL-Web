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
        Schema::table('app_settings', function (Blueprint $table) {
            $table->string('contact_phone')->nullable()->after('contact_email');
            $table->string('contact_address')->nullable()->after('contact_phone');
            $table->string('support_hours')->nullable()->after('contact_address');
            $table->string('discord_url')->nullable()->after('support_hours');
            $table->string('telegram_url')->nullable()->after('discord_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('app_settings', function (Blueprint $table) {
            $table->dropColumn([
                'contact_phone',
                'contact_address',
                'support_hours',
                'discord_url',
                'telegram_url',
            ]);
        });
    }
};
