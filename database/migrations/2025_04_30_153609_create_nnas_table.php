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
        Schema::create('nnas', function (Blueprint $table) {
            $table->id();
            $table->string('cod_nna');
            $table->string('identificacion', 20)->nullable();
            $table->string('tipo_identificacion')->nullable();
            $table->string('nombres');
            $table->string('apellidos');
            $table->date('fecha_nac');
            $table->string('sexo');
            $table->string('nacionalidad')->nullable();
            $table->string('situacion_juridica');
            $table->date('fecha_ingreso')->nullable();
            $table->date('fecha_salida')->nullable();
            $table->string('nivel_educativo')->nullable();
            $table->text('observaciones')->nullable();
            $table->text('ruta_foto')->nullable();
            $table->string('motivo_ingreso')->nullable();
            $table->boolean('discapacidad')->default(false);
            $table->string('tipo_discapacidad')->nullable();
            $table->boolean('estado')->default(true);
            
            // Llave foránea
            $table->unsignedBigInteger('centro_id')->nullable();
            $table->foreign('centro_id')->references('id')->on('centros');
            
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nnas');
    }
};
