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
        Schema::create('recurring_donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('campaign_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedBigInteger('amount');
            $table->enum('frequency', ['weekly', 'monthly', 'yearly']);
            $table->string('payment_method_token')->nullable();
            $table->date('next_charge_date')->nullable();
            $table->enum('status', ['active', 'paused', 'cancelled', 'failed'])->default('active');
            $table->string('stripe_subscription_id')->nullable()->unique();
            $table->timestamp('last_charged_at')->nullable();
            $table->unsignedTinyInteger('failed_attempts')->default(0);
            $table->timestamps();

            $table->index(['status', 'next_charge_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recurring_donations');
    }
};
