<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('ods_metas', function (Blueprint $table) {
            if (!Schema::hasColumn('ods_metas', 'objetivo')) {
                $table->text('objetivo')->nullable()->after('codigo');
            }
            if (!Schema::hasColumn('ods_metas', 'descripcion')) {
                $table->longText('descripcion')->nullable()->after('objetivo');
            }
            if (!Schema::hasColumn('ods_metas', 'meta')) {
                $table->longText('meta')->nullable()->after('descripcion');
            }
        });
    }

    public function down(): void
    {
        Schema::table('ods_metas', function (Blueprint $table) {
            if (Schema::hasColumn('ods_metas', 'meta')) $table->dropColumn('meta');
            if (Schema::hasColumn('ods_metas', 'descripcion')) $table->dropColumn('descripcion');
            if (Schema::hasColumn('ods_metas', 'objetivo')) $table->dropColumn('objetivo');
        });
    }
};