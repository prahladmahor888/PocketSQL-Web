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
        // 1. Create Donations Table
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('donor_name');
            $table->string('donor_email');
            $table->decimal('amount', 10, 2);
            $table->string('currency', 10)->default('INR');
            $table->text('message')->nullable();
            $table->string('payment_method')->nullable(); // UPI, Card, Netbanking, Wallet, PayPal
            $table->string('razorpay_order_id')->nullable()->index();
            $table->string('razorpay_payment_id')->nullable()->index();
            $table->string('razorpay_signature')->nullable();
            $table->string('status', 30)->default('pending')->index(); // pending, successful, failed
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });

        // 2. Add Razorpay columns to app_settings if not present
        Schema::table('app_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('app_settings', 'razorpay_enabled')) {
                $table->boolean('razorpay_enabled')->default(true)->after('admin_session_lifetime_minutes');
            }
            if (!Schema::hasColumn('app_settings', 'razorpay_key_id')) {
                $table->string('razorpay_key_id')->nullable()->after('razorpay_enabled');
            }
            if (!Schema::hasColumn('app_settings', 'razorpay_key_secret')) {
                $table->string('razorpay_key_secret')->nullable()->after('razorpay_key_id');
            }
            if (!Schema::hasColumn('app_settings', 'min_donation_amount')) {
                $table->unsignedInteger('min_donation_amount')->default(100)->after('razorpay_key_secret');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');

        Schema::table('app_settings', function (Blueprint $table) {
            $columns = ['razorpay_enabled', 'razorpay_key_id', 'razorpay_key_secret', 'min_donation_amount'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('app_settings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
