@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Detalle Auditoría #{{ $auditoria->id }}</h4>
            <small class="text-muted">{{ $auditoria->created_at?->format('Y-m-d H:i:s') }}</small>
        </div>
        <a href="{{ route('auditoria.index') }}" class="btn btn-outline-secondary">Volver</a>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="text-muted small">Acción</div>
                    <div class="fw-semibold">{{ $auditoria->accion }}</div>
                </div>
                <div class="col-md-3">
                    <div class="text-muted small">Módulo</div>
                    <div class="fw-semibold">{{ $auditoria->modulo ?? '-' }}</div>
                </div>
                <div class="col-md-3">
                    <div class="text-muted small">Tabla</div>
                    <div class="fw-semibold">{{ $auditoria->tabla ?? '-' }}</div>
                </div>
                <div class="col-md-3">
                    <div class="text-muted small">Registro ID</div>
                    <div class="fw-semibold">{{ $auditoria->registro_id ?? '-' }}</div>
                </div>

                <div class="col-md-4">
                    <div class="text-muted small">Usuario</div>
                    <div class="fw-semibold">{{ $auditoria->user?->name ?? 'N/A' }}</div>
                </div>
                <div class="col-md-4">
                    <div class="text-muted small">Entidad</div>
                    <div class="fw-semibold">{{ $auditoria->entidad?->nombre ?? 'N/A' }}</div>
                </div>
                <div class="col-md-4">
                    <div class="text-muted small">IP</div>
                    <div class="fw-semibold">{{ $auditoria->ip ?? '-' }}</div>
                </div>

                <div class="col-12">
                    <div class="text-muted small">Descripción</div>
                    <div class="fw-semibold">{{ $auditoria->descripcion ?? '-' }}</div>
                </div>

                <div class="col-12">
                    <div class="text-muted small mb-2">Cambios (Antes vs Después)</div>
                    <div class="border rounded">
                        @include('auditoria.partials.diff-table', ['auditoria' => $auditoria])
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="text-muted small">URL</div>
                    <div class="fw-semibold text-break">{{ $auditoria->url ?? '-' }}</div>
                </div>
                <div class="col-md-2">
                    <div class="text-muted small">Método</div>
                    <div class="fw-semibold">{{ $auditoria->metodo ?? '-' }}</div>
                </div>
                <div class="col-md-4">
                    <div class="text-muted small">User-Agent</div>
                    <div class="fw-semibold text-break">{{ $auditoria->user_agent ?? '-' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection