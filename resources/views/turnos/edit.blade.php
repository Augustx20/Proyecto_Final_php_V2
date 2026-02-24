<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Editar turno</h1>

        <form action="{{ route('turnos.update', $turno) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- mostrar errores de validación como en la vista de creación --}}
            @if($errors->any())
                <div class="mb-4 text-red-600">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group">
                <label for="fecha">Fecha</label>
                <input id="fecha"
                       type="date"
                       name="fecha"
                       value="{{ old('fecha', $turno->fecha) }}"
                       class="form-control">
            </div>

            <div class="form-group">
                <label for="hora">Hora</label>
                <input id="hora"
                       type="time"
                       name="hora"
                       value="{{ old('hora', $turno->hora) }}"
                       class="form-control">
            </div>

            <div class="form-group">
                <label for="medico_id">Médico</label>
                <select id="medico_id" name="medico_id" class="form-control">
                    <option value="">Seleccione un médico</option>
                    @foreach($medicos as $medico)
                        <option value="{{ $medico->id }}" {{ $turno->medico_id == $medico->id ? 'selected' : '' }}>
                            {{ $medico->nombre }} {{ $medico->apellido }} - {{ $medico->especialidad }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <input id="descripcion"
                       type="text"
                       name="descripcion"
                       value="{{ old('descripcion', $turno->descripcion) }}"
                       class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>
</x-app-layout>
