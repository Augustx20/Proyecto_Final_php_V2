<?php

namespace App\Http\Controllers;

use App\Models\Turno;
use Illuminate\Http\Request;

class TurnoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $turnos = Turno::where('user_id', auth()->id())
                        ->paginate(5);

        return view('turnos.index', compact('turnos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
        'fecha' => 'required|date',
        'hora' => 'required',
        'descripcion' => 'required|string|max:255',
    ]);

    Turno::create([
        'user_id' => auth()->id(),
        'fecha' => $validated['fecha'],
        'hora' => $validated['hora'],
        'descripcion' => $validated['descripcion'],
    ]);

    return redirect()->route('turnos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Turno $turno)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Turno $turno)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Turno $turno)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Turno $turno)
    {
        //
    }
}
