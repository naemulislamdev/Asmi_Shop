<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReferCapToGeneralsettings extends Migration
{
    public function up()
    {
        Schema::table('generalsettings', function (Blueprint $t) {
            if (!Schema::hasColumn('generalsettings', 'refer_max_per_referrer')) {
                // 0 = unlimited. Lifetime cap on referrals counted per referrer.
                $t->integer('refer_max_per_referrer')->default(0);
            }
        });
    }

    public function down()
    {
        Schema::table('generalsettings', function (Blueprint $t) {
            if (Schema::hasColumn('generalsettings', 'refer_max_per_referrer')) {
                $t->dropColumn('refer_max_per_referrer');
            }
        });
    }
}
