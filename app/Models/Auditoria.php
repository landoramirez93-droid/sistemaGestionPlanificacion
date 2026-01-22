<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Auditoria extends Model
{
    use HasFactory;

    protected $table = 'auditorias';
    // Define explícitamente el nombre de la tabla en la base de datos.
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

    // Relación de auditoría pertenece a un usuario.
    // Permite: $auditoria->user y eager loading con with('user').

    public function entidad()
    {
        return $this->belongsTo(Entidad::class);
    }
    // Relación de auditoría pertenece a una entidad.
    // Permite: $auditoria->entidad y eager loading con with('entidad').
    
}