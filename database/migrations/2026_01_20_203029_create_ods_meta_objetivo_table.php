<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ods_meta_objetivo', function (Blueprint $table) {
            $table->unsignedBigInteger('ods_meta_id');
            $table->unsignedBigInteger('objetivo_estrategico_id');
            $table->timestamps();

            $table->primary(['ods_meta_id', 'objetivo_estrategico_id']);

            $table->foreign('ods_meta_id')->references('id')->on('ods_metas')->onDelete('cascade');
            $table->foreign('objetivo_estrategico_id')->references('id')->on('objetivos_estrategicos')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ods_meta_objetivo');
    }
};