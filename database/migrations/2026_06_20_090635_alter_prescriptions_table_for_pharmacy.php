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
        Schema::table('prescriptions', function (Blueprint $table) {
            // Add status column
            $table->string('status')->default('pending')->after('doctor_id'); // pending, delivered, cancelled
            
            // Make old columns nullable just in case we still need them or to preserve old data
            $table->text('medications')->nullable()->change();
            $table->string('dosage')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prescriptions', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->text('medications')->nullable(false)->change();
            $table->string('dosage')->nullable(false)->change();
        });
    }
};
