<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreMedicoRequest;

class MedicoController extends Controller
{
    /**
     * Muestra un listado del recurso.
     */
    public function index()
    {
        $medicos = Medico::paginate(10);
        return view('medicos.index', compact('medicos'));
    }

    /**
     * Muestra el formulario para crear un nuevo recurso.
     */
    public function create()
    {
        return view('medicos.create');
    }

    /**
     * Cambia la disponibilidad del doctor autenticado (desde el formulario de la barra de navegación).
     */
    public function toggle()
    {
        $medico = Medico::findOrFail(auth()->user()->medico_id);
        $medico->update([ 'disponible' => ! $medico->disponible ]);

        return back();
    }

    /**
     * Almacena un recurso recién creado en el almacenamiento.
     */
    public function store(StoreMedicoRequest $request)
    {
        DB::transaction(function () use ($request) {
            $medico = Medico::create([
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'especialidad' => $request->especialidad,
                'disponible' => true,
            ]);

            User::create([
                'name' => $request->nombre . ' ' . $request->apellido,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'doctor',
                'medico_id' => $medico->id,
            ]);
        });

        return redirect()->route('medicos.index')
            ->with('success', 'Médico creado correctamente');
    }
}
