<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Entidad;

class ObjetivosEstrategicos extends Model
{
    use SoftDeletes;

    protected $table = 'objetivos_estrategicos';

    protected $fillable = [
        'codigo',
        'descripcion',
        'horizonte',
        'linea_estrategica',
        'entidad_id',
        'estado',
    ];

    protected $casts = [
        'estado' => 'boolean',
    ];

    public function entidad(): BelongsTo
    {
        return $this->belongsTo(Entidad::class, 'entidad_id');
    }
    public function upload(Request $request)
{
    $request->validate([
        'archivo' => 'required|mimes:pdf,xlsx|max:5120'
    ]);

    $archivo = $request->file('archivo');

    // Guarda en storage/app/objetivos
    $ruta = $archivo->store('objetivos');

    return back()->with('success', 'Archivo cargado correctamente: ' . $ruta);
}

}