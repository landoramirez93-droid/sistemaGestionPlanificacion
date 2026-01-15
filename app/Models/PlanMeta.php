<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanMeta extends Model
{
    use SoftDeletes;

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

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}