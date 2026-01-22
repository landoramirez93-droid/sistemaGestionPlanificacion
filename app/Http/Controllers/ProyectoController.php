<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\Programa;
use App\Http\Requests\StoreProyectoRequest;
use App\Http\Requests\UpdateProyectoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProyectoController extends Controller
{
    /**
     * Lista proyectos con filtros.
     */
    public function index(Request $request)
    {
        $q = $request->get('q');
        $estado = $request->get('estado');
        $programaId = $request->get('programa_id');

        $proyectos = Proyecto::query()
            ->with('programa')
            ->when($q, fn ($qr) => $qr->where(function ($w) use ($q) {
                $w->where('codigo', 'like', "%{$q}%")
                    ->orWhere('nombre', 'like', "%{$q}%");
            }))
            ->when($estado, fn ($qr) => $qr->where('estado', $estado))
            ->when($programaId, fn ($qr) => $qr->where('programa_id', $programaId))
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        $programas = Programa::orderBy('nombre')->get();

        return view('proyectos.index', compact('proyectos', 'programas', 'q', 'estado', 'programaId'));
    }

    /**
     * Formulario de creación.
     */
    public function create()
    {
        $programas = Programa::orderBy('nombre')->get();

        return view('proyectos.create', compact('programas'));
    }

    /**
     * Guarda un proyecto.
     */
    public function store(StoreProyectoRequest $request)
    {
    $data = $request->validated();

    // Normaliza presupuesto
    if (isset($data['presupuesto'])) {
        $data['presupuesto'] = str_replace('.', '', $data['presupuesto']);
        $data['presupuesto'] = str_replace(',', '.', $data['presupuesto']);
    }

    // Tomar entidad desde el programa
    $programa = Programa::select('id', 'entidad_id')->findOrFail($data['programa_id']);

    if (!$programa->entidad_id) {
        return back()->withInput()->withErrors([
            'programa_id' => 'El programa seleccionado no tiene una entidad asignada.'
        ]);
    }

    $data['entidad_id'] = $programa->entidad_id;

    Proyecto::create($data);

    return redirect()
        ->route('proyectos.index')
        ->with('success', 'Proyecto creado correctamente.');
    }
    /**
     * Muestra un proyecto.
     */
    public function show(Proyecto $proyecto)
    {
        $proyecto->load('programa');

        return view('proyectos.show', compact('proyecto'));
    }

    /**
     * Formulario de edición.
     */
    public function edit(Proyecto $proyecto)
    {
        $programas = Programa::orderBy('nombre')->get();

        return view('proyectos.edit', compact('proyecto', 'programas'));
    }

    /**
     * Actualiza un proyecto.
     */
    public function update(UpdateProyectoRequest $request, Proyecto $proyecto)
    {
    $data = $request->validated();

    if (isset($data['presupuesto'])) {
        $data['presupuesto'] = str_replace('.', '', $data['presupuesto']);
        $data['presupuesto'] = str_replace(',', '.', $data['presupuesto']);
    }

    if (isset($data['programa_id'])) {
        $programa = Programa::select('id', 'entidad_id')->findOrFail($data['programa_id']);

        if (!$programa->entidad_id) {
            return back()->withInput()->withErrors([
                'programa_id' => 'El programa seleccionado no tiene una entidad asignada.'
            ]);
        }

        $data['entidad_id'] = $programa->entidad_id;
    }

    $proyecto->update($data);

    return redirect()
        ->route('proyectos.index')
        ->with('success', 'Proyecto actualizado correctamente.');
    }

    /**
     * Elimina un proyecto (soft delete).
     */
    public function destroy(Proyecto $proyecto)
    {
        $proyecto->delete();

        return redirect()
            ->route('proyectos.index')
            ->with('success', 'Proyecto eliminado correctamente.');
    }

    /**
     * Aprueba un proyecto.
     * La autorización por rol se controla en routes/web.php con middleware('role:...').
     */
    public function aprobar(Proyecto $proyecto)
    {
        DB::transaction(function () use ($proyecto) {
            $proyecto->update([
                'aprobado'     => true,
                'aprobado_por' => auth()->id(),
                'aprobado_en'  => now(),
            ]);
        });

        return back()->with('success', 'Proyecto aprobado correctamente.');
    }
}