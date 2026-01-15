<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('plan_indicadores', function (Blueprint $table) {
            $table->id();

            $table->foreignId('plan_id')
                ->constrained('planes')
                ->cascadeOnDelete();

            $table->string('nombre', 255);
            $table->text('descripcion')->nullable();

            $table->string('unidad_medida', 50)->nullable();
            $table->decimal('linea_base', 18, 2)->nullable();
            $table->decimal('meta', 18, 2)->nullable();

            $table->enum('frecuencia', ['MENSUAL', 'TRIMESTRAL', 'SEMESTRAL', 'ANUAL'])->nullable();
            $table->string('fuente', 255)->nullable();

            $table->enum('estado', ['ACTIVO', 'INACTIVO'])->default('ACTIVO');

            $table->timestamps();
            $table->softDeletes();

            // Evitar duplicar indicadores por plan
            $table->unique(['plan_id', 'nombre'], 'indicadores_unique_plan_nombre');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plan_indicadores');
    }
};