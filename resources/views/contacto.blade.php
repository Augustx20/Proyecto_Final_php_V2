<x-app-layout>
    <div class="p-6 max-w-xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Contacto</h1>

        @if(session('success'))
            <div class="bg-green-200 text-green-800 p-2 rounded mb-3">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('contacto.enviar') }}">
            @csrf

            <div class="mb-3">
                <label>Nombre</label>
                <input type="text" name="nombre" class="border rounded w-full">
                @error('nombre')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="border rounded w-full">
                @error('email')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label>Mensaje</label>
                <textarea name="mensaje" class="border rounded w-full"></textarea>
                @error('mensaje')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <button class="bg-blue-500 text-white px-4 py-2 rounded">
                Enviar
            </button>
        </form>
    </div>
</x-app-layout>
