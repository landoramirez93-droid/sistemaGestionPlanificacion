<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('objetivos_estrategicos', function (Blueprint $table) {
            if (!Schema::hasColumn('objetivos_estrategicos', 'estado')) {
                $table->boolean('estado')->default(true)->after('entidad_id');
                // Alternativa si prefieres entero: $table->tinyInteger('estado')->default(1)->after('entidad_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('objetivos_estrategicos', function (Blueprint $table) {
            if (Schema::hasColumn('objetivos_estrategicos', 'estado')) {
                $table->dropColumn('estado');
            }
        });
    }
};