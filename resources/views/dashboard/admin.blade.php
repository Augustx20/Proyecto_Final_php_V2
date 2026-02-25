@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-blue-100 via-blue-300 to-blue-500">
    <div class="bg-white bg-opacity-90 rounded-xl shadow-lg p-10 max-w-xl w-full text-center">
        <h1 class="text-4xl font-bold text-blue-700 mb-4">Panel Administrador</h1>
        <p class="text-lg text-gray-700 mb-6">Gestioná todos los turnos y usuarios del sistema.</p>
        <div class="flex justify-center gap-4 mb-6">
            <a href="{{ route('turnos.index') }}" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-semibold transition">Ver todos los turnos</a>
        </div>
        <div class="mt-6 text-gray-600 text-sm">
            <span>Acceso rápido a reportes, gestión de médicos y pacientes.</span>
        </div>
    </div>
</div>
@endsection
