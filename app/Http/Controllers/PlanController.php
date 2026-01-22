<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\OdsMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlanController extends Controller
{
    /**
     * Listado paginado de planes.
     */
    public function index()
    {
        $planes = Plan::query()
            ->with(['odsMetas', 'odsMetaObjetivo'])
            ->latest()
            ->paginate(10);

        return view('planes.index', compact('planes'));
    }

    /**
     * Muestra el formulario de creación.
     */
    public function create()
    {
        $odsMetas = OdsMeta::query()
            ->orderBy('ods_numero')
            ->orderBy('numero')
            ->get();

        return view('planes.create', compact('odsMetas'));
    }

    /**
     * Guarda un plan y (opcionalmente) sus hijos: metas, indicadores y cronogramas.
     */
    public function store(Request $request)
    {
        $data = $this->validatePlan($request);

        return DB::transaction(function () use ($data) {

            // Control de duplicados (regla de negocio adicional a unique en BD si existe)
            $exists = Plan::query()
                ->where('nombre', $data['nombre'])
                ->where('fecha_inicio', $data['fecha_inicio'])
                ->where('fecha_fin', $data['fecha_fin'])
                ->where('version', $data['version'] ?? 1)
                ->exists();

            if ($exists) {
                return back()
                    ->withErrors(['nombre' => 'Ya existe un plan con el mismo nombre, periodo y versión.'])
                    ->withInput();
            }

            $plan = Plan::create([
                'codigo'               => $data['codigo'] ?? null,
                'nombre'               => $data['nombre'],
                'descripcion'          => $data['descripcion'] ?? null,
                'fecha_inicio'         => $data['fecha_inicio'],
                'fecha_fin'            => $data['fecha_fin'],
                'version'              => $data['version'] ?? 1,
                'estado'               => $data['estado'] ?? 'BORRADOR',

                // ODS objetivo: ESCALAR (int), no array de reglas
                'ods_meta_objetivo_id' => (int) $data['ods_meta_objetivo_id'],

                'entidad_id'           => $data['entidad_id'] ?? null,
                'responsable_id'       => $data['responsable_id'] ?? null,
                'created_by'           => auth()->id(),
                'updated_by'           => auth()->id(),
            ]);

            // Metas ODS múltiples (pivot)
            $plan->odsMetas()->sync($data['ods_meta_ids'] ?? []);

            // Hijos (si llegaron): limpiar filas vacías y exigir un campo clave
            if (!empty($data['metas'])) {
                $plan->metas()->createMany($this->cleanChildren($data['metas'], ['nombre']));
            }

            if (!empty($data['indicadores'])) {
                $plan->indicadores()->createMany($this->cleanChildren($data['indicadores'], ['nombre']));
            }

            if (!empty($data['cronogramas'])) {
                $plan->cronogramas()->createMany($this->cleanChildren($data['cronogramas'], ['actividad']));
            }

            return redirect()
                ->route('planes.index')
                ->with('success', 'Plan creado correctamente.');
        });
    }

    /**
     * Muestra el formulario de edición.
     */
    public function edit(Plan $plan)
    {
        $plan->load(['metas', 'indicadores', 'cronogramas', 'odsMetas', 'odsMetaObjetivo']);

        $odsMetas = OdsMeta::query()
            ->orderBy('ods_numero')
            ->orderBy('numero')
            ->get();

        return view('planes.edit', compact('plan', 'odsMetas'));
    }

    /**
     * Actualiza un plan y (V1) sincroniza hijos borrando y recreando.
     */
    public function update(Request $request, Plan $plan)
    {
        $data = $this->validatePlan($request, $plan->id);

        return DB::transaction(function () use ($data, $plan) {

            // Duplicados (excluyendo el actual)
            $exists = Plan::query()
                ->where('id', '!=', $plan->id)
                ->where('nombre', $data['nombre'])
                ->where('fecha_inicio', $data['fecha_inicio'])
                ->where('fecha_fin', $data['fecha_fin'])
                ->where('version', $data['version'] ?? $plan->version)
                ->exists();

            if ($exists) {
                return back()
                    ->withErrors(['nombre' => 'Ya existe otro plan con el mismo nombre, periodo y versión.'])
                    ->withInput();
            }

            $plan->update([
                'codigo'               => $data['codigo'] ?? null,
                'nombre'               => $data['nombre'],
                'descripcion'          => $data['descripcion'] ?? null,
                'fecha_inicio'         => $data['fecha_inicio'],
                'fecha_fin'            => $data['fecha_fin'],
                'version'              => $data['version'] ?? $plan->version,
                'estado'               => $data['estado'] ?? $plan->estado,

                'ods_meta_objetivo_id' => (int) $data['ods_meta_objetivo_id'],

                'entidad_id'           => $data['entidad_id'] ?? null,
                'responsable_id'       => $data['responsable_id'] ?? null,
                'updated_by'           => auth()->id(),
            ]);

            // Sync ODS metas (pivot)
            $plan->odsMetas()->sync($data['ods_meta_ids'] ?? []);

            // Sync simple V1: borrar hijos y recrear
            $plan->metas()->delete();
            $plan->indicadores()->delete();
            $plan->cronogramas()->delete();

            if (!empty($data['metas'])) {
                $plan->metas()->createMany($this->cleanChildren($data['metas'], ['nombre']));
            }

            if (!empty($data['indicadores'])) {
                $plan->indicadores()->createMany($this->cleanChildren($data['indicadores'], ['nombre']));
            }

            if (!empty($data['cronogramas'])) {
                $plan->cronogramas()->createMany($this->cleanChildren($data['cronogramas'], ['actividad']));
            }

            return redirect()
                ->route('planes.index')
                ->with('success', 'Plan actualizado correctamente.');
        });
    }

    /**
     * Elimina un plan (SoftDeletes).
     */
    public function destroy(Plan $plan)
    {
        $plan->delete();

        return redirect()
            ->route('planes.index')
            ->with('success', 'Plan eliminado (soft delete).');
    }

    /**
     * Validación centralizada.
     */
    private function validatePlan(Request $request, ?int $planId = null): array
    {
        return $request->validate([
            // Campos principales
            'codigo'       => ['nullable', 'string', 'max:50'],
            'nombre'       => ['required', 'string', 'max:255'],
            'descripcion'  => ['nullable', 'string'],

            // Fechas
            'fecha_inicio' => ['required', 'date'],
            'fecha_fin'    => ['required', 'date', 'after_or_equal:fecha_inicio'],

            // Versionado y estado
            'version'      => ['nullable', 'integer', 'min:1'],
            'estado'       => ['required', 'in:BORRADOR,EN_REVISION,APROBADO,INACTIVO'],

            // Relaciones simples (puedes mejorar con exists si tienes tablas)
            'entidad_id'     => ['nullable', 'integer'],
            'responsable_id' => ['nullable', 'integer'],

            // ODS (exacto como pediste)
            'ods_meta_objetivo_id' => ['required', 'integer', 'exists:ods_metas,id'],
            'ods_meta_ids'         => ['nullable', 'array'],
            'ods_meta_ids.*'       => ['integer', 'exists:ods_metas,id'],

            // Hijos: metas
            'metas' => ['nullable', 'array'],
            'metas.*.nombre' => ['nullable', 'string', 'max:255'],
            'metas.*.descripcion' => ['nullable', 'string'],
            'metas.*.valor_objetivo' => ['nullable', 'numeric'],
            'metas.*.unidad_medida' => ['nullable', 'string', 'max:50'],
            'metas.*.estado' => ['nullable', 'in:ACTIVA,INACTIVA'],
            'metas.*.fecha_inicio' => ['nullable', 'date'],
            'metas.*.fecha_fin' => ['nullable', 'date'],

            // Hijos: indicadores
            'indicadores' => ['nullable', 'array'],
            'indicadores.*.nombre' => ['nullable', 'string', 'max:255'],
            'indicadores.*.descripcion' => ['nullable', 'string'],
            'indicadores.*.unidad_medida' => ['nullable', 'string', 'max:50'],
            'indicadores.*.linea_base' => ['nullable', 'numeric'],
            'indicadores.*.meta' => ['nullable', 'numeric'],
            'indicadores.*.frecuencia' => ['nullable', 'in:MENSUAL,TRIMESTRAL,SEMESTRAL,ANUAL'],
            'indicadores.*.fuente' => ['nullable', 'string', 'max:255'],
            'indicadores.*.estado' => ['nullable', 'in:ACTIVO,INACTIVO'],

            // Hijos: cronogramas
            'cronogramas' => ['nullable', 'array'],
            'cronogramas.*.actividad' => ['nullable', 'string', 'max:255'],
            'cronogramas.*.detalle' => ['nullable', 'string'],
            'cronogramas.*.responsable_id' => ['nullable', 'integer'],
            'cronogramas.*.fecha_inicio' => ['nullable', 'date'],
            'cronogramas.*.fecha_fin' => ['nullable', 'date'],
            'cronogramas.*.porcentaje' => ['nullable', 'integer', 'min:0', 'max:100'],
            'cronogramas.*.estado' => ['nullable', 'in:PENDIENTE,EN_PROCESO,CUMPLIDA,RETRASADA'],
        ], [
            'fecha_fin.after_or_equal' => 'La fecha fin no puede ser menor que la fecha inicio.',
        ]);
    }

    /**
     * Limpieza de filas hijas.
     */
    private function cleanChildren(array $rows, array $requiredKeys): array
    {
        $clean = [];

        foreach ($rows as $row) {
            $row = array_map(fn($v) => is_string($v) ? trim($v) : $v, $row);

            $hasRequired = true;
            foreach ($requiredKeys as $key) {
                if (empty($row[$key])) {
                    $hasRequired = false;
                    break;
                }
            }

            if ($hasRequired) {
                $clean[] = $row;
            }
        }

        return $clean;
    }
}