<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('generalsettings', function (Blueprint $table) {
            if (!Schema::hasColumn('generalsettings', 'first_order_discount_percent')) {
                // 0 = feature OFF. Set to 5 (after backfill) to give 5% on the
                // first app order per phone.
                $table->decimal('first_order_discount_percent', 5, 2)->default(0);
            }
        });
    }

    public function down(): void
    {
        Schema::table('generalsettings', function (Blueprint $table) {
            if (Schema::hasColumn('generalsettings', 'first_order_discount_percent')) {
                $table->dropColumn('first_order_discount_percent');
            }
        });
    }
};
