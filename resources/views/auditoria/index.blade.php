@extends('layouts.app')

@push('styles')
<link href="{{ asset('css/users.css') }}" rel="stylesheet">
@endpush

@section('title', 'Auditoría')

@section('content')
<div class="container-fluid py-3">

    {{-- Header --}}
    <div
        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2 mb-3">
        <div>
            <h4 class="mb-0">Auditoría</h4>
            <div class="text-muted small">
                Mostrando
                <strong>{{ $auditorias->firstItem() ?? 0 }}</strong>–<strong>{{ $auditorias->lastItem() ?? 0 }}</strong>
                de <strong>{{ $auditorias->total() }}</strong>
            </div>
        </div>

        {{-- Puedes agregar aquí botones extra (Exportar, etc.) si los tienes --}}
        {{-- <a class="btn btn-outline-secondary btn-sm" href="#">Exportar</a> --}}
    </div>

    {{-- Alerts --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
        <div class="d-flex align-items-start gap-2">
            <div class="flex-grow-1">{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    </div>
    @endif

    {{-- Filtros --}}
    <div class="card shadow-sm mb-3">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <span class="fw-semibold">Filtros</span>

            <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse"
                data-bs-target="#auditFilters" aria-expanded="true" aria-controls="auditFilters">
                Mostrar / Ocultar
            </button>
        </div>

        <div id="auditFilters" class="collapse show">
            <div class="card-body">
                <form class="row g-3" method="GET" action="{{ route('auditoria.index') }}">
                    <div class="col-12 col-sm-6 col-lg-2">
                        <label class="form-label mb-1">Acción</label>
                        <select name="accion" class="form-select">
                            <option value="">Todas</option>
                            @foreach($acciones as $accion)
                            <option value="{{ $accion }}" @selected(request('accion')==$accion)>{{ $accion }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-sm-6 col-lg-2">
                        <label class="form-label mb-1">Módulo</label>
                        <input type="text" name="modulo" class="form-control" value="{{ request('modulo') }}"
                            placeholder="Ej: Usuarios">
                    </div>

                    <div class="col-12 col-sm-6 col-lg-2">
                        <label class="form-label mb-1">Tabla</label>
                        <input type="text" name="tabla" class="form-control" value="{{ request('tabla') }}"
                            placeholder="Ej: users">
                    </div>

                    <div class="col-12 col-sm-6 col-lg-2">
                        <label class="form-label mb-1">Registro ID</label>
                        <input type="number" name="registro_id" class="form-control"
                            value="{{ request('registro_id') }}" placeholder="Ej: 1" min="1">
                    </div>

                    <div class="col-12 col-sm-6 col-lg-2">
                        <label class="form-label mb-1">User ID</label>
                        <input type="number" name="user_id" class="form-control" value="{{ request('user_id') }}"
                            placeholder="Ej: 1" min="1">
                    </div>

                    <div class="col-12 col-lg-2 d-flex align-items-end gap-2">
                        <button class="btn btn-primary w-100" type="submit">
                            Filtrar
                        </button>
                        <a class="btn btn-outline-secondary w-100" href="{{ route('auditoria.index') }}">
                            Limpiar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Tabla --}}
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 70px;">#</th>
                        <th style="width: 170px;">Fecha</th>
                        <th style="width: 120px;">Acción</th>
                        <th>Módulo</th>
                        <th>Tabla</th>
                        <th style="width: 110px;">Registro</th>
                        <th>Usuario</th>
                        <th style="width: 140px;">IP</th>
                        <th class="text-end" style="width: 120px;">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($auditorias as $a)
                    @php
                    $accion = strtoupper((string)($a->accion ?? ''));
                    $badgeClass = match ($accion) {
                    'CREAR', 'CREATE' => 'text-bg-success',
                    'ACTUALIZAR', 'UPDATE', 'EDITAR' => 'text-bg-warning',
                    'ELIMINAR', 'DELETE' => 'text-bg-danger',
                    'APROBAR', 'APPROVE' => 'text-bg-primary',
                    'RECHAZAR', 'REJECT' => 'text-bg-dark',
                    default => 'text-bg-secondary',
                    };
                    @endphp

                    <tr>
                        {{-- Numeración por página --}}
                        <td class="text-muted">
                            {{ ($auditorias->firstItem() ?? 0) + $loop->index }}
                        </td>

                        <td>
                            <div class="fw-semibold">
                                {{ $a->created_at?->format('Y-m-d') }}
                            </div>
                            <div class="text-muted small">
                                {{ $a->created_at?->format('H:i') }}
                            </div>
                        </td>

                        <td>
                            <span class="badge {{ $badgeClass }}">
                                {{ $a->accion }}
                            </span>
                        </td>

                        <td>{{ $a->modulo ?? '-' }}</td>

                        <td>
                            @if($a->tabla)
                            <code class="small">{{ $a->tabla }}</code>
                            @else
                            -
                            @endif
                        </td>

                        <td>{{ $a->registro_id ?? '-' }}</td>

                        <td>{{ $a->user?->name ?? 'N/A' }}</td>

                        <td>
                            @if($a->ip)
                            <code class="small">{{ $a->ip }}</code>
                            @else
                            -
                            @endif
                        </td>

                        <td class="text-end">
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('auditoria.show', $a) }}">
                                Ver
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-5">
                            No hay registros de auditoría con los filtros actuales.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        <div
            class="card-footer bg-white d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
            <div class="text-muted small">
                Mostrando {{ $auditorias->firstItem() ?? 0 }}–{{ $auditorias->lastItem() ?? 0 }} de
                {{ $auditorias->total() }}
            </div>
            <div>
                {{ $auditorias->links() }}
            </div>
        </div>
    </div>

</div>
@endsection