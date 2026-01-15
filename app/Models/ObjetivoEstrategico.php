<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\RegistraAuditoria;

class ObjetivoEstrategico extends Model
{
    use SoftDeletes, RegistraAuditoria;

    protected $table = 'objetivos_estrategicos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'linea_estrategica',
        'entidad_id',
        'estado',
    ];
    
    protected $casts = [
    'estado' => 'boolean',
    ];

    // Config auditoría (si tu trait las usa)
    protected array $auditExclude = ['password', 'remember_token'];
    protected array $auditIgnore = ['updated_at', 'created_at', 'deleted_at'];

    public function entidad()
    {
        return $this->belongsTo(Entidad::class, 'entidad_id');
    }
    
    public function odsMetas()
    {
    return $this->belongsToMany(
        OdsMeta::class,
        'ods_meta_objetivo',
        'objetivo_estrategico_id',
        'ods_meta_id'
    )->withTimestamps();
    }

}