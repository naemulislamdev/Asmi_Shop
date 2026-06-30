<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('push_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->string('body', 600);
            $table->string('topic', 60)->default('all');
            $table->unsignedBigInteger('sent_by')->nullable();
            $table->string('status', 20)->default('pending');
            $table->string('message_id')->nullable();
            $table->text('response')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('push_campaigns');
    }
};
