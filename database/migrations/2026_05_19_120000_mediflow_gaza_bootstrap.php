<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * For databases created before MediFlow Gaza: extend role enum (MySQL), add OTP columns.
     */
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            try {
                DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('patient','doctor','admin','receptionist') NOT NULL DEFAULT 'patient'");
            } catch (\Throwable) {
                // Enum may already include receptionist
            }
        }

        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'login_otp')) {
                $table->string('login_otp', 10)->nullable()->after('remember_token');
            }
            if (! Schema::hasColumn('users', 'login_otp_expires_at')) {
                $table->timestamp('login_otp_expires_at')->nullable()->after('login_otp');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'login_otp')) {
                $table->dropColumn(['login_otp', 'login_otp_expires_at']);
            }
        });
    }
};
