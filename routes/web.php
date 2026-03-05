<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TurnoController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('turnos', TurnoController::class);

    // Acción de confirmación solo para administradores de un turno
    Route::patch('/turnos/{turno}/confirmar', [TurnoController::class, 'confirmar'])
        ->name('turnos.confirmar')
        ->middleware('role:admin');

    // administración de médicos (solo administradores)
    Route::middleware('role:admin')->group(function () {
        Route::resource('medicos', App\Http\Controllers\MedicoController::class);
    });

    // el médico puede cambiar su disponibilidad desde el navbar
    Route::post('/doctor/disponibilidad', [App\Http\Controllers\MedicoController::class, 'toggle'])
        ->name('doctor.toggle')
        ->middleware('role:doctor');

    // acciones que puede llevar a cabo un doctor sobre sus turnos
    Route::middleware(['role:doctor'])->group(function () {
        Route::post('/turnos/{turno}/finalizar', [App\Http\Controllers\TurnoController::class, 'finalizar'])
            ->name('turnos.finalizar');

        Route::post('/turnos/{turno}/derivar', [App\Http\Controllers\TurnoController::class, 'derivar'])
            ->name('turnos.derivar');
    });

    // Permitir al propietario o administrador cancelar turnos pendientes
    Route::patch('/turnos/{turno}/cancelar', [TurnoController::class, 'cancelar'])
        ->name('turnos.cancelar');

    Route::get('/dashboard', function () {

        $role = auth()->user()->role;

        return match ($role) {
            'admin' => redirect()->route('dashboard.admin'),
            'doctor' => redirect()->route('dashboard.doctor'),
            default => redirect()->route('dashboard.paciente'),
        };

    })->name('dashboard');

    Route::get('/dashboard/admin', function () {
        return view('dashboard.admin');
    })->name('dashboard.admin')->middleware('role:admin');

    Route::get('/dashboard/paciente', function () {
        return view('dashboard.paciente');
    })->name('dashboard.paciente');

    Route::get('/dashboard/doctor', function () {
    return view('dashboard.doctor');
    })->name('dashboard.doctor')->middleware('role:doctor');
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
