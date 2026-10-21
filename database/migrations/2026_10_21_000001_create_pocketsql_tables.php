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
        Schema::create('app_settings', function (Blueprint $table) {
            $table->id();
            $table->string('current_version')->default('v1.0.5');
            $table->integer('version_code')->default(11);
            $table->string('apk_download_url')->default('/download/apk');
            $table->string('playstore_url')->nullable();
            $table->string('github_repo_url')->default('https://github.com/pocketsql/pocketsql');
            $table->string('documentation_url')->default('/docs');
            $table->string('contact_email')->default('support@pocketsql.app');
            $table->text('release_notes')->nullable();
            $table->boolean('api_server_active')->default(true);
            $table->timestamps();
        });

        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('subject');
            $table->string('inquiry_type')->default('General Inquiry');
            $table->text('message');
            $table->string('status')->default('unread'); // unread, replied, archived
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });

        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            $table->string('platform');
            $table->string('label');
            $table->string('url');
            $table->text('icon_svg')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('screenshots', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('image_path');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });

        Schema::create('donation_methods', function (Blueprint $table) {
            $table->id();
            $table->string('method_name');
            $table->string('account_identifier')->nullable();
            $table->string('qr_image_path')->nullable();
            $table->string('payment_url')->nullable();
            $table->text('instructions')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('code_snippets', function (Blueprint $table) {
            $table->id();
            $table->string('language');
            $table->string('title');
            $table->text('code_content');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->text('answer');
            $table->string('category')->default('General');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('releases', function (Blueprint $table) {
            $table->id();
            $table->string('version');
            $table->integer('version_code');
            $table->string('release_date');
            $table->string('apk_size');
            $table->string('sha256_hash');
            $table->text('changelog');
            $table->string('download_url');
            $table->boolean('is_latest')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('releases');
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('code_snippets');
        Schema::dropIfExists('donation_methods');
        Schema::dropIfExists('screenshots');
        Schema::dropIfExists('social_links');
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('app_settings');
    }
};
