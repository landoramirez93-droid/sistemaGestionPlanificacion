<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('objetivos_estrategicos', function (Blueprint $table) {
            if (!Schema::hasColumn('objetivos_estrategicos', 'linea_estrategica')) {
                $table->string('linea_estrategica', 255)->nullable()->after('descripcion');
            }
        });
    }

    public function down(): void
    {
        Schema::table('objetivos_estrategicos', function (Blueprint $table) {
            if (Schema::hasColumn('objetivos_estrategicos', 'linea_estrategica')) {
                $table->dropColumn('linea_estrategica');
            }
        });
    }
};