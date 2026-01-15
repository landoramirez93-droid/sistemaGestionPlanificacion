<?php

namespace App\Models;

use App\Traits\RegistraAuditoria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class PlanCronograma extends Model
{
    use SoftDeletes, RegistraAuditoria;

    protected $table = 'plan_cronogramas';

    protected $fillable = [
        'plan_id',
        'actividad',
        'detalle',
        'responsable_id',
        'fecha_inicio',
        'fecha_fin',
        'porcentaje',
        'estado',
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