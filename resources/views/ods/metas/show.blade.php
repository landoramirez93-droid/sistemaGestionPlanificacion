@extends('layouts.app')
@section('title','Detalle Meta ODS')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Detalle Meta ODS</h4>
    <div class="d-flex gap-2">
        <a class="btn btn-primary" href="{{ route('ods.metas.edit', $ods_meta) }}">Editar</a>
        <a class="btn btn-secondary" href="{{ route('ods.metas.index') }}">Volver</a>
    </div>
</div>

<div class="card p-3 shadow-sm">
    <div><b>N°:</b> {{ $ods_meta->numero }}</div>
    <div><b>Objetivo:</b> {{ $ods_meta->objetivo }}</div>
    <div><b>Presupuesto:</b> {{ $ods_meta->presupuesto ? number_format($ods_meta->presupuesto, 0, ',', '.') : '-' }}
    </div>

    <hr>

    <div><b>Meta:</b><br>{{ $ods_meta->meta }}</div>

    <hr>

    <div><b>Observación:</b><br>{{ $ods_meta->observacion ?? '-' }}</div>

    <hr>

    <h6>Objetivos vinculados</h6>
    <ul class="mb-0">
        @forelse($ods_meta->objetivos as $o)
        <li>#{{ $o->id }} - {{ $o->descripcion }}</li>
        @empty
        <li class="text-muted">Sin objetivos vinculados.</li>
        @endforelse
    </ul>

    <hr>

    <h6>Planes vinculados</h6>
    <ul class="mb-0">
        @forelse($ods_meta->planes as $p)
        <li>#{{ $p->id }} - {{ $p->nombre }}</li>
        @empty
        <li class="text-muted">Sin planes vinculados.</li>
        @endforelse
    </ul>
</div>
@endsection