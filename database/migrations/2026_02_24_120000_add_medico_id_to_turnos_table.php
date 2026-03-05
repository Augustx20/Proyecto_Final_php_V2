<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta las migraciones.
     */
    public function up(): void
    {
        Schema::table('turnos', function (Blueprint $table) {
            $table->foreignId('medico_id')
                  ->constrained('medicos')
                  ->onDelete('cascade');
        });
    }

    /**
     * Revierte las migraciones.
     */
    public function down(): void
    {
        Schema::table('turnos', function (Blueprint $table) {
            $table->dropForeign(['medico_id']);
            $table->dropColumn('medico_id');
        });
    }
};
