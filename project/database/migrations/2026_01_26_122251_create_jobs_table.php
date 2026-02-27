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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('department')->nullable();
            $table->text('description')->nullable();
            $table->string('job_location')->nullable();
            $table->date('circular_date')->nullable();
            $table->date('deadline')->nullable();
            $table->boolean('status')->default(1);
            $table->string('experience')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations. php artisan migrate --path=database/migrations/2026_01_26_122251_create_jobs_table.php
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
