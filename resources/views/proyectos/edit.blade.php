@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Editar Proyecto</h4>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('proyectos.update', $proyecto) }}">
                @csrf @method('PUT')

                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Código (no editable)</label>
                        <input class="form-control" value="{{ $proyecto->codigo }}" disabled>
                    </div>

                    <div class="col-md-9">
                        <label class="form-label">Nombre</label>
                        <input class="form-control" name="nombre" value="{{ old('nombre', $proyecto->nombre) }}"
                            required>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Descripción</label>
                        <textarea class="form-control" name="descripcion"
                            rows="3">{{ old('descripcion', $proyecto->descripcion) }}</textarea>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Fecha inicio</label>
                        <input type="date" class="form-control" name="fecha_inicio"
                            value="{{ old('fecha_inicio', optional($proyecto->fecha_inicio)->format('Y-m-d')) }}"
                            required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Fecha fin</label>
                        <input type="date" class="form-control" name="fecha_fin"
                            value="{{ old('fecha_fin', optional($proyecto->fecha_fin)->format('Y-m-d')) }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Estado</label>
                        <select class="form-select" name="estado" required>
                            @foreach(['PLANIFICADO','EN_EJECUCION','SUSPENDIDO','CERRADO'] as $e)
                            <option value="{{ $e }}" @selected(old('estado', $proyecto->estado)===$e)>{{ $e }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Presupuesto</label>
                        <input type="number" step="0.01" class="form-control" name="presupuesto"
                            value="{{ old('presupuesto', $proyecto->presupuesto) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Programa asociado</label>
                        <select class="form-select" name="programa_id" required>
                            @foreach($programas as $p)
                            <option value="{{ $p->id }}" @selected((string)old('programa_id', $proyecto->
                                programa_id)===(string)$p->id)>{{ $p->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 d-flex gap-2">
                        <button class="btn btn-primary">Actualizar</button>
                        <a class="btn btn-secondary" href="{{ route('proyectos.index') }}">Cancelar</a>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection