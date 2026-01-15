<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\RegistraAuditoria;

class PlanMeta extends Model
{
    use SoftDeletes, RegistraAuditoria;

    protected $table = 'plan_metas';

    protected $fillable = [
        'plan_id',
        'nombre',
        'descripcion',
        'valor_objetivo',
        'unidad_medida',
        'estado',
        'fecha_inicio',
        'fecha_fin',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    // Config auditoría (si tu trait las usa)
    protected array $auditExclude = ['password', 'remember_token'];
    protected array $auditIgnore = ['updated_at', 'created_at', 'deleted_at'];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}