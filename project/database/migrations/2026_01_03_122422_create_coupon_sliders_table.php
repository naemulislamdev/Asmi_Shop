<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations. php artisan migrate --path=project/database/migrations/2026_01_03_122422_create_coupon_sliders_table.php
     */
    public function up(): void
    {
        Schema::create('coupon_sliders', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->boolean('published')->default(1);
            $table->integer('order')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon_sliders');
    }
};
