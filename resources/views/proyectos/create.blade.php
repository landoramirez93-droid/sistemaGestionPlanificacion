@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Crear Proyecto</h4>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('proyectos.store') }}">
                @csrf

                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Código</label>
                        <input class="form-control" name="codigo" value="{{ old('codigo') }}" required>
                    </div>

                    <div class="col-md-9">
                        <label class="form-label">Nombre</label>
                        <input class="form-control" name="nombre" value="{{ old('nombre') }}" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Descripción</label>
                        <textarea class="form-control" name="descripcion" rows="3">{{ old('descripcion') }}</textarea>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Fecha inicio</label>
                        <input type="date" class="form-control" name="fecha_inicio" value="{{ old('fecha_inicio') }}"
                            required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Fecha fin</label>
                        <input type="date" class="form-control" name="fecha_fin" value="{{ old('fecha_fin') }}"
                            required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Estado</label>
                        <select class="form-select" name="estado" required>
                            @foreach(['PLANIFICADO','EN_EJECUCION','SUSPENDIDO','CERRADO'] as $e)
                            <option value="{{ $e }}" @selected(old('estado','PLANIFICADO')===$e)>{{ $e }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Presupuesto</label>
                        <input type="number" step="0.01" class="form-control" name="presupuesto"
                            value="{{ old('presupuesto') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Programa asociado</label>
                        <select class="form-select" name="programa_id" required>
                            <option value="">Seleccione</option>
                            @foreach($programas as $p)
                            <option value="{{ $p->id }}" @selected((string)old('programa_id')===(string)$p->
                                id)>{{ $p->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 d-flex gap-2">
                        <button class="btn btn-primary">Guardar</button>
                        <a class="btn btn-secondary" href="{{ route('proyectos.index') }}">Cancelar</a>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection