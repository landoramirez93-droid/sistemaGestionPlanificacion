<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('ods_metas', function (Blueprint $table) {
            $table->unsignedBigInteger('presupuesto')->nullable()->after('meta'); 
            // o after('descripcion') según tu orden preferido
        });
    }

    public function down(): void
    {
        Schema::table('ods_metas', function (Blueprint $table) {
            $table->dropColumn('presupuesto');
        });
    }
};