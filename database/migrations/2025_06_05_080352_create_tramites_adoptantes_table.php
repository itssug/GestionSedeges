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
        Schema::create('tramites_adoptantes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tramite_id');
            $table->unsignedBigInteger('adoptante_id');
            $table->unsignedBigInteger('documento_adoptante_id');

            $table->timestamps();

            //fks
            $table->foreign('tramite_id')->references('id')->on('tramites');
            $table->foreign('adoptante_id')->references('id')->on('adoptantes');
            $table->foreign('documento_adoptante_id')->references('id')->on('documentos_adoptantes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tramites_adoptantes');
    }
};
