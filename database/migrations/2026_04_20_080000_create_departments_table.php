<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // اسم القسم
            $table->text('description')->nullable(); // الوصف
            $table->string('manager_name'); // اسم مسؤول القسم
            $table->string('phone')->unique(); // رقم الجوال
            $table->string('image')->nullable(); // صورة القسم
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};