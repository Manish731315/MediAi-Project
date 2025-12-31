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
        // 1. Update Users Table
        Schema::table('users', function (Blueprint $table) {
            $table->string('city')->nullable()->after('address');
            $table->string('state')->nullable()->after('city');
            $table->string('country')->nullable()->default('India')->after('state');
            $table->string('pincode')->nullable()->after('country');
            $table->string('landmark')->nullable()->after('pincode');
        });

        // 2. Update Orders Table
        Schema::table('orders', function (Blueprint $table) {
            $table->string('city')->nullable()->after('delivery_address');
            $table->string('state')->nullable()->after('city');
            $table->string('country')->nullable()->after('state');
            $table->string('pincode')->nullable()->after('country');
            $table->string('landmark')->nullable()->after('pincode');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['city', 'state', 'country', 'pincode', 'landmark']);
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['city', 'state', 'country', 'pincode', 'landmark']);
        });
    }
};
