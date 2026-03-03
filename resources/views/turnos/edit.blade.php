@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-blue-100 via-blue-300 to-blue-500 py-12">
    <div class="bg-white bg-opacity-95 rounded-xl shadow-2xl p-10 max-w-2xl w-full">
        <h1 class="text-4xl font-bold text-blue-700 mb-8 text-center">Editar Turno</h1>
        
        @if ($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                <h3 class="font-semibold mb-2">Errores en el formulario:</h3>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('turnos.update', $turno) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Fecha -->
            <div>
                <label for="fecha" class="block text-sm font-semibold text-gray-700 mb-2">Fecha</label>
                <input 
                    type="date" 
                    id="fecha"
                    name="fecha"
                    value="{{ old('fecha', $turno->fecha) }}"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition @error('fecha') border-red-500 @enderror"
                />
                @error('fecha')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Hora -->
            <div>
                <label for="hora" class="block text-sm font-semibold text-gray-700 mb-2">Hora</label>
                <select 
                    id="hora" 
                    name="hora" 
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition @error('hora') border-red-500 @enderror"
                >
                    <option value="">-- Seleccionar hora --</option>
                    @for ($h = 8; $h <= 18; $h++)
                        @php
                            $val1 = sprintf('%02d:00', $h);
                            $val2 = sprintf('%02d:30', $h);
                        @endphp
                        <option value="{{ $val1 }}" {{ old('hora', $turno->hora) == $val1 ? 'selected' : '' }}>
                            {{ $val1 }}
                        </option>
                        <option value="{{ $val2 }}" {{ old('hora', $turno->hora) == $val2 ? 'selected' : '' }}>
                            {{ $val2 }}
                        </option>
                    @endfor
                </select>
                @error('hora')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Médico -->
            <div>
                <label for="medico_id" class="block text-sm font-semibold text-gray-700 mb-2">Médico</label>
                <select 
                    id="medico_id" 
                    name="medico_id" 
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition @error('medico_id') border-red-500 @enderror"
                >
                    <option value="">-- Seleccionar médico --</option>
                    @foreach($medicos as $medico)
                        <option value="{{ $medico->id }}" {{ $turno->medico_id == $medico->id ? 'selected' : '' }}>
                            {{ $medico->nombre }} {{ $medico->apellido }} - {{ $medico->especialidad }}
                        </option>
                    @endforeach
                </select>
                @error('medico_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Descripción -->
            <div>
                <label for="descripcion" class="block text-sm font-semibold text-gray-700 mb-2">Descripción</label>
                <textarea 
                    id="descripcion"
                    name="descripcion"
                    rows="4"
                    placeholder="Descripción del turno"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition @error('descripcion') border-red-500 @enderror"
                >{{ old('descripcion', $turno->descripcion) }}</textarea>
                @error('descripcion')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botones -->
            <div class="flex gap-4 pt-6">
                <button 
                    type="submit" 
                    class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    Actualizar Turno
                </button>
                <a 
                    href="{{ route('turnos.index') }}" 
                    class="flex-1 px-6 py-3 bg-gray-400 text-white rounded-lg font-semibold hover:bg-gray-500 transition text-center focus:outline-none focus:ring-2 focus:ring-gray-500"
                >
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
