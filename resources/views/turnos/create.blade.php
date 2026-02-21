<x-app-layout>
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Crear Turno</h1>

    <form action="{{ route('turnos.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Fecha</label>
            <input type="date" name="fecha" class="border rounded w-full">
        </div>

        <div class="mb-3">
            <label>Hora</label>
            <input type="time" name="hora" class="border rounded w-full">
        </div>

        <div class="mb-3">
            <label>Descripción</label>
            <input type="text" name="descripcion" class="border rounded w-full">
        </div>

        <button class="bg-green-500 text-white px-4 py-2 rounded">
            Guardar
        </button>
    </form>
</div>
</x-app-layout>
