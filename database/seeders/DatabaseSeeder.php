<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Siembra la base de datos de la aplicación.
     */
    public function run(): void
    {
        // Crear o actualizar usuarios de prueba de forma idempotente
        User::updateOrCreate([
            'email' => 'test@example.com',
        ], [
            'name' => 'Test User',
            'password' => Hash::make('password'),
            'role' => 'paciente',
        ]);

        User::updateOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Admin User',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Médico de ejemplo (en caso de que quieras probar el flujo del médico rápidamente)
        $doc = \App\Models\Medico::firstOrCreate([
            'nombre' => 'Doctor',
            'apellido' => 'Sample',
            'especialidad' => 'General',
        ], ['disponible' => true]);

        User::updateOrCreate([
            'email' => 'doctor@example.com',
        ], [
            'name' => 'Dr Sample',
            'password' => Hash::make('password'),
            'role' => 'doctor',
            'medico_id' => $doc->id,
        ]);
    }
}
