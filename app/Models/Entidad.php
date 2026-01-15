<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entidad extends Model
{
    use SoftDeletes;

    protected $table = 'entidades';

    protected $fillable = [
        'nombre',
        'sigla',
        'tipo',
        'nivel',
        'estado',
    ];

    // Relación: una entidad tiene muchos objetivos
    public function objetivosEstrategicos()
    {
        return $this->hasMany(ObjetivoEstrategico::class, 'entidad_id');
    }
}