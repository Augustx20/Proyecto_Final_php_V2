@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-blue-100 via-blue-300 to-blue-500">
    <div class="bg-white bg-opacity-90 rounded-xl shadow-lg p-10 max-w-4xl w-full text-center">
        <h1 class="text-4xl font-bold text-blue-700 mb-4">Listado de Médicos</h1>
        <a href="{{ route('medicos.create') }}" class="mb-6 inline-block px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700 font-semibold transition">Nuevo Médico</a>
        <div class="overflow-x-auto">
            <table class="table-auto w-full mt-4 border rounded-lg shadow">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="px-4 py-2 border">Nombre</th>
                        <th class="px-4 py-2 border">Apellido</th>
                        <th class="px-4 py-2 border">Especialidad</th>
                        <th class="px-4 py-2 border">Disponible</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($medicos as $medico)
                    <tr class="hover:bg-blue-50">
                        <td class="px-4 py-2 border">{{ $medico->nombre }}</td>
                        <td class="px-4 py-2 border">{{ $medico->apellido }}</td>
                        <td class="px-4 py-2 border">{{ $medico->especialidad }}</td>
                        <td class="px-4 py-2 border">
                            @if($medico->disponible)
                                <span class="text-green-600 font-semibold">Sí</span>
                            @else
                                <span class="text-red-600 font-semibold">No</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $medicos->links() }}
        </div>
    </div>
</div>
@endsection
