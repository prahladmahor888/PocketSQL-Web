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
        Schema::create('traffic_logs', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45)->index();
            $table->string('method', 10);
            $table->string('path', 500)->index();
            $table->integer('status_code')->index();
            $table->text('user_agent')->nullable();
            $table->integer('response_time_ms')->default(0);
            $table->boolean('is_blocked')->default(false)->index();
            $table->timestamp('created_at')->useCurrent()->index();
        });

        Schema::create('blocked_ips', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45)->unique();
            $table->string('reason')->nullable();
            $table->timestamp('blocked_until')->nullable();
            $table->timestamps();
        });

        Schema::table('app_settings', function (Blueprint $table) {
            $table->boolean('traffic_shield_enabled')->default(true);
            $table->integer('rate_limit_per_minute')->default(120);
            $table->integer('admin_login_max_attempts')->default(3);
            $table->integer('admin_session_lifetime_minutes')->default(15);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('traffic_logs');
        Schema::dropIfExists('blocked_ips');

        Schema::table('app_settings', function (Blueprint $table) {
            $table->dropColumn([
                'traffic_shield_enabled',
                'rate_limit_per_minute',
                'admin_login_max_attempts',
                'admin_session_lifetime_minutes',
            ]);
        });
    }
};
