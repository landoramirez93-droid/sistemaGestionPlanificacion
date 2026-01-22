<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    // Auditoría (según tu trait)
    protected array $auditExclude = ['password', 'remember_token'];
    protected array $auditIgnore  = ['updated_at', 'created_at', 'deleted_at'];

    /**
     * Entidad responsable (FK: entidad_id).
     * Esta es la relación que estás usando en el Controller: with('entidadResponsable')
     */
    public function entidadResponsable(): BelongsTo
    {
        return $this->belongsTo(Entidad::class, 'entidad_id');
    }

    /**
     * Metas ODS vinculadas (pivot: ods_meta_objetivo).
     * Esta es la relación que estás usando: with('odsMetas.ods')
     */
    public function odsMetas(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
{
        return $this->belongsToMany(
            OdsMeta::class,
            'ods_meta_objetivo',
            'objetivo_estrategico_id',
            'ods_meta_id'
        )->withTimestamps();
    }
    

}