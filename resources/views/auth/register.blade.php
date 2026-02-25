@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-blue-100 via-blue-300 to-blue-500">
    <div class="bg-white bg-opacity-90 rounded-xl shadow-lg p-10 max-w-md w-full text-center">
        <img src="https://cdn-icons-png.flaticon.com/512/2965/2965567.png" alt="Swiiss Médicos Logo" class="mx-auto w-20 h-20 mb-4">
        <h1 class="text-3xl font-bold text-blue-700 mb-2">Registrarse</h1>
        <p class="text-gray-600 mb-6">Creá tu cuenta para acceder a Swiiss Médicos</p>
        <form method="POST" action="{{ route('register') }}" class="text-left">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-semibold mb-1">Nombre</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                @error('name')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-semibold mb-1">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                @error('email')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-semibold mb-1">Contraseña</label>
                <input id="password" type="password" name="password" required autocomplete="new-password" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                @error('password')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700 font-semibold mb-1">Confirmar contraseña</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                @error('password_confirmation')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="w-full py-2 px-4 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700 transition">Registrarse</button>
        </form>
        <div class="mt-6 text-gray-600 text-sm">
            ¿Ya tenés cuenta?
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-semibold">Ingresar</a>
        </div>
    </div>
    <footer class="mt-10 text-white text-sm opacity-80">
        &copy; {{ date('Y') }} Swiiss Médicos. Todos los derechos reservados.
    </footer>
</div>
@endsection
