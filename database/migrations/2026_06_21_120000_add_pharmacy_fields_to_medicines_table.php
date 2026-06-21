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
            $table->string('name_ar')->nullable()->after('name');
            $table->string('name_en')->nullable()->after('name_ar');
            $table->string('image')->nullable()->after('description');
            $table->decimal('reserved_quantity', 10, 2)->default(0)->after('quantity');
            $table->decimal('available_quantity', 10, 2)->default(0)->after('reserved_quantity');
            $table->date('production_date')->nullable()->after('price');
            $table->string('availability_status')->default('available')->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medicines', function (Blueprint $table) {
            $table->dropColumn(['name_ar', 'name_en', 'image', 'reserved_quantity', 'available_quantity', 'production_date', 'availability_status']);
        });
    }
};
