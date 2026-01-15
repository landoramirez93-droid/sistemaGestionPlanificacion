<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('plan_cronogramas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('plan_id')
                ->constrained('planes')
                ->cascadeOnDelete();

            $table->string('actividad', 255);
            $table->text('detalle')->nullable();

            $table->foreignId('responsable_id')->nullable()->constrained('users')->nullOnDelete();

            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();

            $table->unsignedTinyInteger('porcentaje')->default(0); // 0..100

            $table->enum('estado', ['PENDIENTE', 'EN_PROCESO', 'CUMPLIDA', 'RETRASADA'])->default('PENDIENTE');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plan_cronogramas');
    }
};