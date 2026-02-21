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
        if (auth()->user()->role === 'admin') {
                $turnos = Turno::paginate(5);
            } else {
                $turnos = Turno::where('user_id', auth()->id())
                                ->paginate(5);
            }

            return view('turnos.index', compact('turnos'));
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
    public function update(Request $request, Turno $turno)
    {
        $this->authorize('view', $turno);

        // validation and update logic would go here
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Turno $turno)
    {
        $this->authorize('view', $turno);

        $turno->delete();
        return redirect()->route('turnos.index');
    }
}
