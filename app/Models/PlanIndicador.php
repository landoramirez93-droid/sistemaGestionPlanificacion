<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanIndicador extends Model
{
    use SoftDeletes;

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

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}