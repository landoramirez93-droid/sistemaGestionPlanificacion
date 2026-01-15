<?php

namespace App\Http\Controllers;

use App\Models\Entidad;
use App\Traits\RegistraAuditoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EntidadController extends Controller
{
    use RegistraAuditoria;

    /**
     * Lista entidades (paginación).
     */
    public function index(Request $request)
    {
        $q = Entidad::query()->orderBy('nombre');

        if ($request->filled('buscar')) {
            $buscar = $request->input('buscar');
            $q->where(function ($sub) use ($buscar) {
                $sub->where('nombre', 'like', "%{$buscar}%")
                    ->orWhere('sigla', 'like', "%{$buscar}%")
                    ->orWhere('tipo', 'like', "%{$buscar}%");
            });
        }

        $entidades = $q->paginate(10)->withQueryString();

        // OJO: revisa el nombre real de tu carpeta de vistas:
        // si es "entidades" debería ser 'entidades.index'
        return view('entidad.index', compact('entidades'));
    }

    /**
     * Formulario de creación.
     */
    public function create()
    {
        return view('entidad.create');
    }

    /**
     * Guarda entidad + auditoría.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'sigla'  => 'nullable|string|max:50',
            'tipo'   => 'nullable|string|max:100',
            'nivel'  => 'nullable|string|max:100',
            'estado' => 'nullable|integer',
        ]);

        $data['estado'] = $data['estado'] ?? 1;

        DB::transaction(function () use ($data) {
            $entidad = Entidad::create($data);

            $this->registrarAuditoria(
                accion: 'CREAR',
                modulo: 'Entidades',
                tabla: 'entidades',
                registroId: $entidad->id,
                entidadId: $entidad->id
            );
        });

        return redirect()
            ->route('entidad.index')
            ->with('success', 'Entidad creada correctamente.');
    }

    /**
     * Muestra entidad.
     */
    public function show(Entidad $entidad)
    {
        return view('entidad.show', compact('entidad'));
    }

    /**
     * Formulario de edición.
     */
    public function edit(Entidad $entidad)
    {
        return view('entidad.edit', compact('entidad'));
    }

    /**
     * Actualiza entidad + auditoría.
     */
    public function update(Request $request, Entidad $entidad)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'sigla'  => 'nullable|string|max:50',
            'tipo'   => 'nullable|string|max:100',
            'nivel'  => 'nullable|string|max:100',
            'estado' => 'nullable|integer',
        ]);

        $data['estado'] = $data['estado'] ?? $entidad->estado;

        DB::transaction(function () use ($entidad, $data) {
            $entidad->update($data);

            $this->registrarAuditoria(
                accion: 'ACTUALIZAR',
                modulo: 'Entidades',
                tabla: 'entidades',
                registroId: $entidad->id,
                entidadId: $entidad->id
            );
        });

        return redirect()
            ->route('entidad.index')
            ->with('success', 'Entidad actualizada correctamente.');
    }

    /**
     * Elimina entidad + auditoría.
     */
    public function destroy(Entidad $entidad)
    {
        DB::transaction(function () use ($entidad) {
            $entidadId = $entidad->id;

            $entidad->delete();

            $this->registrarAuditoria(
                accion: 'ELIMINAR',
                modulo: 'Entidades',
                tabla: 'entidades',
                registroId: $entidadId,
                entidadId: $entidadId
            );
        });

        return redirect()
            ->route('entidad.index')
            ->with('success', 'Entidad eliminada correctamente.');
    }
}