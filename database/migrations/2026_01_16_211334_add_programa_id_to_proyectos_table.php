<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('proyectos', function (Blueprint $table) {
            $table->foreignId('programa_id')
                ->constrained('programas')
                ->cascadeOnUpdate()
                ->restrictOnDelete()
                ->after('fecha_fin'); // ajusta la posición si quieres
        });
    }

    public function down(): void
    {
        Schema::table('proyectos', function (Blueprint $table) {
            $table->dropForeign(['programa_id']);
            $table->dropColumn('programa_id');
        });
    }
};