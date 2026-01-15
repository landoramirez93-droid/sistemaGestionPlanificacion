@extends('layouts.app')

@push('styles')
<link href="{{ asset('css/users.css') }}" rel="stylesheet">
@endpush

@section('title','ODS - Metas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Metas ODS</h4>
    <a href="{{ route('ods.metas.create') }}" class=" btn btn-primary">Nuevo</a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<form class="row g-2 mb-3" method="GET">
    <div class="col-md-6">
        <input class="form-control" name="search" placeholder="Buscar por código o descripción"
            value="{{ request('search') }}">
    </div>
    <div class="col-md-3">
        <select class="form-select" name="estado">
            <option value="">-- Estado --</option>
            <option value="ACTIVA" {{ request('estado')==='ACTIVA'?'selected':'' }}>ACTIVA</option>
            <option value="INACTIVA" {{ request('estado')==='INACTIVA'?'selected':'' }}>INACTIVA</option>
        </select>
    </div>
    <div class="col-md-3 d-grid">
        <button class="btn btn-outline-secondary">Filtrar</button>
    </div>
</form>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-striped align-middle mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Código</th>
                    <th>Descripción</th>
                    <th>Año</th>
                    <th>Estado</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($metas as $meta)
                <tr>
                    <td>{{ $meta->id }}</td>
                    <td>{{ $meta->codigo ?? '-' }}</td>
                    <td class="fw-semibold">{{ \Illuminate\Support\Str::limit($meta->descripcion, 80) }}</td>
                    <td>{{ $meta->anio_referencia ?? '-' }}</td>
                    <td>{{ $meta->estado }}</td>
                    <td class="text-end">
                        <a class="btn btn-sm btn-outline-secondary" href="{{ route('ods.metas.show',$meta) }}">Ver</a>
                        <a class="btn btn-sm btn-outline-primary" href="{{ route('ods.metas.edit',$meta) }}">Editar</a>
                        <form class="d-inline" method="POST" action="{{ route('ods.metas.destroy',$meta) }}">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('¿Eliminar esta meta ODS?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Sin metas ODS registradas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $metas->links() }}</div>
@endsection