@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">{{ $proyecto->codigo }} - {{ $proyecto->nombre }}</h4>
            <small class="text-muted">
                Programa: {{ $proyecto->programa?->nombre }} | Estado: {{ $proyecto->estado }}
            </small>
        </div>
        <div class="d-flex gap-2">
            <a class="btn btn-warning" href="{{ route('proyectos.edit', $proyecto) }}">Editar</a>
            <a class="btn btn-secondary" href="{{ route('proyectos.index') }}">Volver</a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <p class="mb-2"><strong>Fechas:</strong> {{ $proyecto->fecha_inicio?->format('Y-m-d') }} →
                {{ $proyecto->fecha_fin?->format('Y-m-d') }}</p>
            <p class="mb-2"><strong>Presupuesto:</strong> {{ $proyecto->presupuesto ?? 'N/D' }}</p>
            <p class="mb-0"><strong>Descripción:</strong> {{ $proyecto->descripcion ?? 'N/D' }}</p>
        </div>
    </div>
</div>
@endsection