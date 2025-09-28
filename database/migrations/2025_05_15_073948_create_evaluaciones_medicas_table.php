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
        Schema::create('evaluaciones_medicas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('diagnostico');
            $table->text('recomendaciones');
            $table->boolean('tratamiento');
            $table->text('observaciones');
            $table->timestamps();
            //fks

            $table->unsignedBigInteger('nna_id');
            $table->foreign('nna_id')->references('id')->on('nnas');

            $table->unsignedBigInteger('personal_sedeges_id');
            $table->foreign('personal_sedeges_id')->references('id') -> on('personal_sedeges');

            $table->unsignedBigInteger('documentos_nna_id');
            $table->foreign('documentos_nna_id')->references('id')-> on('documentos_nnas');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluaciones_medicas');
    }
};
