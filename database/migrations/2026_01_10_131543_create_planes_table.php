<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('planes', function (Blueprint $table) {
            $table->id();

            $table->string('codigo', 50)->nullable()->index();
            $table->string('nombre', 255);
            $table->text('descripcion')->nullable();

            $table->date('fecha_inicio');
            $table->date('fecha_fin');

            $table->unsignedInteger('version')->default(1);

            $table->enum('estado', ['BORRADOR', 'EN_REVISION', 'APROBADO', 'INACTIVO'])->default('BORRADOR');

            // Si ya tienes tabla entidades, queda perfecto. Si no, déjalo nullable sin FK o comenta la línea constrained.
            $table->foreignId('entidad_id')->nullable()->constrained('entidades')->nullOnDelete();

            // Responsable del plan (usuario)
            $table->foreignId('responsable_id')->nullable()->constrained('users')->nullOnDelete();

            // Auditoría (quién creó / actualizó)
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            // Control de duplicados: nombre + periodo + versión
            $table->unique(['nombre', 'fecha_inicio', 'fecha_fin', 'version'], 'planes_unique_nombre_periodo_version');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('planes');
    }
};