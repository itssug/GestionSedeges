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
        Schema::create('resp_legales', function (Blueprint $table) {
            $table->id();
            $table -> string('direccion_oficina');
            $table->string('especialidad');
            $table-> boolean('estado');
            $table->string('horarios_atencion');

            $table->timestamps();


             // Llave foránea
             $table->unsignedBigInteger('user_id');
             $table->unsignedBigInteger('tipo_resp_legales_id');

             $table->foreign('user_id')->references('id')->on('users');
             $table->foreign('tipo_resp_legales_id')->references('id')->on('tipo_resp_legales');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resp_legales');
    }
};
