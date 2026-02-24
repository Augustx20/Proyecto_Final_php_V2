<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Medico;

class Turno extends Model
{
    protected $fillable = [
        'fecha',
        'hora',
        'descripcion',
        'medico_id',
        'user_id',
        'estado'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }
}
