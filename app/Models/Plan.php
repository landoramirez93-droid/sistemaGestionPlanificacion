<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\RegistraAuditoria;
use Laravel\Boost\Concerns\ReadsLogs;

class Plan extends Model
{
    use SoftDeletes, RegistraAuditoria;
     protected $table = 'planes';

    protected $fillable = [
        'codigo',
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
    protected array $auditIgnore = ['updated_at', 'created_at', 'deleted_at'];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    public function metas()
    {
        return $this->hasMany(PlanMeta::class);
    }

    public function indicadores()
    {
        return $this->hasMany(PlanIndicador::class);
    }

    public function cronogramas()
    {
        return $this->hasMany(PlanCronograma::class);
    }
}