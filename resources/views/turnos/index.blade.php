<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Mis Turnos</h1>

        <a href="{{ route('turnos.create') }}" 
           class="bg-blue-500 text-white px-4 py-2 rounded">
           Crear Turno
        </a>

        <form method="GET" action="{{ route('turnos.index') }}" class="mb-3 mt-4">
            <input type="date" name="fecha" value="{{ request('fecha') }}" class="border px-2 py-1">
            <button type="submit" class="bg-gray-500 text-white px-3 py-1 rounded">Filtrar</button>
        </form>

        <table class="table-auto w-full mt-4 border">
            <thead>
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
                <tr>
                    <td class="border px-4 py-2">{{ $turno->fecha }}</td>
                    <td class="border px-4 py-2">{{ $turno->hora }}</td>
                    <td class="border px-4 py-2">{{ $turno->medico->nombre }} {{ $turno->medico->apellido }}</td>
                    <td class="border px-4 py-2">{{ $turno->descripcion }}</td>
                    <td class="border px-4 py-2">
                        @if($turno->estado === 'pendiente')
                            <span class="text-yellow-600">Pendiente</span>
                        @elseif($turno->estado === 'confirmado')
                            <span class="text-green-600">Confirmado</span>
                        @else
                            <span>{{ ucfirst($turno->estado) }}</span>
                        @endif
                    </td>
                    <td class="border px-4 py-2">
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('turnos.edit', $turno) }}" 
                               class="text-yellow-500">Editar</a>

                            <form action="{{ route('turnos.confirmar', $turno) }}" method="POST" class="inline mr-2">
                                @csrf
                                @method('PATCH')
                                <button class="text-green-500">
                                    Confirmar
                                </button>
                            </form>

                            <form action="{{ route('turnos.destroy', $turno) }}" 
                                  method="POST" 
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-500" onclick="return confirm('¿Seguro que desea eliminar el turno?')">
                                    Eliminar
                                </button>
                            </form>
                        @endif

                        @if(auth()->user()->role === 'paciente' && $turno->estado === 'pendiente')
                            <form action="{{ route('turnos.cancelar', $turno) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button onclick="return confirm('¿Desea cancelar el turno?')">
                                    Cancelar
                                </button>
                            </form>
                        @endif

                        @if(auth()->user()->role === 'doctor' && $turno->medico_id === auth()->user()->medico_id)
                            <form action="{{ route('turnos.finalizar', $turno) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-blue-500">Finalizar</button>
                            </form>

                            @if($turno->estado === 'pendiente')
                                <form action="{{ route('turnos.cancelar', $turno) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button class="text-red-500" onclick="return confirm('¿Desea cancelar el turno?')">Cancelar</button>
                                </form>
                            @endif

                            <form action="{{ route('turnos.derivar', $turno) }}" method="POST" class="inline">
                                @csrf
                                <select name="nuevo_medico_id" class="border px-1 py-0">
                                    @foreach(App\Models\Medico::all() as $med)
                                        @if($med->id !== $turno->medico_id)
                                            <option value="{{ $med->id }}">{{ $med->nombre }} {{ $med->apellido }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <button type="submit" class="text-purple-500">Derivar</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $turnos->links() }}
        </div>
    </div>
</x-app-layout>
