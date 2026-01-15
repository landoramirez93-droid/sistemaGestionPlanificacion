@extends('layouts.app')

@push('styles')
<link href="{{ asset('css/users.css') }}" rel="stylesheet">
@endpush

@section('title','Planes Institucionales')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h4 class="mb-0">Planes Institucionales</h4>
        <small class="text-muted">Gestión de planes</small>
    </div>
    <a href="{{ route('planes.create') }}" class="btn btn-primary"> Nuevo Plan</a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
</div>
@endif

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-striped align-middle mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Periodo</th>
                    <th>Versión</th>
                    <th>Estado</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($planes as $plan)
                <tr>
                    <td>{{ $plan->id }}</td>
                    <td>{{ $plan->codigo }}</td>
                    <td class="fw-semibold">{{ $plan->nombre }}</td>
                    <td>{{ $plan->fecha_inicio?->format('Y-m-d') }} → {{ $plan->fecha_fin?->format('Y-m-d') }}</td>
                    <td>{{ $plan->version }}</td>
                    <td>{{ $plan->estado }}</td>
                    <td class="text-end">
                        <a href="{{ route('planes.edit', $plan) }}" class="btn btn-sm btn-outline-primary">Editar</a>

                        <form action="{{ route('planes.destroy', $plan) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('¿Eliminar este plan?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">No hay planes registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $planes->links() }}
</div>
@endsection