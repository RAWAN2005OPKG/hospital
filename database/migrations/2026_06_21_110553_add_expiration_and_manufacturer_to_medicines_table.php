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
        Schema::table('medicines', function (Blueprint $table) {
            $table->date('expiration_date')->nullable()->after('price');
            $table->string('manufacturer')->nullable()->after('expiration_date');
            $table->string('batch_number')->nullable()->after('manufacturer');
            $table->decimal('quantity', 10, 2)->default(0)->after('stock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medicines', function (Blueprint $table) {
            $table->dropColumn(['expiration_date', 'manufacturer', 'batch_number', 'quantity']);
        });
    }
};
