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
     * Relation with user account when the médico has a user.
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }
}
