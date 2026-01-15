<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('plan_metas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('plan_id')
                ->constrained('planes')
                ->cascadeOnDelete();

            $table->string('nombre', 255);
            $table->text('descripcion')->nullable();

            $table->decimal('valor_objetivo', 18, 2)->nullable();
            $table->string('unidad_medida', 50)->nullable();

            $table->enum('estado', ['ACTIVA', 'INACTIVA'])->default('ACTIVA');

            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Evitar duplicar metas por plan
            $table->unique(['plan_id', 'nombre'], 'metas_unique_plan_nombre');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plan_metas');
    }
};