<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    protected $fillable = [
        'user_id',
        'fecha',
        'hora',
        'descripcion'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
