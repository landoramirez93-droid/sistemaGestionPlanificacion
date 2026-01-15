<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\RegistraAuditoria;

class Proyecto extends Model
{
    use SoftDeletes, RegistraAuditoria;

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'programa_id',
        'estado',
        'presupuesto',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'presupuesto' => 'decimal:2',
    ];

    // Configuración de auditoría (si tu trait las usa)
    protected array $auditExclude = ['password', 'remember_token'];
    protected array $auditIgnore  = ['updated_at', 'created_at', 'deleted_at'];

    public function programa(): BelongsTo
    {
        return $this->belongsTo(Programa::class);
    }
}