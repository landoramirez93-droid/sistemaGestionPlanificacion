@extends('layouts.app')

@push('styles')
<link href="{{ asset('css/users.css') }}" rel="stylesheet">
@endpush

@section('title', 'Proyectos')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Proyectos</h4>
            <small class="text-muted">Total: {{ $proyectos->total() }}</small>
        </div>
        <a href="{{ route('proyectos.create') }}" class="btn btn-primary"> Nuevo Proyecto</a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <form class="row g-2" method="GET" action="{{ route('proyectos.index') }}">
                <div class="col-md-4">
                    <input class="form-control" name="q" value="{{ $q }}" placeholder="Buscar por código o nombre">
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="programa_id">
                        <option value="">Programa (todos)</option>
                        @foreach($programas as $p)
                        <option value="{{ $p->id }}" @selected((string)$programaId===(string)$p->id)>{{ $p->nombre }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="estado">
                        <option value="">Estado (todos)</option>
                        @foreach(['PLANIFICADO','EN_EJECUCION','SUSPENDIDO','CERRADO'] as $e)
                        <option value="{{ $e }}" @selected($estado===$e)>{{ $e }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-grid">
                    <button class="btn btn-outline-primary">Filtrar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Programa</th>
                        <th>Estado</th>
                        <th>Fechas</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($proyectos as $proyecto)
                    <tr>
                        <td class="fw-semibold">{{ $proyecto->codigo }}</td>
                        <td>{{ $proyecto->nombre }}</td>
                        <td>{{ $proyecto->programa?->nombre }}</td>
                        <td><span class="badge bg-secondary">{{ $proyecto->estado }}</span></td>
                        <td>{{ $proyecto->fecha_inicio?->format('Y-m-d') }} →
                            {{ $proyecto->fecha_fin?->format('Y-m-d') }}</td>
                        <td class="text-end">
                            <a class="btn btn-sm btn-info" href="{{ route('proyectos.show', $proyecto) }}">Ver</a>
                            <a class="btn btn-sm btn-warning" href="{{ route('proyectos.edit', $proyecto) }}">Editar</a>
                            <form class="d-inline" method="POST" action="{{ route('proyectos.destroy', $proyecto) }}">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('¿Eliminar proyecto?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">No hay proyectos.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-body">
            {{ $proyectos->links() }}
        </div>
    </div>

</div>
@endsection