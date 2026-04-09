<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recurring_donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('campaign_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedBigInteger('amount');
            $table->string('frequency')->default('monthly');
            $table->string('payment_method_token')->nullable();
            $table->date('next_charge_date')->nullable();
            $table->string('status')->default('active');
            $table->string('stripe_subscription_id')->nullable();
            $table->timestamp('last_charged_at')->nullable();
            $table->unsignedInteger('failed_attempts')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recurring_donations');
    }
};
