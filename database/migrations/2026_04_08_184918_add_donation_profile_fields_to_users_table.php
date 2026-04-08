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
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('donor')->after('email');
            $table->string('phone')->nullable()->after('password');
            $table->string('address_line_1')->nullable()->after('phone');
            $table->string('address_line_2')->nullable()->after('address_line_1');
            $table->string('city')->nullable()->after('address_line_2');
            $table->string('state')->nullable()->after('city');
            $table->string('postal_code')->nullable()->after('state');
            $table->string('country')->nullable()->after('postal_code');
            $table->json('notification_preferences')->nullable()->after('country');

            $table->index('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']);
            $table->dropColumn([
                'role',
                'phone',
                'address_line_1',
                'address_line_2',
                'city',
                'stripe_id',
                'pm_type',
                'pm_last_four',
                'trial_ends_at',
            ]);
        });
    }
};
