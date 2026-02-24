<?php

namespace App\Http\Controllers;

use App\Models\Turno;
use App\Models\Medico;
use App\Http\Requests\StoreTurnoRequest;
use Illuminate\Http\Request;

class TurnoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Turno::query();

        // Si es paciente, solo ve sus turnos
        if(auth()->user()->role === 'paciente'){
            $query->where('user_id', auth()->id());
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // cargar lista de médicos para el select
        $medicos = Medico::all();
        return view('turnos.create', compact('medicos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTurnoRequest $request)
    {
        // adicional: volver a comprobar solapamiento en el controlador para
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

        return redirect()->route('turnos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Turno $turno)
    {
        $this->authorize('view', $turno);

        return view('turnos.show', compact('turno'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Turno $turno)
    {
        $this->authorize('view', $turno);

        $medicos = Medico::all();
        return view('turnos.edit', compact('turno', 'medicos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTurnoRequest $request, Turno $turno)
    {
        $this->authorize('update', $turno);

        $turno->update($request->validated());

        return redirect()->route('turnos.index')
            ->with('success', 'Turno actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Turno $turno)
    {
        $this->authorize('delete', $turno);

        $turno->delete();

        return redirect()->route('turnos.index')
            ->with('success', 'Turno eliminado correctamente');
    }

    /**
     * Confirm the turno (admin only).
     */
    public function confirmar(Turno $turno)
    {
        // only admins should hit this route; middleware handles it
        $turno->update(['estado' => 'confirmado']);

        return back()->with('success', 'Turno confirmado');
    }

    /**
     * Cancel the turno (user or admin when pending).
     */
    public function cancelar(Turno $turno)
    {
        // reuse update policy so owners/admins can act
        $this->authorize('update', $turno);

        // Only cancel if still pending
        if ($turno->estado !== 'pendiente') {
            return back()->with('error', 'Solo se pueden cancelar turnos pendientes.');
        }

        $turno->update(['estado' => 'cancelado']);

        return back()->with('success', 'Turno cancelado correctamente.');
    }
}
