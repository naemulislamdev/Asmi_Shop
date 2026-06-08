<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            if (!Schema::hasColumn('coupons', 'channel')) {
                $table->string('channel', 10)->default('all'); // all | app | web
            }
            if (!Schema::hasColumn('coupons', 'per_user_limit')) {
                $table->integer('per_user_limit')->default(0); // 0 = unlimited per phone
            }
        });
    }

    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            if (Schema::hasColumn('coupons', 'channel')) {
                $table->dropColumn('channel');
            }
            if (Schema::hasColumn('coupons', 'per_user_limit')) {
                $table->dropColumn('per_user_limit');
            }
        });
    }
};
