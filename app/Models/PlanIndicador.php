<?php

namespace App\Models;

use App\Traits\RegistraAuditoria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanIndicador extends Model
{
    use SoftDeletes, RegistraAuditoria;

    protected $table = 'plan_indicadores';

    protected $fillable = [
        'plan_id',
        'nombre',
        'descripcion',
        'unidad_medida',
        'linea_base',
        'meta',
        'frecuencia',
        'fuente',
        'estado',
    ];

    // Config auditoría (si tu trait las usa)
    protected array $auditExclude = ['password', 'remember_token'];
    protected array $auditIgnore = ['updated_at', 'created_at', 'deleted_at'];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}