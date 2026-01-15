<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProgramaRequest;
use App\Http\Requests\UpdateProgramaRequest;
use App\Models\Programa;
use App\Models\User;
use Illuminate\Http\Request;

class ProgramaController extends Controller
{
    public function index(Request $request)
    {
        $q = Programa::query();

        if ($request->filled('estado')) {
            $q->where('estado', (string) $request->input('estado'));
        }

        if ($request->filled('nombre')) {
            $nombre = (string) $request->input('nombre');
            $q->where('nombre', 'like', '%'.$nombre.'%');
        }

        $programas = $q->latest()->paginate(10)->withQueryString();

        return view('programas.index', compact('programas'));
    }

    public function create()
    {
        $responsables = User::orderBy('name')->get(['id', 'name']);
        return view('programas.create', compact('responsables'));
    }

    public function store(StoreProgramaRequest $request)
    {
        Programa::create($request->validated());

        return redirect()
            ->route('programas.index')
            ->with('success', 'Programa creado correctamente.');
    }

    public function show(Programa $programa)
    {
        return view('programas.show', compact('programa'));
    }

    public function edit(Programa $programa)
    {
        $responsables = User::orderBy('name')->get(['id', 'name']);
        return view('programas.edit', compact('programa', 'responsables'));
    }

    public function update(UpdateProgramaRequest $request, Programa $programa)
    {
        $programa->update($request->validated());

        return redirect()
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