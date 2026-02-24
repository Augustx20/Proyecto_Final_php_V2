<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TurnoController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('turnos', TurnoController::class);

    // admin-only confirmation action for a turno
    Route::patch('/turnos/{turno}/confirmar', [TurnoController::class, 'confirmar'])
        ->name('turnos.confirmar')
        ->middleware('role:admin');

    // administración de médicos (solo administradores)
    Route::middleware('role:admin')->group(function () {
        Route::resource('medicos', App\Http\Controllers\MedicoController::class);
    });

    // allow owner or admin to cancel pending turnos
    Route::patch('/turnos/{turno}/cancelar', [TurnoController::class, 'cancelar'])
        ->name('turnos.cancelar');

    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('dashboard.admin');
        }

        return redirect()->route('dashboard.paciente');
    })->name('dashboard');

    Route::get('/dashboard/admin', function () {
        return view('dashboard.admin');
    })->name('dashboard.admin')->middleware('role:admin');

    Route::get('/dashboard/paciente', function () {
        return view('dashboard.paciente');
    })->name('dashboard.paciente');
});

Route::view('/info', 'info')->name('info');

use Illuminate\Http\Request;

Route::post('/contacto', function (Request $request) {

    $request->validate([
        'nombre' => 'required|string|max:100',
        'email' => 'required|email',
        'mensaje' => 'required|string|max:500',
    ]);

    return back()->with('success', 'Mensaje enviado correctamente.');

})->name('contacto.enviar');


use App\Http\Controllers\ProfileController;

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';
