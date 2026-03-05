<?php

namespace App\Http\Controllers;

use App\Models\Turno;
use App\Models\Medico;
use App\Http\Requests\StoreTurnoRequest;
use Illuminate\Http\Request;

class TurnoController extends Controller
{
    /**
     * Muestra un listado del recurso.
     */
    public function index()
    {
        $query = Turno::query();

        // Si es paciente, solo ve sus turnos
        if(auth()->user()->role === 'paciente'){
            $query->where('user_id', auth()->id());
        }

        // Si es doctor, solo los turnos asignados a su perfil
        if(auth()->user()->role === 'doctor'){
            $query->where('medico_id', auth()->user()->medico_id);
        }

        // Filtro por fecha si existe en la URL
        if(request('fecha')){
            $query->where('fecha', request('fecha'));
        }

        $turnos = $query->with('medico')
                        ->orderBy('fecha', 'asc')
                        ->orderBy('hora', 'asc')
                        ->paginate(10);

        // calcular totales para el dashboard
        $total = Turno::count();
        $pendientes = Turno::where('estado', 'pendiente')->count();
        $confirmados = Turno::where('estado', 'confirmado')->count();

        return view('turnos.index', compact(
            'turnos',
            'total',
            'pendientes',
            'confirmados'
        ));
    }

    /**
     * Muestra el formulario para crear un nuevo recurso.
     */
    public function create()
    {
        $medicos = Medico::where('disponible', true)->get();

        return view('turnos.create', compact('medicos'));
    }

    /**
     * Almacena un recurso recién creado en el almacenamiento.
     */
    public function store(StoreTurnoRequest $request)
    {
        // Adición: volver a comprobar solapamiento en el controlador para
        // dar un mensaje personalizado (el Request ya tiene la regla unique).
        $existeTurno = Turno::where('fecha', $request->fecha)
            ->where('hora', $request->hora)
            ->exists();

        if ($existeTurno) {
            return back()->withErrors([
                'hora' => 'Ese horario ya está reservado.'
            ])->withInput();
        }

        Turno::create([
            ...$request->validated(),
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('turnos.index')->with('success', 'Turno creado correctamente.');
    }

    /**
     * Muestra el recurso especificado.
     */
    public function show(Turno $turno)
    {
        $this->authorize('view', $turno);

        return view('turnos.show', compact('turno'));
    }

    /**
     * Muestra el formulario para editar el recurso especificado.
     */
    public function edit(Turno $turno)
    {
        $this->authorize('view', $turno);

        $medicos = Medico::all();
        return view('turnos.edit', compact('turno', 'medicos'));
    }

    /**
     * Actualiza el recurso especificado en el almacenamiento.
     */
    public function update(StoreTurnoRequest $request, Turno $turno)
    {
        $this->authorize('update', $turno);

        $turno->update($request->validated());

        return redirect()->route('turnos.index')
            ->with('success', 'Turno actualizado correctamente');
    }

    /**
     * Elimina el recurso especificado del almacenamiento.
     */
    public function destroy(Turno $turno)
    {
        $this->authorize('delete', $turno);

        $turno->delete();

        return redirect()->route('turnos.index')
            ->with('success', 'Turno eliminado correctamente');
    }

    /**
     * Confirma el turno (solo administrador).
     */
    public function confirmar(Turno $turno)
    {
        // Solo los administradores deben acceder a esta ruta; el middleware lo maneja
        $turno->update(['estado' => 'confirmado']);

        return back()->with('success', 'Turno confirmado');
    }

    /**
     * Cancela el turno (usuario o administrador cuando está pendiente).
     */
    public function cancelar(Turno $turno)
    {
        // Reutilizar política de actualización para que propietarios/administradores o médicos puedan actuar
        $this->authorize('update', $turno);

        // Solo cancelar si aún está pendiente
        if ($turno->estado !== 'pendiente') {
            return back()->with('error', 'Solo se pueden cancelar turnos pendientes.');
        }

        $turno->update(['estado' => 'cancelado']);

        return back()->with('success', 'Turno cancelado correctamente.');
    }

    /**
     * Marca el turno como finalizado (doctor o administrador).
     */
    public function finalizar(Turno $turno)
    {
        $this->authorize('update', $turno);

        $turno->update(['estado' => 'finalizado']);

        return back();
    }

    /**
     * El doctor puede reasignar el turno a otro médico.
     */
    public function derivar(Request $request, Turno $turno)
    {
        $request->validate([
            'nuevo_medico_id' => 'required|exists:medicos,id',
        ]);

        $this->authorize('update', $turno);

        // Obtener el médico actual y el nuevo médico
        $medicoActual = $turno->medico;
        $nuevoMedico = Medico::findOrFail($request->nuevo_medico_id);

        // Validar que ambos médicos sean de la misma especialidad
        if ($medicoActual->especialidad !== $nuevoMedico->especialidad) {
            return back()->with('error', 'No se puede derivar a un médico de otra especialidad. El médico actual es de ' . $medicoActual->especialidad . ' y el médico seleccionado es de ' . $nuevoMedico->especialidad . '.');
        }

        // Validar que no sea el mismo médico
        if ($request->nuevo_medico_id == $turno->medico_id) {
            return back()->with('error', 'No puedes derivar a el mismo médico.');
        }

        $turno->update([
            'medico_id' => $request->nuevo_medico_id,
        ]);

        return back()->with('success', 'Turno derivado exitosamente a ' . $nuevoMedico->nombre . ' ' . $nuevoMedico->apellido . '.');
    }
}
