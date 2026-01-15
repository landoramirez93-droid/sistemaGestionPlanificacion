@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Programas</h4>
            <small class="text-muted">Gestión de Programas </small>
        </div>
        <a href="{{ route('programas.create') }}" class="btn btn-primary">+ Nuevo Programa</a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card mb-3">
        <div class="card-body">
            <form class="row g-2" method="GET" action="{{ route('programas.index') }}">
                <div class="col-md-6">
                    <input type="text" name="nombre" class="form-control" placeholder="Buscar por nombre"
                        value="{{ request('nombre') }}">
                </div>
                <div class="col-md-4">
                    <select name="estado" class="form-select">
                        <option value="">-- Estado --</option>
                        <option value="ACTIVO" {{ request('estado')==='ACTIVO' ? 'selected' : '' }}>ACTIVO</option>
                        <option value="INACTIVO" {{ request('estado')==='INACTIVO' ? 'selected' : '' }}>INACTIVO
                        </option>
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
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Periodo</th>
                        <th>Estado</th>
                        <th>Responsable</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($programas as $p)
                    <tr>
                        <td>{{ $p->id }}</td>
                        <td class="fw-semibold">{{ $p->nombre }}</td>
                        <td>{{ $p->fecha_inicio->format('Y-m-d') }} → {{ $p->fecha_fin->format('Y-m-d') }}</td>
                        <td>
                            <span class="badge {{ $p->estado==='ACTIVO' ? 'bg-success' : 'bg-secondary' }}">
                                {{ $p->estado }}
                            </span>
                        </td>
                        <td>{{ $p->responsable?->name ?? '—' }}</td>
                        <td class="text-end">
                            <a class="btn btn-sm btn-info" href="{{ route('programas.show', $p) }}">Ver</a>
                            <a class="btn btn-sm btn-warning" href="{{ route('programas.edit', $p) }}">Editar</a>

                            <form class="d-inline" method="POST" action="{{ route('programas.destroy', $p) }}"
                                onsubmit="return confirm('¿Eliminar el programa? (Soft delete)')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">No existen programas.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $programas->links() }}
    </div>

</div>
@endsection