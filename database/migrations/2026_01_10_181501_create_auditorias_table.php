<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auditorias', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()
                ->constrained('users')->nullOnDelete();

            $table->foreignId('entidad_id')->nullable()
                ->constrained('entidades')->nullOnDelete();

            $table->string('modulo', 120)->nullable();
            $table->string('accion', 60);
            $table->string('tabla', 120)->nullable();
            $table->unsignedBigInteger('registro_id')->nullable();

            $table->text('descripcion')->nullable();

            $table->json('antes')->nullable();
            $table->json('despues')->nullable();

            $table->text('url')->nullable();
            $table->string('metodo', 12)->nullable();
            $table->string('ip', 45)->nullable();
            $table->text('user_agent')->nullable();

            $table->timestamps();

            $table->index(['tabla', 'registro_id']);
            $table->index(['accion']);
            $table->index(['created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auditorias');
    }
};