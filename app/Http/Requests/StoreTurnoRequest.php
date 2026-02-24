<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTurnoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // any authenticated user may create a turno
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
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
                Rule::unique('turnos')->where(function ($query) {
                    return $query->where('fecha', request('fecha'));
                })->ignore($this->turno?->id),
                function ($attribute, $value, $fail) {
                    if ($value < '08:00' || $value > '18:00') {
                        $fail('El turno debe estar dentro del horario laboral.');
                    }
                },
            ],
            'descripcion' => 'required|min:5|max:255',
            'medico_id' => 'required|exists:medicos,id'
        ];
    }
}
