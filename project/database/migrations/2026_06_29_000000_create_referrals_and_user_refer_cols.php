<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferralsAndUserReferCols extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('users', 'referral_code')) {
            Schema::table('users', function (Blueprint $t) {
                $t->string('referral_code', 16)->nullable()->unique();
            });
        }
        if (!Schema::hasColumn('users', 'referred_by')) {
            Schema::table('users', function (Blueprint $t) {
                $t->unsignedBigInteger('referred_by')->nullable()->index();
            });
        }
        if (!Schema::hasTable('referrals')) {
            Schema::create('referrals', function (Blueprint $t) {
                $t->bigIncrements('id');
                $t->unsignedBigInteger('referrer_id')->index();
                $t->string('referee_phone_normalized', 20)->unique();
                $t->unsignedBigInteger('referee_user_id')->nullable();
                $t->string('code', 16);
                $t->unsignedBigInteger('order_id')->nullable()->index();
                $t->enum('status', ['pending', 'rewarded', 'void'])->default('pending')->index();
                $t->integer('referrer_points')->default(0);
                $t->integer('referee_points')->default(0);
                $t->timestamp('created_at')->nullable();
                $t->timestamp('rewarded_at')->nullable();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('referrals');
        Schema::table('users', function (Blueprint $t) {
            if (Schema::hasColumn('users', 'referral_code')) $t->dropColumn('referral_code');
            if (Schema::hasColumn('users', 'referred_by')) $t->dropColumn('referred_by');
        });
    }
}
