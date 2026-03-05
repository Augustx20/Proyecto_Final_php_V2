<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Turno;

class Medico extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'apellido',
        'especialidad',
        'disponible',
    ];

    /**
     * Relationship: a médico tiene muchos turnos.
     */
    public function turnos()
    {
        return $this->hasMany(Turno::class);
    }

    /**
     * Relación con cuenta de usuario cuando el médico tiene un usuario.
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }
}
