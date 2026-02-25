@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-blue-100 via-blue-300 to-blue-500">
    <div class="bg-white bg-opacity-90 rounded-xl shadow-lg p-10 max-w-md w-full text-center">
        <img src="https://cdn-icons-png.flaticon.com/512/2965/2965567.png" alt="Swiiss Médicos Logo" class="mx-auto w-20 h-20 mb-4">
        <h1 class="text-3xl font-bold text-blue-700 mb-2">Verificar email</h1>
        <p class="text-gray-600 mb-6">Gracias por registrarte. Por favor, verificá tu email haciendo clic en el enlace que te enviamos.</p>
        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                Se envió un nuevo enlace de verificación a tu email.
            </div>
        @endif
        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="py-2 px-4 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700 transition">Reenviar email de verificación</button>
            </form>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="underline text-sm text-blue-600 hover:text-blue-800 rounded-md">Salir</button>
            </form>
        </div>
    </div>
    <footer class="mt-10 text-white text-sm opacity-80">
        &copy; {{ date('Y') }} Swiiss Médicos. Todos los derechos reservados.
    </footer>
</div>
@endsection
