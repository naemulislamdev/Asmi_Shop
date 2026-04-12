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
        Schema::create('order_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('time_form')->nullable();
            $table->string('time_to')->nullable();
            $table->string('offer')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_schedules');
    }
};
