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
        Schema::create('personal_sedeges', function (Blueprint $table) {
            $table->id();
            $table->string('especialidad');
            $table->string('area');
            $table->date('fecha_ingreso');
            $table->unsignedInteger('anios_antiguedad')->nullable(); // o calcularlo dinámicamente
            $table->boolean('estado')->default(true);
            $table->string('horario_laboral')->nullable();
            $table->string('foto')->nullable();

            // Llave foránea
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('roles_personal_id');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('roles_personal_id')->references('id')->on('roles_personals');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_sedeges');
    }
};
