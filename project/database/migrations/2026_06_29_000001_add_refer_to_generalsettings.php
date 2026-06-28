<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReferToGeneralsettings extends Migration
{
    public function up()
    {
        Schema::table('generalsettings', function (Blueprint $t) {
            if (!Schema::hasColumn('generalsettings', 'is_refer')) {
                $t->tinyInteger('is_refer')->default(0);
            }
            if (!Schema::hasColumn('generalsettings', 'refer_referrer_points')) {
                $t->integer('refer_referrer_points')->default(0);
            }
            if (!Schema::hasColumn('generalsettings', 'refer_referee_points')) {
                $t->integer('refer_referee_points')->default(0);
            }
        });
    }

    public function down()
    {
        Schema::table('generalsettings', function (Blueprint $t) {
            foreach (['is_refer', 'refer_referrer_points', 'refer_referee_points'] as $c) {
                if (Schema::hasColumn('generalsettings', $c)) $t->dropColumn($c);
            }
        });
    }
}
