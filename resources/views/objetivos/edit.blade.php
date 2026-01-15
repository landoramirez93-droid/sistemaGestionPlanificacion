@extends('layouts.app')

@section('content')
<div class="container">

    <h4 class="mb-4">Editar Objetivo Estratégico</h4>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('objetivos.update', $objetivo) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $objetivo->nombre) }}"
                required>
        </div>

        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control"
                required>{{ old('descripcion', $objetivo->descripcion) }}</textarea>
        </div>

        <div class="mb-3">
            <label>Línea Estratégica</label>
            <input type="text" name="linea_estrategica" class="form-control"
                value="{{ old('linea_estrategica', $objetivo->linea_estrategica) }}" required>
        </div>

        <div class="mb-3">
            <label>Entidad Responsable</label>
            <select name="entidad_id" class="form-control" required>
                @foreach($entidades as $entidad)
                <option value="{{ $entidad->id }}"
                    {{ old('entidad_id', $objetivo->entidad_id) == $entidad->id ? 'selected' : '' }}>
                    {{ $entidad->nombre }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Estado</label>
            <select name="estado" class="form-control" required>
                <option value="1" {{ old('estado', (string)$objetivo->estado) == '1' ? 'selected' : '' }}>Activo
                </option>
                <option value="0" {{ old('estado', (string)$objetivo->estado) == '0' ? 'selected' : '' }}>Inactivo
                </option>
            </select>
        </div>

        <button class="btn btn-warning">Actualizar</button>
        <a href="{{ route('objetivos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection