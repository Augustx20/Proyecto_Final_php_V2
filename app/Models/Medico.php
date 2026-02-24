<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Turno;

class Medico extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'apellido',
        'especialidad',
    ];

    /**
     * Relationship: a médico tiene muchos turnos.
     */
    public function turnos()
    {
        return $this->hasMany(Turno::class);
    }
}
