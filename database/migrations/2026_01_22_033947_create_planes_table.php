<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ods_meta_plan', function (Blueprint $table) {
            $table->id();

            $table->foreignId('plan_id')->constrained('planes');
            $table->foreignId('ods_meta_id')->constrained('ods_metas');

            // Si quieres amarrar además a un objetivo estratégico concreto (opcional)
            $table->foreignId('objetivo_estrategico_id')
                ->nullable()
                ->constrained('objetivos_estrategicos');

            $table->decimal('presupuesto', 14, 2)->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();

            // Ajusta a tu estándar (ej. BORRADOR/EN_REVISION/APROBADO/INACTIVO)
            $table->string('estado', 20)->default('BORRADOR');

            $table->text('detalle')->nullable();
            $table->unsignedTinyInteger('porcentaje_avance')->default(0); // 0..100

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['plan_id', 'ods_meta_id']); // evita duplicados por plan/meta
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ods_meta_plan');
    }
};