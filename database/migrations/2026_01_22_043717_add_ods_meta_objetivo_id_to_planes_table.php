<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('planes', function (Blueprint $table) {
            $table->foreignId('ods_meta_objetivo_id')
                ->nullable()
                ->after('estado')
                ->constrained('ods_metas')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('planes', function (Blueprint $table) {
            $table->dropForeign(['ods_meta_objetivo_id']);
            $table->dropColumn('ods_meta_objetivo_id');
        });
    }
};