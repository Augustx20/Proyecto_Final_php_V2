@extends('layouts.app')

@section('content')
    <h1>Editar turno</h1>

    <form action="{{ route('turnos.update', $turno) }}" method="POST">
        @csrf
        @method('PUT')

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
            <label for="descripcion">Descripción</label>
            <input id="descripcion"
                   type="text"
                   name="descripcion"
                   value="{{ old('descripcion', $turno->descripcion) }}"
                   class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
@endsection
