<?php

namespace App\Http\Controllers;

use App\Models\ObjetivoEstrategico;
use App\Models\OdsMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class OdsMetaController extends Controller
{
    /**
     * Lista metas ODS con filtros (estado) y búsqueda (codigo/descripcion).
     */
    public function index(Request $request)
    {
        $q = OdsMeta::query()->latest(); // Inicia query ordenada por los registros más recientes (created_at desc)

        if ($request->filled('search')) {
        $s = trim((string) $request->input('search'));
        $q->where(function ($w) use ($s) {
            $w->where('codigo', 'like', "%{$s}%")
            ->orWhere('objetivo', 'like', "%{$s}%")
            ->orWhere('descripcion', 'like', "%{$s}%");

            if (is_numeric($s)) {
                $w->orWhere('numero', (int) $s);
            }
        });
    }

        $metas = $q->paginate(10)->withQueryString(); // Pagina resultados y conserva los parámetros del querystring (filtros/búsqueda)

        return view('ods.metas.index', compact('metas')); // Retorna la vista del listado
    }

    /**
     * Muestra el formulario para crear una nueva meta ODS.
     */
    public function create()
    {
        $objetivos = ObjetivoEstrategico::orderBy('id')->get(['id','descripcion']); // Carga objetivos estratégicos (id, descripcion) para mostrarlos en el formulario (checkbox/select)
        return view('ods.metas.create', compact('objetivos'));  // Retorna vista de creación con los objetivos disponibles
    }

    /**
     * Guarda una nueva meta ODS y sincroniza su relación con objetivos estratégicos.
     */

    public function store(Request $request)
    {
            $data = $request->validate([
                'ods_numero'  => ['required','integer','min:1','max:17'],

                'numero' => [
                    'required','integer','min:1',
                    Rule::unique('ods_metas', 'numero')
                        ->where(fn($q) => $q->where('ods_numero', $request->input('ods_numero'))),
                ],

                'codigo'      => ['required','string','max:30','unique:ods_metas,codigo'],
                'nombre'      => ['required','string','max:255'],
                'objetivo'    => ['nullable','string'],
                'descripcion' => ['nullable','string'],
                'meta'        => ['nullable','string'],
                'estado'      => ['required','boolean'],
                'presupuesto' => ['nullable','string','max:50'],
                'observacion' => ['nullable','string'],
            ]);

        $data['presupuesto'] = $this->normalizePresupuesto($data['presupuesto'] ?? null);

        OdsMeta::create($data);

        return redirect()->route('ods.metas.index')
            ->with('success', 'Meta ODS creada correctamente.');
    }


    /**
     * Muestra el detalle de una meta ODS, cargando relaciones necesarias.
     */
    public function show(OdsMeta $ods_meta)
    {
        $ods_meta->load(['objetivos','planes']); // Carga relaciones para evitar N+1 en la vista (objetivos, planes)
        return view('ods.metas.show', compact('ods_meta')); // Retorna vista de detalle
    }
    
    /**
     * Muestra el formulario de edición para una meta ODS existente.
     */
    public function edit(OdsMeta $ods_meta)
    {
    $ods_meta->load('objetivos');
    $objetivos = ObjetivoEstrategico::orderBy('id')->get(['id','descripcion']);

    return view('ods.metas.edit', [
        'meta' => $ods_meta,
        'objetivos' => $objetivos,
    ]);
    }

    public function update(Request $request, OdsMeta $ods_meta)
    {
        $data = $this->validateOdsMeta($request, $ods_meta->id);

        return DB::transaction(function () use ($data, $ods_meta) {

            $ods_meta->update([
                // ✅ importante: actualizar ods_numero
                'ods_numero' => $data['ods_numero'],

                'numero' => $data['numero'],
                'codigo' => $data['codigo'] ?? null,
                'objetivo' => $data['objetivo'],
                'descripcion' => $data['descripcion'],
                'meta' => $data['meta'],
                'presupuesto' => $this->normalizePresupuesto($data['presupuesto'] ?? null),
                'observacion' => $data['observacion'] ?? null,
                'anio_referencia' => $data['anio_referencia'] ?? null,
                'estado' => $data['estado'],
                'updated_by' => auth()->id(),
            ]);

            $ods_meta->objetivos()->sync($data['objetivo_ids'] ?? []);

            return redirect()->route('ods.metas.index')
                ->with('success', 'Meta ODS actualizada correctamente.');
        });
    }

    public function destroy(OdsMeta $ods_meta)
    {
    $ods_meta->delete();

    return redirect()->route('ods.metas.index')
        ->with('success', 'Meta ODS eliminada (soft delete).');
    }
    /**
     * Valida datos de entrada para create/update de Meta ODS.
     * Centraliza reglas para no duplicar lógica entre store y update.
     */
    private function validateOdsMeta(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'ods_numero' => ['required','integer','min:1','max:17'],

            'numero' => [
            'required','integer','min:1', Rule::unique('ods_metas', 'numero')
                    ->where(fn($q) => $q->where('ods_numero', $request->input('ods_numero')))
                    ->ignore($id),
            ],
            
            'codigo' => ['nullable','string','max:50'],
            'objetivo' => ['required','string','max:255'],
            'descripcion' => ['required','string'],
            'meta' => ['required','string'],

            // Acepta "557000" o "557.000" o "557,000" (se normaliza a entero)
            'presupuesto' => ['nullable','string','max:50'],
            'observacion' => ['nullable','string'],

            'anio_referencia' => ['nullable','integer','min:1900','max:2100'],
            'estado' => ['required','boolean'],

            'objetivo_ids' => ['nullable','array'],
            'objetivo_ids.*' => ['integer','exists:objetivos_estrategicos,id'],
        ]);
    }

    private function normalizePresupuesto(?string $value): ?int
    {
        if ($value === null) return null;

        $v = trim($value);
        if ($v === '') return null;

        // Quita todo lo que no sea dígito (sirve para 557.000 / 557,000 / 557 000)
        $digits = preg_replace('/\D+/', '', $v);

        return $digits === '' ? null : (int) $digits;
    }
}