@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-blue-100 via-blue-300 to-blue-500">
    <div class="bg-white bg-opacity-90 rounded-xl shadow-lg p-10 max-w-xl w-full text-center">
        <img src="https://cdn-icons-png.flaticon.com/512/2965/2965567.png" alt="Swiiss Médicos Logo" class="mx-auto w-24 h-24 mb-4">
        <h1 class="text-4xl font-bold text-blue-700 mb-2">Swiiss Médicos</h1>
        <p class="text-lg text-gray-700 mb-6">Tu consultorio médico digital. Agenda turnos, gestiona tu perfil y accede a atención profesional de manera fácil y segura.</p>
        <div class="flex justify-center gap-4 mb-6">
            <a href="{{ route('login') }}" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-semibold transition">Ingresar</a>
            <a href="{{ route('register') }}" class="px-6 py-2 bg-white border border-blue-600 text-blue-600 rounded hover:bg-blue-50 font-semibold transition">Registrarse</a>
        </div>
        <div class="mt-6">
            <h2 class="text-xl font-semibold text-blue-800 mb-2">¿Por qué elegirnos?</h2>
            <ul class="text-left text-gray-600 mx-auto max-w-xs">
                <li class="mb-2 flex items-center"><span class="mr-2 text-blue-500">&#10003;</span> Atención personalizada</li>
                <li class="mb-2 flex items-center"><span class="mr-2 text-blue-500">&#10003;</span> Gestión de turnos online</li>
                <li class="mb-2 flex items-center"><span class="mr-2 text-blue-500">&#10003;</span> Seguridad y privacidad</li>
                <li class="mb-2 flex items-center"><span class="mr-2 text-blue-500">&#10003;</span> Acceso a profesionales certificados</li>
            </ul>
        </div>
    </div>
    <footer class="mt-10 text-white text-sm opacity-80">
        &copy; {{ date('Y') }} Swiiss Médicos. Todos los derechos reservados.
    </footer>
</div>
@endsection
