<?php

namespace App\Models;

use App\Models\OdsMeta;
use App\Traits\RegistraAuditoria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Plan extends Model
{
    use SoftDeletes, RegistraAuditoria;

    protected $table = 'planes';

    protected $fillable = [
        'codigo',
        'objetivo_estrategico_id',
        'ods_meta_objetivo_id',     // IMPORTANTE: si existe en tu tabla planes
        'nombre',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'version',
        'estado',
        'entidad_id',
        'responsable_id',
        'created_by',
        'updated_by',
    ];

    // Config auditoría (si tu trait las usa)
    protected array $auditExclude = ['password', 'remember_token'];
    protected array $auditIgnore  = ['updated_at', 'created_at', 'deleted_at'];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin'    => 'date',
    ];

    /* =========================
     * Relaciones internas del Plan
     * ========================= */

    public function metas(): HasMany
    {
        return $this->hasMany(PlanMeta::class);
    }

    public function indicadores(): HasMany
    {
        return $this->hasMany(PlanIndicador::class);
    }

    public function cronogramas(): HasMany
    {
        return $this->hasMany(PlanCronograma::class);
    }

    public function objetivoEstrategico(): BelongsTo
    {
        return $this->belongsTo(ObjetivoEstrategico::class, 'objetivo_estrategico_id');
    }

    /* =========================
     * ODS
     * ========================= */

    /**
     * Metas ODS múltiples (N:M) vía tabla pivote.
     * Si tu pivote tiene campos adicionales, se declaran en withPivot().
     */
    public function odsMetas(): BelongsToMany
    {
        return $this->belongsToMany(
                OdsMeta::class,
                'ods_meta_plan',   // pivote
                'plan_id',         // FK en pivote hacia planes
                'ods_meta_id'      // FK en pivote hacia ods_metas
            )
            ->withPivot([
                'objetivo_estrategico_id',
                'presupuesto',
                'fecha_inicio',
                'fecha_fin',
                'estado',
                'detalle',
                'porcentaje_avance',
                'deleted_at', // solo si realmente existe en tu pivote
            ])
            ->withTimestamps();
    }

    /**
     * Meta ODS principal/objetivo (1:1 inversa) guardada como FK en planes.
     */
    public function odsMetaObjetivo(): BelongsTo
    {
        return $this->belongsTo(OdsMeta::class, 'ods_meta_objetivo_id');
    }
}