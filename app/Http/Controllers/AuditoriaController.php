<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Models\Auditoria;
use Illuminate\Http\Request;

class AuditoriaController extends Controller
{
    /**
     * Lista auditorías con filtros.
     */
    public function index(Request $request)
    {
        $auditorias = Auditoria::query()
            ->with(['user', 'entidad'])
            ->latest()
            ->when($request->filled('accion'), fn ($q) => $q->where('accion', $request->input('accion')))
            ->when($request->filled('modulo'), fn ($q) => $q->where('modulo', 'like', '%' . $request->input('modulo') . '%'))
            ->when($request->filled('tabla'), fn ($q) => $q->where('tabla', 'like', '%' . $request->input('tabla') . '%'))
            ->when($request->filled('registro_id'), fn ($q) => $q->where('registro_id', $request->input('registro_id')))
            ->when($request->filled('user_id'), fn ($q) => $q->where('user_id', $request->input('user_id')))
            ->when($request->filled('entidad_id'), fn ($q) => $q->where('entidad_id', $request->input('entidad_id')))
            ->when($request->filled('from'), fn ($q) => $q->whereDate('created_at', '>=', $request->input('from')))
            ->when($request->filled('to'), fn ($q) => $q->whereDate('created_at', '<=', $request->input('to')))
            ->paginate(15)
            ->withQueryString();

        $acciones = Auditoria::query()
            ->select('accion')
            ->distinct()
            ->orderBy('accion')
            ->pluck('accion');

        return view('auditoria.index', compact('auditorias', 'acciones'));
    }

    /**
     * Muestra el detalle de una auditoría.
     */
    public function show(Auditoria $auditoria)
    {
        // Carga relaciones necesarias
        $auditoria->load(['user', 'entidad']);

        /**
         * Mapa id => nombre para traducir rol_id en los cambios (antes/después)
         * Si tu tabla de roles usa otro campo, cambia 'nombre'.
         */
        $roles = Rol::query()->pluck('nombre', 'id');

        /**
         * Si lo que necesitas es un solo rol del usuario para mostrarlo en pantalla,
         * calcula $rol (string) desde el usuario.
         *
         * Ajusta el campo 'rol_id' según tu tabla users.
         */
        $rol = null;
        if ($auditoria->user?->rol_id) {
            $rol = $roles->get((int) $auditoria->user->rol_id);
        }

        // IMPORTANTÍSIMO: aquí estabas fallando porque no enviabas variables extra a la vista
        return view('auditoria.show', compact('auditoria', 'roles', 'rol'));
    }

    /**
     * Elimina un registro de auditoría.
     * Recomendación: restringir a admin / auditor, o deshabilitar en producción.
     */
    public function destroy(Auditoria $auditoria)
    {
        $auditoria->delete();

        return redirect()
            ->route('auditoria.index')
            ->with('success', 'Registro de auditoría eliminado.');
    }
}