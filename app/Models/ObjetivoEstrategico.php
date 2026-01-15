<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ObjetivoEstrategico extends Model
{
    use SoftDeletes;

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