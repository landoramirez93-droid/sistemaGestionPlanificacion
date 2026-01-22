<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('ods_metas', function (Blueprint $table) {
            // Quita índice único antiguo (numero)
            $table->dropUnique('ods_metas_numero_unique');

            // Crea índice único compuesto (ods_numero + numero)
            $table->unique(['ods_numero', 'numero'], 'ods_metas_ods_numero_numero_unique');
        });
    }

    public function down(): void
    {
        Schema::table('ods_metas', function (Blueprint $table) {
            $table->dropUnique('ods_metas_ods_numero_numero_unique');
            $table->unique('numero', 'ods_metas_numero_unique');
        });
    }
};