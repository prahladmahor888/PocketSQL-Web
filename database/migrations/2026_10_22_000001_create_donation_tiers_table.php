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
        Schema::create('donation_tiers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('amount');
            $table->string('badge')->nullable(); // e.g. "Popular", "Recommended"
            $table->string('impact_heading')->nullable();
            $table->text('impact_text')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_popular')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_tiers');
    }
};
