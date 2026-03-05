@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-blue-100 via-blue-300 to-blue-500">
    <div class="bg-white bg-opacity-90 rounded-xl shadow-lg p-10 max-w-md w-full text-center">
        <h1 class="text-3xl font-bold text-blue-700 mb-4">Crear Turno</h1>
        <form action="{{ route('turnos.store') }}" method="POST" class="text-left">
            @csrf
            @if($errors->any())
                <div class="mb-4 text-red-600">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-1">Fecha</label>
                <input type="date" name="fecha" class="border rounded w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-1">Hora</label>
                <select name="hora" class="border rounded w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    @for ($h = 8; $h <= 18; $h++)
                        <option value="{{ sprintf('%02d:00', $h) }}" {{ old('hora') == sprintf('%02d:00', $h) ? 'selected' : '' }}>
                            {{ sprintf('%02d:00', $h) }}
                        </option>
                        <option value="{{ sprintf('%02d:30', $h) }}" {{ old('hora') == sprintf('%02d:30', $h) ? 'selected' : '' }}>
                            {{ sprintf('%02d:30', $h) }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-1">Médico</label>
                <select name="medico_id" class="border rounded w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    @foreach($medicos as $medico)
                        <option value="{{ $medico->id }}">{{ $medico->nombre }} {{ $medico->apellido }} ({{ $medico->especialidad }})</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-1">Descripción</label>
                <textarea name="descripcion" class="border rounded w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" rows="3" required>{{ old('descripcion') }}</textarea>
            </div>
            <button type="submit" class="w-full py-2 px-4 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700 transition">Crear Turno</button>
        </form>
    </div>
</div>
@endsection
