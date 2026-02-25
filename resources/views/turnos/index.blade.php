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
                        <td class="border px-4 py-2">
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('turnos.edit', $turno) }}" class="text-yellow-500 font-semibold mr-2">Editar</a>
                                <form action="{{ route('turnos.confirmar', $turno) }}" method="POST" class="inline mr-2">
                                    @csrf
                                    @method('PATCH')
                                    <button class="text-green-500 font-semibold">Confirmar</button>
                                </form>
                                <form action="{{ route('turnos.destroy', $turno) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-500 font-semibold" onclick="return confirm('¿Seguro que desea eliminar el turno?')">Eliminar</button>
                                </form>
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
@endsection
