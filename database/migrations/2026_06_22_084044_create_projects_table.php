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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            
            // Land Owner Information
            $table->string('land_owner_name');
            $table->string('land_owner_phone');
            $table->string('land_owner_id_number');
            
            // Land Information
            $table->string('land_type')->nullable(); // ارض طابوا/ استثمار/ ارض
            $table->string('owner_company_name')->nullable();
            $table->string('investor_company_name')->nullable();
            $table->string('owner_company_registration_number')->nullable();
            $table->string('investor_company_registration_number')->nullable();
            $table->string('plot_number')->nullable();
            $table->string('basin_number')->nullable();
            $table->string('coupon_number')->nullable();
            $table->string('tathseer_number')->nullable();
            $table->decimal('land_area', 10, 2)->nullable();
            $table->decimal('meter_price', 10, 2)->nullable();
            $table->decimal('land_cost', 15, 2)->nullable();
            
            // Owner Shares
            $table->decimal('owner_land_share', 10, 2)->default(0);
            $table->decimal('owner_apartments_share', 10, 2)->default(0);
            $table->decimal('owner_commercial_meters_share', 10, 2)->default(0);
            $table->decimal('owner_parking_share', 10, 2)->default(0);
            $table->decimal('owner_warehouses_share', 10, 2)->default(0);
            $table->decimal('owner_services_share', 10, 2)->default(0);
            
            // Investor Shares
            $table->decimal('investor_land_share', 10, 2)->default(0);
            $table->decimal('investor_apartments_share', 10, 2)->default(0);
            $table->decimal('investor_commercial_meters_share', 10, 2)->default(0);
            $table->decimal('investor_parking_share', 10, 2)->default(0);
            $table->decimal('investor_warehouses_share', 10, 2)->default(0);
            $table->decimal('investor_services_share', 10, 2)->default(0);
            
            // Tax Shares
            $table->decimal('owner_tax_before_sale', 10, 2)->default(0);
            $table->decimal('owner_tax_after_sale', 10, 2)->default(0);
            $table->decimal('investor_tax_before_sale', 10, 2)->default(0);
            $table->decimal('investor_tax_after_sale', 10, 2)->default(0);
            
            // Dates
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            
            // Notes
            $table->text('notes')->nullable();
            $table->string('status')->default('active'); // active, completed, pending, cancelled
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
