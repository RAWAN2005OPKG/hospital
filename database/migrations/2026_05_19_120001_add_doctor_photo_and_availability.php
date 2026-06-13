<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            if (! Schema::hasColumn('doctors', 'photo')) {
                $table->string('photo')->nullable()->after('bio');
            }
            if (! Schema::hasColumn('doctors', 'availability_status')) {
                $table->boolean('availability_status')->default(true)->after('photo');
            }
        });
    }

    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            if (Schema::hasColumn('doctors', 'photo')) {
                $table->dropColumn('photo');
            }
            if (Schema::hasColumn('doctors', 'availability_status')) {
                $table->dropColumn('availability_status');
            }
        });
    }
};
