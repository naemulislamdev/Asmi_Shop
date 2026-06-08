<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'first_order_discount')) {
                $table->decimal('first_order_discount', 10, 2)->default(0);
            }
            if (!Schema::hasColumn('orders', 'customer_phone_normalized')) {
                $table->string('customer_phone_normalized', 20)->nullable();
                $table->index('customer_phone_normalized');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'first_order_discount')) {
                $table->dropColumn('first_order_discount');
            }
            if (Schema::hasColumn('orders', 'customer_phone_normalized')) {
                $table->dropIndex(['customer_phone_normalized']);
                $table->dropColumn('customer_phone_normalized');
            }
        });
    }
};
