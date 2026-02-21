<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Panel Paciente</h1>

        <p class="mb-4">Aquí puedes gestionar tus turnos.</p>

        <a href="{{ route('turnos.index') }}"
           class="bg-green-500 text-white px-4 py-2 rounded">
           Ver mis turnos
        </a>
    </div>
</x-app-layout>
