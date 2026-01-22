<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('programas', function (Blueprint $table) {
            $table->unsignedBigInteger('entidad_id')->nullable()->after('id');

            // Recomendado: relación con entidades (ajusta el nombre de la tabla si no es "entidades")
            $table->foreign('entidad_id')
                ->references('id')
                ->on('entidades')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('programas', function (Blueprint $table) {
            // Primero se elimina la FK y luego la columna
            $table->dropForeign(['entidad_id']);
            $table->dropColumn('entidad_id');
        });
    }
};