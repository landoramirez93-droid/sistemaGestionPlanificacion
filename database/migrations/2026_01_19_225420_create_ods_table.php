<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ods', function (Blueprint $table) {
            $table->id();

            // N°
            $table->unsignedTinyInteger('numero')->unique();

            // objetivo
            $table->string('objetivo', 255);

            // descripcion / meta / observacion (textos largos)
            $table->longText('descripcion')->nullable();
            $table->longText('meta')->nullable();
            $table->longText('observacion')->nullable();

            // presupuesto: numérico (define tú la unidad: USD, miles, millones, etc.)
            $table->unsignedBigInteger('presupuesto')->nullable();

            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ods');
    }
};