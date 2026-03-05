<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTurnoRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a hacer esta solicitud.
     */
    public function authorize(): bool
    {
        // Cualquier usuario autenticado puede crear un turno
        return auth()->check();
    }

    /**
     * Obtiene las reglas de validación que se aplican a la solicitud.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fecha' => 'required|date|after_or_equal:today',

            'hora' => [
                'required',
                'date_format:H:i',

                Rule::unique('turnos')
                    ->where(function ($query) {
                        return $query
                            ->where('fecha', request('fecha'))
                            ->where('medico_id', request('medico_id'));
                    })
                    ->ignore($this->turno?->id),

                // minuto 00 o 30 solamente
                function ($attribute, $value, $fail) {
                    $minutos = explode(':', $value)[1] ?? null;
                    if (!in_array($minutos, ['00', '30'])) {
                        $fail('La hora debe ser en punto o y media.');
                    }
                },

                // horario laboral
                function ($attribute, $value, $fail) {
                    if ($value < '08:00' || $value > '18:00') {
                        $fail('El turno debe estar dentro del horario laboral.');
                    }
                },
            ],

            'descripcion' => 'required|min:5|max:255',

            'medico_id' => [
                'required',
                Rule::exists('medicos', 'id')
                    ->where('disponible', true),
            ],
        ];
    }
}