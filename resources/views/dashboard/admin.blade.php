<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Panel Administrador</h1>

        <p class="mb-4">Aquí puedes gestionar todos los turnos del sistema.</p>

        <a href="{{ route('turnos.index') }}"
           class="bg-blue-500 text-white px-4 py-2 rounded">
           Ver todos los turnos
        </a>
    </div>
</x-app-layout>
