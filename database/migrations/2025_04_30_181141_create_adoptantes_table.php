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
        Schema::create('adoptantes', function (Blueprint $table) {
            $table->id();
            $table->string('ruta_foto');
            $table->string('pais');
            $table->string('nacionalidad');
            $table->string('estado_civil');
            $table->string('nivel_educativo');
            $table->string('ocupacion');
            $table->float('ingresos_mensuales');
            $table->timestamps();

             // Llave foránea
             $table->unsignedBigInteger('user_id');
             $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adoptantes');
    }
};
