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
        Schema::table('releases', function (Blueprint $table) {
            $table->unsignedBigInteger('downloads_count')->default(0)->after('download_url');
        });

        Schema::table('app_settings', function (Blueprint $table) {
            $table->unsignedBigInteger('total_downloads_count')->default(0)->after('api_server_active');
        });

        Schema::create('download_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('release_id')->nullable();
            $table->string('version')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->foreign('release_id')->references('id')->on('releases')->onDelete('set null');
            $table->index(['ip_address', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('download_logs');

        Schema::table('app_settings', function (Blueprint $table) {
            $table->dropColumn('total_downloads_count');
        });

        Schema::table('releases', function (Blueprint $table) {
            $table->dropColumn('downloads_count');
        });
    }
};
