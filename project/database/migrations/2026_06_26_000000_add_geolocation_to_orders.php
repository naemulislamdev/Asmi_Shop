<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'order_lat')) {
                $table->decimal('order_lat', 10, 7)->nullable();
            }
            if (!Schema::hasColumn('orders', 'order_lng')) {
                $table->decimal('order_lng', 10, 7)->nullable();
            }
            // gps | denied | unsupported | error (why we do/don't have coordinates)
            if (!Schema::hasColumn('orders', 'location_source')) {
                $table->string('location_source', 20)->nullable();
                $table->index('location_source');
            }
            // GPS accuracy radius in meters, as reported by the browser
            if (!Schema::hasColumn('orders', 'location_accuracy')) {
                $table->integer('location_accuracy')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'location_source')) {
                $table->dropIndex(['location_source']);
                $table->dropColumn('location_source');
            }
            foreach (['order_lat', 'order_lng', 'location_accuracy'] as $col) {
                if (Schema::hasColumn('orders', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
