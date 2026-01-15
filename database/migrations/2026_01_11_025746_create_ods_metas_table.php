<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ods_metas', function (Blueprint $table) {
            $table->id();

            $table->string('codigo', 30)->unique();  // ej: ODS-01-1
            $table->string('nombre', 255);
            $table->text('descripcion')->nullable();
            $table->unsignedTinyInteger('ods_numero')->nullable(); // 1..17

            $table->boolean('estado')->default(true);

            $table->timestamps();
            $table->softDeletes(); // 👈 esto crea deleted_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ods_metas');
    }
};