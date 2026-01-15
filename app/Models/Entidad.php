<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\RegistraAuditoria;


class Entidad extends Model
{
    use SoftDeletes, RegistraAuditoria;

    protected $table = 'entidades';

    protected $fillable = [
        'nombre',
        'sigla',
        'tipo',
        'nivel',
        'estado',
    ];

    // Config auditoría (si tu trait las usa)
    protected array $auditExclude = ['password', 'remember_token'];
    protected array $auditIgnore = ['updated_at', 'created_at', 'deleted_at'];

    // Relación: una entidad tiene muchos objetivos
    public function objetivosEstrategicos()
    {
        return $this->hasMany(ObjetivoEstrategico::class, 'entidad_id');
    }
}