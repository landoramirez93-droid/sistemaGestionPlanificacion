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
        Schema::table('ods_metas', function (Blueprint $table) {
        $table->unsignedInteger('numero')->after('id'); // o después de la columna que prefieras
        $table->unique('numero'); // si debe ser único globalmente
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ods_metas', function (Blueprint $table) {
            //
        });
    }
};