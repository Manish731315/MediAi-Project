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
            // Phone number column
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->unique()->after('email');
            }
            
            // OTP Verification columns
            $table->timestamp('phone_verified_at')->nullable()->after('email_verified_at');
            $table->string('email_otp')->nullable(); // To store temporary OTP
            $table->string('phone_otp')->nullable(); // To store temporary OTP
            
            // Address column (if you haven't added it yet)
            if (!Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable()->after('phone');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'phone_verified_at', 'email_otp', 'phone_otp', 'address']);
        });
    }
};
