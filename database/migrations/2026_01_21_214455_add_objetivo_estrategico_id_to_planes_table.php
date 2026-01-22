<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('planes', function (Blueprint $table) {
            $table->unsignedBigInteger('objetivo_estrategico_id')
                  ->nullable()
                  ->after('responsable_id');

            $table->foreign('objetivo_estrategico_id')
                  ->references('id')->on('objetivos_estrategicos')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::table('planes', function (Blueprint $table) {
            $table->dropForeign(['objetivo_estrategico_id']);
            $table->dropColumn('objetivo_estrategico_id');
        });
    }
};