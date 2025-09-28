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
        Schema::create('documentos_nnas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('tipo');
            $table->string('descripcion');
            $table->string('estado');
            $table->string ('url');
            $table->date('fecha_emision');
            $table->timestamps();

            //llave fk
            $table->unsignedBigInteger('nna_id');
            $table->foreign('nna_id')->references('id')->on('nnas');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos_nnas');
    }
};
