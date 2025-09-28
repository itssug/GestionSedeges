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
        Schema::table('tramites_adoptantes', function (Blueprint $table) {
            // Hacer que documento_adoptante_id sea nullable
            $table->unsignedBigInteger('documento_adoptante_id')->nullable()->change();

            // Agregar campo estado
            $table->boolean('estado')->default(false)->after('documento_adoptante_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tramites_adoptantes', function (Blueprint $table) {
            // Revertir estado
            $table->dropColumn('estado');

            // Hacer que documento_adoptante_id vuelva a ser NOT NULL
            $table->unsignedBigInteger('documento_adoptante_id')->nullable(false)->change();
        });
    }
};
