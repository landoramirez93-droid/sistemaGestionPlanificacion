<?php

namespace App\Http\Controllers;

use App\Models\ObjetivoEstrategico;
use App\Models\Entidad;
use Illuminate\Http\Request;

class ObjetivoEstrategicoController extends Controller
{
    /**
     * Listar objetivos estratégicos
     */
    public function index()
    {
        $objetivos = ObjetivoEstrategico::with('entidad')->get();

        return view('objetivos.index', compact('objetivos'));
    }

    public function uploadForm()
    {
        return view('objetivos.upload');
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        $entidades = Entidad::all();
        return view('objetivos.create', compact('entidades'));
    }

    /**
     * Guardar objetivo estratégico
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'            => 'required|string|max:255',
            'descripcion'       => 'required|string',
            'linea_estrategica' => 'required|string|max:255',
            'entidad_id'        => 'required|exists:entidades,id',
            'estado'            => 'required|boolean',
        ]);

        ObjetivoEstrategico::create($validated);

        return redirect()
            ->route('objetivos.index')
            ->with('success', 'Objetivo estratégico registrado correctamente.');
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(ObjetivoEstrategico $objetivo)
    {
        $entidades = Entidad::all();
        return view('objetivos.edit', compact('objetivo', 'entidades'));
    }

    /**
     * Actualizar objetivo estratégico
     */
    public function update(Request $request, ObjetivoEstrategico $objetivo)
    {
        $validated = $request->validate([
            'nombre'            => 'required|string|max:255',
            'descripcion'       => 'required|string',
            'linea_estrategica' => 'required|string|max:255',
            'entidad_id'        => 'required|exists:entidades,id',
            'estado'            => 'required|boolean',
        ]);

        $objetivo->update($validated);

        return redirect()
            ->route('objetivos.index')
            ->with('success', 'Objetivo estratégico actualizado correctamente.');
    }

    /**
     * Cargar objetivos externos (PDF / Excel)
     */
    public function upload(Request $request)
    {
        $request->validate([
            'archivo' => 'required|mimes:pdf,xlsx|max:5120'
        ]);

        $ruta = $request->file('archivo')->store('objetivos');

        return back()->with('success', 'Archivo cargado correctamente.');
    }

    /**
     * Eliminar objetivo estratégico
     */
    public function destroy(ObjetivoEstrategico $objetivo)
    {
        $objetivo->delete();

        return back()->with('success', 'Objetivo estratégico eliminado correctamente.');
    }
}