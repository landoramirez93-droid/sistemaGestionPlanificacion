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
    Schema::table('programas', function (Blueprint $table) {
        if (!Schema::hasColumn('programas', 'codigo')) {
            $table->string('codigo', 50)->nullable()->unique()->after('id');
        }
        if (!Schema::hasColumn('programas', 'fecha_inicio')) {
            $table->date('fecha_inicio')->nullable()->after('descripcion');
        }
        if (!Schema::hasColumn('programas', 'fecha_fin')) {
            $table->date('fecha_fin')->nullable()->after('fecha_inicio');
        }
        if (!Schema::hasColumn('programas', 'responsable_id')) {
            $table->foreignId('responsable_id')->nullable()->constrained('users')->nullOnDelete()->after('fecha_fin');
        }
        if (!Schema::hasColumn('programas', 'estado')) {
            $table->boolean('estado')->default(true)->after('responsable_id');
        }
        if (!Schema::hasColumn('programas', 'deleted_at')) {
            $table->softDeletes();
        }
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('programas', function (Blueprint $table) {
            //
        });
    }
};