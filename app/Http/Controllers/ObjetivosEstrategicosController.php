<?php

namespace App\Http\Controllers;

use App\Models\ObjetivosEstrategicos;
use App\Models\Entidad;
use Illuminate\Http\Request;

class ObjetivosEstrategicosController extends Controller
{
    /**
     *  Listar objetivos estratégicos
     */
    public function index()
    {
        // SOLO se envían objetivos (NO entidades)
        $objetivos = ObjetivosEstrategicos::with('entidad')->get();

        return view('objetivos.index', compact('objetivos'));
    }

    public function uploadForm()
    {
    return view('objetivos.upload');
    }


    /**
     *  Mostrar formulario de creación
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
            'codigo'            => 'required|unique:objetivos_estrategicos,codigo',
            'descripcion'       => 'required|string',
            'horizonte'         => 'required|string',
            'linea_estrategica' => 'required|string',
            'entidad_id'        => 'required|exists:entidades,id',
            'estado'            => 'required|boolean'
        ]);

        ObjetivosEstrategicos::create($validated);

        return redirect()
            ->route('objetivos.index')
            ->with('success', 'Objetivo estratégico registrado correctamente.');
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(ObjetivosEstrategicos $objetivo)
    {
        $entidades = Entidad::all();
        return view('objetivos.edit', compact('objetivo', 'entidades'));
    }

    /**
     * Actualizar objetivo estratégico
     */
    public function update(Request $request, ObjetivosEstrategicos $objetivo)
    {
        $validated = $request->validate([
            'codigo'            => 'required|unique:objetivos_estrategicos,codigo,' . $objetivo->id,
            'descripcion'       => 'required|string',
            'horizonte'         => 'required|string',
            'linea_estrategica' => 'required|string',
            'entidad_id'        => 'required|exists:entidades,id',
            'estado'            => 'required|boolean'
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

        // Aquí luego puedes procesar Excel o almacenar PDF
        return back()->with('success', 'Archivo cargado correctamente.');
    }

    /**
     * Eliminar objetivo estratégico
     */
    public function destroy(ObjetivosEstrategicos $objetivo)
    {
        $objetivo->delete();

        return back()->with('success', 'Objetivo estratégico eliminado correctamente.');
    }
}