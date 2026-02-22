<?php

namespace App\Http\Controllers;

use App\Models\Turno;
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

        $turnos = $query->orderBy('fecha', 'asc')
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
        //return "Estoy en create";
        return view('turnos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTurnoRequest $request)
    {
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

        return view('turnos.edit', compact('turno'));
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
}
