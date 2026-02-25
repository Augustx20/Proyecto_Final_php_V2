@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-blue-100 via-blue-300 to-blue-500">
    <div class="bg-white bg-opacity-90 rounded-xl shadow-lg p-10 max-w-xl w-full text-center">
        <h1 class="text-4xl font-bold text-blue-700 mb-4">Panel Paciente</h1>
        <p class="text-lg text-gray-700 mb-6">Gestioná tus turnos y perfil.</p>
        <div class="flex justify-center gap-4 mb-6">
            <a href="{{ route('turnos.index') }}" class="px-6 py-2 bg-green-500 text-white rounded hover:bg-green-600 font-semibold transition">Ver mis turnos</a>
        </div>
        <div class="mt-6 text-gray-600 text-sm">
            <span>Podés solicitar nuevos turnos y ver tu historial.</span>
        </div>
    </div>
</div>
@endsection
