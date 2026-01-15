@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Detalle del Programa</h4>
        <a href="{{ route('programas.index') }}" class="btn btn-secondary">Volver</a>
    </div>

    <div class="card">
        <div class="card-body">
            <p><strong>Nombre:</strong> {{ $programa->nombre }}</p>
            <p><strong>Descripción:</strong> {{ $programa->descripcion ?? '—' }}</p>
            <p><strong>Periodo:</strong> {{ $programa->fecha_inicio->format('Y-m-d') }} →
                {{ $programa->fecha_fin->format('Y-m-d') }}</p>
            <p><strong>Estado:</strong> {{ $programa->estado }}</p>
            <p><strong>Responsable:</strong> {{ $programa->responsable?->name ?? '—' }}</p>

            <div class="mt-3 d-flex gap-2">
                <a class="btn btn-warning" href="{{ route('programas.edit', $programa) }}">Editar</a>
            </div>
        </div>
    </div>
</div>
@endsection