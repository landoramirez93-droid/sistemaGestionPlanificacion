@extends('layouts.app')
@section('title','Detalle Meta ODS')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Detalle Meta ODS</h4>
    <div class="d-flex gap-2">
        <a class="btn btn-outline-primary" href="{{ route('ods.metas.edit',$meta) }}">Editar</a>
        <a class="btn btn-secondary" href="{{ route('ods.metas.index') }}">Volver</a>
    </div>
</div>

<div class="card p-3 shadow-sm">
    <div><b>ID:</b> {{ $meta->id }}</div>
    <div><b>Código:</b> {{ $meta->codigo ?? '-' }}</div>
    <div><b>Año:</b> {{ $meta->anio_referencia ?? '-' }}</div>
    <div><b>Estado:</b> {{ $meta->estado }}</div>
    <hr>
    <div><b>Descripción:</b><br>{{ $meta->descripcion }}</div>

    <hr>
    <h6>Objetivos vinculados</h6>
    <ul class="mb-0">
        @forelse($meta->objetivos as $o)
        <li>#{{ $o->id }} - {{ $o->descripcion }}</li>
        @empty
        <li class="text-muted">Sin objetivos vinculados.</li>
        @endforelse
    </ul>

    <hr>
    <h6>Planes vinculados</h6>
    <ul class="mb-0">
        @forelse($meta->planes as $p)
        <li>#{{ $p->id }} - {{ $p->nombre }}</li>
        @empty
        <li class="text-muted">Sin planes vinculados.</li>
        @endforelse
    </ul>
</div>
@endsection