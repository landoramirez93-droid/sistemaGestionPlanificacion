<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Auditoria extends Model
{
    use HasFactory;

    protected $table = 'auditorias';

    protected $fillable = [
        'user_id',
        'entidad_id',
        'modulo',
        'accion',
        'tabla',
        'registro_id',
        'descripcion',
        'antes',
        'despues',
        'url',
        'metodo',
        'ip',
        'user_agent',
    ];
    
    protected $casts = [
        'antes' => 'array',
        'despues' => 'array',
        'registro_id' => 'integer',
        'user_id' => 'integer',
        'entidad_id' => 'integer',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function entidad()
    {
        return $this->belongsTo(Entidad::class);
    }
}