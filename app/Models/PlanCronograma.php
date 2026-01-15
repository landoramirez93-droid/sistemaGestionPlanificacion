<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanCronograma extends Model
{
    use SoftDeletes;

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

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}