<?php

namespace App\Traits;

use App\Models\Auditoria;


trait RegistraAuditoria
{
    protected function registrarAuditoria(
        string $accion,
        string $modulo,
        string $tabla,
        int $registroId,
        ?int $entidadId = null
    ): void {
        Auditoria::create([
            'accion'      => $accion,
            'modulo'      => $modulo,
            'tabla'       => $tabla,
            'registro_id' => $registroId,
            'user_id'     => auth()->id(),
            'entidad_id'  => $entidadId,
        ]);
    }
}