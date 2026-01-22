<?php

namespace App\Http\Controllers;

use App\Models\Entidad;
use App\Models\ObjetivoEstrategico;
use App\Models\OdsMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ObjetivoEstrategicoController extends Controller
{
    /**
     * Listar objetivos estratégicos
     */
    public function index()
    {
        $objetivos = ObjetivoEstrategico::with([
                'entidadResponsable',
                'odsMetas',
            ])
            ->latest()
            ->paginate(10);

        return view('objetivos.index', compact('objetivos'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        $entidades = Entidad::orderBy('id')->get();
        $odsMetas  = OdsMeta::orderBy('ods_numero')->orderBy('numero')->get();

        return view('objetivos.create', compact('entidades', 'odsMetas'));
    }

    /**
     * Guardar objetivo estratégico
     */
    public function store(Request $request)
    {
        $validated = $this->validateObjetivo($request);

        DB::transaction(function () use ($validated) {

            $objetivo = ObjetivoEstrategico::create([
                'nombre'            => $validated['nombre'],
                'descripcion'       => $validated['descripcion'],
                'linea_estrategica' => $validated['linea_estrategica'],
                'entidad_id'        => $validated['entidad_id'],
                'estado'            => $validated['estado'],
            ]);

            // Sync metas ODS (si no viene, usa [])
            $objetivo->odsMetas()->sync($validated['ods_meta_ids'] ?? []);
        });

        return redirect()
            ->route('objetivos.index')
            ->with('success', 'Objetivo estratégico registrado correctamente.');
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(ObjetivoEstrategico $objetivo)
    {
        $objetivo->load(['odsMetas', 'entidadResponsable']);

        $entidades = Entidad::orderBy('id')->get();
        $odsMetas  = OdsMeta::orderBy('ods_numero')->orderBy('numero')->get();

        return view('objetivos.edit', compact('objetivo', 'entidades', 'odsMetas'));
    }

    /**
     * Actualizar objetivo estratégico
     */
    public function update(Request $request, ObjetivoEstrategico $objetivo)
    {
        $validated = $this->validateObjetivo($request);

        DB::transaction(function () use ($validated, $objetivo) {

            $objetivo->update([
                'nombre'            => $validated['nombre'],
                'descripcion'       => $validated['descripcion'],
                'linea_estrategica' => $validated['linea_estrategica'],
                'entidad_id'        => $validated['entidad_id'],
                'estado'            => $validated['estado'],
            ]);

            $objetivo->odsMetas()->sync($validated['ods_meta_ids'] ?? []);
        });

        return redirect()
            ->route('objetivos.index')
            ->with('success', 'Objetivo estratégico actualizado correctamente.');
    }

    /**
     * Eliminar objetivo estratégico
     */
    public function destroy(ObjetivoEstrategico $objetivo)
    {
        $objetivo->delete();

        return back()->with('success', 'Objetivo estratégico eliminado correctamente.');
    }

    /**
     * Validación centralizada (store/update)
     */
    private function validateObjetivo(Request $request): array
    {
        return $request->validate([
            'nombre'            => ['required', 'string', 'max:255'],
            'descripcion'       => ['required', 'string'],
            'linea_estrategica' => ['required', 'string', 'max:255'],
            'entidad_id'        => ['required', 'exists:entidades,id'],
            'estado'            => ['required', 'boolean'],

            // Metas ODS seleccionadas (checkbox/multiselect)
            'ods_meta_ids'      => ['nullable', 'array'],
            'ods_meta_ids.*'    => ['integer', 'exists:ods_metas,id'],
        ]);
    }
}