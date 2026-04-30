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
        Schema::create('conditional_offers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('min_purchase_amount', 10, 2);
            $table->decimal('offer_price', 10, 2);
            $table->integer('offer_quantity')->default(1);
            $table->boolean('is_active')->default(1);
            $table->date('starts_at')->nullable();
            $table->date('ends_at')->nullable();
            $table->integer('max_uses_per_order')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conditional_offers');
    }
};
