<?php

namespace App\Http\Controllers;

use App\Models\ObjetivoEstrategico;
use App\Models\OdsMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OdsMetaController extends Controller
{
    public function index(Request $request)
    {
        $q = OdsMeta::query()->latest();

        if ($request->filled('estado')) {
            $q->where('estado', (string) $request->input('estado'));
        }

        if ($request->filled('search')) {
            $s = (string) $request->input('search');
            $q->where(function ($w) use ($s) {
                $w->where('codigo', 'like', "%{$s}%")
                  ->orWhere('descripcion', 'like', "%{$s}%");
            });
        }

        $metas = $q->paginate(10)->withQueryString();

        return view('ods.metas.index', compact('metas'));
    }

    public function create()
    {
        $objetivos = ObjetivoEstrategico::orderBy('id')->get(['id','descripcion']);
        return view('ods.metas.create', compact('objetivos'));
    }

    public function store(Request $request)
    {
        $data = $this->validateOdsMeta($request);

        return DB::transaction(function () use ($data) {

            $meta = OdsMeta::create([
                'codigo' => $data['codigo'] ?? null,
                'descripcion' => $data['descripcion'],
                'anio_referencia' => $data['anio_referencia'] ?? null,
                'estado' => $data['estado'],
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]);

            $meta->objetivos()->sync($data['objetivo_ids'] ?? []);

            return redirect()->route('ods.metas.index')->with('success', 'Meta ODS creada correctamente.');
        });
    }

    public function show(OdsMeta $meta)
    {
        $meta->load(['objetivos','planes']);
        return view('ods.metas.show', compact('meta'));
    }

    public function edit(OdsMeta $meta)
    {
        $meta->load('objetivos');
        $objetivos = ObjetivoEstrategico::orderBy('id')->get(['id','descripcion']);

        return view('ods.metas.edit', compact('meta','objetivos'));
    }

    public function update(Request $request, OdsMeta $meta)
    {
        $data = $this->validateOdsMeta($request, $meta->id);

        return DB::transaction(function () use ($data, $meta) {

            $meta->update([
                'codigo' => $data['codigo'] ?? null,
                'descripcion' => $data['descripcion'],
                'anio_referencia' => $data['anio_referencia'] ?? null,
                'estado' => $data['estado'],
                'updated_by' => auth()->id(),
            ]);

            $meta->objetivos()->sync($data['objetivo_ids'] ?? []);

            return redirect()->route('ods.metas.index')->with('success', 'Meta ODS actualizada correctamente.');
        });
    }

    public function destroy(OdsMeta $meta)
    {
        $meta->delete();
        return redirect()->route('ods.metas.index')->with('success', 'Meta ODS eliminada (soft delete).');
    }

    private function validateOdsMeta(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'codigo' => ['nullable','string','max:50'],
            'descripcion' => ['required','string'],
            'anio_referencia' => ['nullable','integer','min:1900','max:2100'],
            'estado' => ['required','in:ACTIVA,INACTIVA'],

            'objetivo_ids' => ['nullable','array'],
            'objetivo_ids.*' => ['integer','exists:objetivos_estrategicos,id'],
        ]);
    }

}