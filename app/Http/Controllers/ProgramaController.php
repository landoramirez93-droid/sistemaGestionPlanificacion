<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProgramaRequest;
use App\Http\Requests\UpdateProgramaRequest;
use App\Models\Programa;
use App\Models\User;
use Illuminate\Http\Request;

class ProgramaController extends Controller
{
    /**
     * Lista programas con filtros (estado y nombre) + paginación.
     */
    public function index(Request $request)
    {
        $q = Programa::query(); // Inicia una consulta base

        if ($request->filled('estado')) { // Filtro por estado (si viene en el request)
            $q->where('estado', (string) $request->input('estado'));
        }

        if ($request->filled('nombre')) { // Filtro por nombre (búsqueda parcial)
            $nombre = (string) $request->input('nombre');
            $q->where('nombre', 'like', '%'.$nombre.'%');
        }

        $programas = $q->latest()->paginate(10)->withQueryString(); // Ordena por el más reciente y pagina, manteniendo los filtros en el query string

        return view('programas.index', compact('programas')); // Retorna vista con $programas
    }

    /**
     * Muestra el formulario de creación del programa.
     */
    public function create()
    {
        $responsables = User::orderBy('name')->get(['id', 'name']); // Lista de usuarios para asignar como responsables (solo id y name para optimizar)
        return view('programas.create', compact('responsables')); // Retorna vista de creación con responsables
    }

    /**
     * Guarda un programa nuevo usando validación encapsulada en StoreProgramaRequest.
     */
    public function store(StoreProgramaRequest $request)
    {
        Programa::create($request->validated()); // validated() devuelve solo datos validados y autorizados por el FormRequest

        return redirect() // Redirige al listado con mensaje de éxito
            ->route('programas.index')
            ->with('success', 'Programa creado correctamente.');
    }

    /**
     * Muestra el detalle de un programa.
     */
    public function show(Programa $programa)
    {
        return view('programas.show', compact('programa')); // Route Model Binding: Laravel inyecta el Programa según el parámetro de ruta
    }

    /**
     * Muestra el formulario de edición de un programa.
     */
    public function edit(Programa $programa)
    {
        $responsables = User::orderBy('name')->get(['id', 'name']); // Lista de responsables para mostrar en el formulario
        return view('programas.edit', compact('programa', 'responsables')); // Retorna vista de edición con programa y responsables
    }

    /**
     * Actualiza un programa usando validación encapsulada en UpdateProgramaRequest.
     */
    public function update(UpdateProgramaRequest $request, Programa $programa)
    {
        $programa->update($request->validated()); // Actualiza con los datos validados

        return redirect() // Redirige al listado con confirmación
            ->route('programas.index')
            ->with('success', 'Programa actualizado correctamente.');
    }

    public function destroy(Programa $programa)
    {
        // RF-07-04: no permitir eliminar si hay actividades activas asociadas.
        // Si aún no tienes "actividades", deja esto comentado.
        /*
        $tieneActivas = $programa->actividades()
            ->where('estado', 'ACTIVA')
            ->exists();

        if ($tieneActivas) {
            return back()->with('error', 'No se puede eliminar: existen actividades activas asociadas.');
        }
        */

        $programa->update(['estado' => 'INACTIVO']); // opcional
        $programa->delete(); // soft delete

        return redirect()
            ->route('programas.index')
            ->with('success', 'Programa eliminado (soft delete) correctamente.');
    }
}