<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Bengali search keywords for products (Bangla synonyms so customers can search in Bengali).
        // NOTE: already applied directly on LIVE via ALTER on 2026-06-22; guard makes this a no-op there.
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'bn_keywords')) {
                $table->text('bn_keywords')->nullable()->after('tags');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'bn_keywords')) {
                $table->dropColumn('bn_keywords');
            }
        });
    }
};
