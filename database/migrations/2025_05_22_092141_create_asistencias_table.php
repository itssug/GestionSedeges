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
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->boolean('asistencia')->default(0);
            $table->timestamps();

            //llaves foraneas
            $table->unsignedBigInteger('sesion_id');
            $table->foreign('sesion_id')->references('id')->on('sesiones')->onDelete('cascade');
            $table->unsignedBigInteger('adoptante_id');
            $table->foreign('adoptante_id')->references('id')->on('adoptantes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
