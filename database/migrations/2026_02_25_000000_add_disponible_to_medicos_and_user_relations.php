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
        Schema::table('medicos', function (Blueprint $table) {
            if (! Schema::hasColumn('medicos', 'disponible')) {
                $table->boolean('disponible')->default(true);
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'medico_id')) {
                $table->foreignId('medico_id')
                      ->nullable()
                      ->constrained('medicos')
                      ->nullOnDelete();
            }

            if (! Schema::hasColumn('users', 'paciente_id')) {
                // no pacientes table exists yet; keep as unsignedBigInteger
                $table->unsignedBigInteger('paciente_id')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medicos', function (Blueprint $table) {
            if (Schema::hasColumn('medicos', 'disponible')) {
                $table->dropColumn('disponible');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'medico_id')) {
                $table->dropForeign(['medico_id']);
                $table->dropColumn('medico_id');
            }
            if (Schema::hasColumn('users', 'paciente_id')) {
                $table->dropColumn('paciente_id');
            }
        });
    }
};