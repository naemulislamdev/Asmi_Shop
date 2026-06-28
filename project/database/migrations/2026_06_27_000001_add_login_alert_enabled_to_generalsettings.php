<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('generalsettings', function (Blueprint $table) {
            // Master switch for login-alert emails. Default OFF so deploying
            // the code changes nothing until an admin turns it on.
            if (!Schema::hasColumn('generalsettings', 'login_alert_enabled')) {
                $table->boolean('login_alert_enabled')->default(0);
            }
        });
    }

    public function down(): void
    {
        Schema::table('generalsettings', function (Blueprint $table) {
            if (Schema::hasColumn('generalsettings', 'login_alert_enabled')) {
                $table->dropColumn('login_alert_enabled');
            }
        });
    }
};
