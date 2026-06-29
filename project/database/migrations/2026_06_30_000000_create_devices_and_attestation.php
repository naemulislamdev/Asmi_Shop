<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicesAndAttestation extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('devices')) {
            Schema::create('devices', function (Blueprint $t) {
                $t->bigIncrements('id');
                $t->string('device_id', 80)->unique();
                $t->string('platform', 16)->default('unknown');
                $t->tinyInteger('attested')->default(0);
                $t->integer('attest_fail_count')->default(0);
                $t->integer('referrals_count')->default(0);
                $t->string('notes', 191)->nullable();
                $t->timestamp('first_seen_at')->nullable();
                $t->timestamp('last_seen_at')->nullable();
                $t->timestamps();
            });
        }
        if (!Schema::hasTable('device_user')) {
            Schema::create('device_user', function (Blueprint $t) {
                $t->bigIncrements('id');
                $t->string('device_id', 80)->index();
                $t->unsignedBigInteger('user_id')->nullable()->index();
                $t->string('phone_normalized', 20)->nullable()->index();
                $t->timestamp('first_seen_at')->nullable();
                $t->unique(['device_id', 'phone_normalized']);
            });
        }
        if (!Schema::hasColumn('referrals', 'device_id')) {
            Schema::table('referrals', function (Blueprint $t) {
                $t->string('device_id', 80)->nullable()->index();
            });
        }
        if (!Schema::hasColumn('user_login_sessions', 'device_id')) {
            Schema::table('user_login_sessions', function (Blueprint $t) {
                $t->string('device_id', 80)->nullable()->index();
            });
        }
        Schema::table('generalsettings', function (Blueprint $t) {
            if (!Schema::hasColumn('generalsettings', 'refer_max_per_device')) {
                $t->integer('refer_max_per_device')->default(0); // 0 = unlimited
            }
            if (!Schema::hasColumn('generalsettings', 'refer_require_attested_device')) {
                $t->tinyInteger('refer_require_attested_device')->default(0); // gate OFF
            }
        });
    }

    public function down()
    {
        Schema::dropIfExists('device_user');
        Schema::dropIfExists('devices');
        Schema::table('referrals', function (Blueprint $t) {
            if (Schema::hasColumn('referrals', 'device_id')) $t->dropColumn('device_id');
        });
        Schema::table('user_login_sessions', function (Blueprint $t) {
            if (Schema::hasColumn('user_login_sessions', 'device_id')) $t->dropColumn('device_id');
        });
        Schema::table('generalsettings', function (Blueprint $t) {
            foreach (['refer_max_per_device', 'refer_require_attested_device'] as $c) {
                if (Schema::hasColumn('generalsettings', $c)) $t->dropColumn($c);
            }
        });
    }
}
