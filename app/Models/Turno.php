<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    protected $fillable = [
        'fecha',
        'hora',
        'descripcion',
        'user_id',
        'estado'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
