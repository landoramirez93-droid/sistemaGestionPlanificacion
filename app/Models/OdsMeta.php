<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\RegistraAuditoria;


class OdsMeta extends Model
{
    use SoftDeletes, RegistraAuditoria;

    protected $table = 'ods_metas';

    protected $fillable = [
        'codigo','descripcion','anio_referencia','estado','created_by','updated_by'
    ];

    // Config auditoría (si tu trait las usa)
    protected array $auditExclude = ['password', 'remember_token'];
    protected array $auditIgnore = ['updated_at', 'created_at', 'deleted_at'];

    public function objetivos()
    {
        return $this->belongsToMany(
            ObjetivoEstrategico::class,
            'ods_meta_objetivo',
            'ods_meta_id',
            'objetivo_estrategico_id'
        )->withTimestamps();
    }

    // Si ya creaste el pivote plan_ods_meta del módulo Plan:
    public function planes()
    {
        return $this->belongsToMany(
            Plan::class,
            'plan_ods_meta',
            'ods_meta_id',
            'plan_id'
        )->withTimestamps();
    }
}