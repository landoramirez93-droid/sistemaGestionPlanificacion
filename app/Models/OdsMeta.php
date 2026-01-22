<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\RegistraAuditoria;
use App\Models\ObjetivoEstrategico;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OdsMeta extends Model
{
    use SoftDeletes, RegistraAuditoria;

    protected $table = 'ods_metas';

    protected $fillable = [
        'numero',
        'codigo',
        'nombre',
        'objetivo',
        'descripcion',
        'meta',
        'ods_numero',
        'presupuesto',
        'observacion',
        'estado'
    ];

    protected $casts = [
        'numero' => 'integer',
        'anio_referencia' => 'integer',
        'presupuesto' => 'integer',
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

    public function plan(): BelongsToMany
    {
    return $this->belongsToMany(Plan::class, 'ods_meta_plan')
        ->withPivot([
            'objetivo_estrategico_id',
            'presupuesto',
            'fecha_inicio',
            'fecha_fin',
            'estado',
            'detalle',
            'porcentaje_avance',
            'deleted_at',
        ])
        ->withTimestamps();
    }

    
    public function planes()
    {
        return $this->belongsToMany(
            Plan::class,
            'plan_ods_meta',
            'ods_meta_id',
            'plan_id'
        )->withTimestamps();
    }

    public function objetivosEstrategico(): BelongsToMany
    {
    return $this->belongsToMany(
        ObjetivoEstrategico::class,
        'ods_meta_objetivo',
        'ods_meta_id',
        'objetivo_estrategico_id'
    )->withTimestamps();
    }

}