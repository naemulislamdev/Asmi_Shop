<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate --path=database/migrations/2026_04_11_124437_create_promo_offers_table.php
     */
    public function up(): void
    {
        Schema::create('promo_offers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('subtitle')->nullable();
            $table->string('image')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->json('products')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_offers');
    }
};
