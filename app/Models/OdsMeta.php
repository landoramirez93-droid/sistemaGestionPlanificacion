<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OdsMeta extends Model
{
    use SoftDeletes;

    protected $table = 'ods_metas';

    protected $fillable = [
        'codigo','descripcion','anio_referencia','estado','created_by','updated_by'
    ];

    public function objetivos()
    {
        return $this->belongsToMany(
            ObjetivoEstrategico::class,
            'ods_meta_objetivo',
            'ods_meta_id',
            'objetivo_estrategico_id'
        )->withTimestamps();
    }

    // Si ya creaste el pivote plan_ods_meta del módulo Plan:
    public function planes()
    {
        return $this->belongsToMany(
            Plan::class,
            'plan_ods_meta',
            'ods_meta_id',
            'plan_id'
        )->withTimestamps();
    }
}