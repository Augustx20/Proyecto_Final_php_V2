<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Listado de Médicos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href="{{ route('medicos.create') }}" class="mb-4 inline-block px-4 py-2 bg-green-600 text-white rounded">
                        Nuevo Médico
                    </a>

                    <table class="w-full table-auto">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border">Nombre</th>
                                <th class="px-4 py-2 border">Apellido</th>
                                <th class="px-4 py-2 border">Especialidad</th>
                                <th class="px-4 py-2 border">Disponible</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($medicos as $medico)
                            <tr>
                                <td class="px-4 py-2 border">{{ $medico->nombre }}</td>
                                <td class="px-4 py-2 border">{{ $medico->apellido }}</td>
                                <td class="px-4 py-2 border">{{ $medico->especialidad }}</td>
                                <td class="px-4 py-2 border">{{ $medico->disponible ? 'Sí' : 'No' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $medicos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
