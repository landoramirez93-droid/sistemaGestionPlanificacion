<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entidad extends Model
{
    protected $table = 'entidades';

    protected $fillable = ['nombre', 'tipo', 'estado'];

    protected $casts = [
        'estado' => 'boolean',
    ];
}