<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('programas', function (Blueprint $table) {
            $table->id();

            $table->string('nombre', 180);
            $table->text('descripcion')->nullable();

            $table->date('fecha_inicio');
            $table->date('fecha_fin');

            // Responsable (puedes cambiar a tu tabla/llave real)
            $table->foreignId('responsable_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Estado simple (ajusta a tu catálogo si ya existe)
            $table->string('estado', 20)->default('ACTIVO'); // ACTIVO / INACTIVO / ELIMINADO (lógico)

            $table->timestamps();
            $table->softDeletes();

            // Duplicados: mismo nombre + mismo periodo (inicio/fin)
            $table->unique(['nombre', 'fecha_inicio', 'fecha_fin'], 'uq_programa_nombre_periodo');

            $table->index(['estado']);
            $table->index(['responsable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programas');
    }
};