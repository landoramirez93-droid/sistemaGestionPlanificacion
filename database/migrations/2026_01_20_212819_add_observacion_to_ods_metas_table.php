<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('ods_metas', function (Blueprint $table) {
            $table->text('observacion')->nullable()->after('presupuesto');
        });
    }

    public function down(): void
    {
        Schema::table('ods_metas', function (Blueprint $table) {
            $table->dropColumn('observacion');
        });
    }
};