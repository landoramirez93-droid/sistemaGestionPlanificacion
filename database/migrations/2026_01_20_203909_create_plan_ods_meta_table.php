<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('plan_ods_meta', function (Blueprint $table) {
            $table->id();

            $table->foreignId('plan_id')
                ->constrained('planes')
                ->cascadeOnDelete();

            $table->foreignId('ods_meta_id')
                ->constrained('ods_metas')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique(['plan_id', 'ods_meta_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plan_ods_meta');
    }
};