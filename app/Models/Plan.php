<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use SoftDeletes;
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