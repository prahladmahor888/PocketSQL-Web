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
        Schema::table('download_logs', function (Blueprint $table) {
            $table->string('city')->nullable()->after('ip_address');
            $table->string('state')->nullable()->after('city');
            $table->string('country')->nullable()->after('state');
            $table->string('country_code', 2)->nullable()->after('country');
            $table->string('device_type', 50)->nullable()->after('user_agent');
            $table->string('os', 50)->nullable()->after('device_type');
            $table->string('browser', 50)->nullable()->after('os');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('download_logs', function (Blueprint $table) {
            $table->dropColumn([
                'city',
                'state',
                'country',
                'country_code',
                'device_type',
                'os',
                'browser',
            ]);
        });
    }
};
