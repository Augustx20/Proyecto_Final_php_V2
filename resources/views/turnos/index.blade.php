@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-blue-100 via-blue-300 to-blue-500">
    <div class="bg-white bg-opacity-90 rounded-xl shadow-lg p-10 max-w-4xl w-full text-center">
        <h1 class="text-4xl font-bold text-blue-700 mb-4">Mis Turnos</h1>
        <div class="flex justify-between items-center mb-6">
            <a href="{{ route('turnos.create') }}" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-semibold transition">Crear Turno</a>
            <form method="GET" action="{{ route('turnos.index') }}" class="flex items-center gap-2">
                <input type="date" name="fecha" value="{{ request('fecha') }}" class="border px-2 py-1 rounded">
                <button type="submit" class="bg-gray-500 text-white px-3 py-1 rounded">Filtrar</button>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="table-auto w-full mt-4 border rounded-lg shadow">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-4 py-2">Fecha</th>
                        <th class="border px-4 py-2">Hora</th>
                        <th class="border px-4 py-2">Médico</th>
                        <th class="border px-4 py-2">Descripción</th>
                        <th class="border px-4 py-2">Estado</th>
                        <th class="border px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($turnos as $turno)
                    <tr class="hover:bg-blue-50">
                        <td class="border px-4 py-2">{{ $turno->fecha }}</td>
                        <td class="border px-4 py-2">{{ $turno->hora }}</td>
                        <td class="border px-4 py-2">{{ $turno->medico->nombre }} {{ $turno->medico->apellido }}</td>
                        <td class="border px-4 py-2">{{ $turno->descripcion }}</td>
                        <td class="border px-4 py-2">
                            @if($turno->estado === 'pendiente')
                                <span class="text-yellow-600 font-semibold">Pendiente</span>
                            @elseif($turno->estado === 'confirmado')
                                <span class="text-green-600 font-semibold">Confirmado</span>
                            @else
                                <span>{{ ucfirst($turno->estado) }}</span>
                            @endif
                        </td>
                        <td class="border px-4 py-2 text-sm space-y-1">
                            @if(auth()->user()->role === 'admin')
                                <div class="flex flex-wrap gap-1">
                                    <a href="{{ route('turnos.edit', $turno) }}" class="text-yellow-500 font-semibold hover:underline">Editar</a>
                                    <form action="{{ route('turnos.confirmar', $turno) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button class="text-green-500 font-semibold hover:underline">Confirmar</button>
                                    </form>
                                    <form action="{{ route('turnos.destroy', $turno) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-500 font-semibold hover:underline" onclick="return confirm('¿Seguro que desea eliminar el turno?')">Eliminar</button>
                                    </form>
                                </div>
                            @elseif(auth()->user()->role === 'paciente' && $turno->estado === 'pendiente')
                                <form action="{{ route('turnos.cancelar', $turno) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button class="text-red-500 font-semibold hover:underline" onclick="return confirm('¿Seguro que desea cancelar este turno?')">Cancelar</button>
                                </form>
                            @elseif(auth()->user()->role === 'doctor')
                                <div class="flex flex-wrap gap-1">
                                    <form action="{{ route('turnos.finalizar', $turno) }}" method="POST" class="inline">
                                        @csrf
                                        <button class="text-blue-500 font-semibold hover:underline">Finalizar</button>
                                    </form>
                                    <button onclick="openDerivModal({{ $turno->id }})" class="text-purple-500 font-semibold hover:underline">Derivar</button>
                                </div>
                            @else
                                <span class="text-gray-500">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $turnos->links() }}
        </div>
    </div>
</div>

<!-- Modal de derivación -->
<div id="derivModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full mx-4">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Seleccionar Doctor</h2>
        <form id="derivForm" method="POST" action="">
            @csrf
            <input type="hidden" id="turnoId" name="turno_id">
            <div class="mb-4">
                <label for="medico" class="block text-sm font-semibold text-gray-700 mb-2">Doctor disponible:</label>
                <select id="medico" name="nuevo_medico_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Seleccionar doctor --</option>
                    @foreach(\App\Models\Medico::where('disponible', true)->get() as $medico)
                        <option value="{{ $medico->id }}">{{ $medico->nombre }} {{ $medico->apellido }} ({{ $medico->especialidad }})</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-4">
                <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                    Derivar
                </button>
                <button type="button" onclick="closeDerivModal()" class="flex-1 px-4 py-2 bg-gray-400 text-white rounded-lg font-semibold hover:bg-gray-500 transition">
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openDerivModal(turnoId) {
        document.getElementById('derivModal').classList.remove('hidden');
        document.getElementById('turnoId').value = turnoId;
        document.getElementById('derivForm').action = `/turnos/${turnoId}/derivar`;
    }
    
    function closeDerivModal() {
        document.getElementById('derivModal').classList.add('hidden');
    }
    
    // Cerrar modal al hacer clic fuera de él
    document.getElementById('derivModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDerivModal();
        }
    });
</script>
@endsection
