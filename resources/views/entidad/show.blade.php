@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Detalle de Entidad</h4>
        <a href="{{ route('entidad.index') }}" class="btn btn-secondary">Volver</a>
    </div>

    <div class="card">
        <div class="card-body">
            <p><strong>Código:</strong> {{ $entidad->codigo }}</p>
            <p><strong>Nombre:</strong> {{ $entidad->nombre }}</p>
            <p><strong>Sigla:</strong> {{ $entidad->sigla }}</p>
            <p><strong>Tipo:</strong> {{ $entidad->tipo }}</p>
            <p><strong>Nivel:</strong> {{ $entidad->nivel }}</p>
        </div>
    </div>
</div>
@endsection