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
            <label>Código</label>
            <input type="text" name="codigo" class="form-control" value="{{ $objetivo->codigo }}" required>
        </div>

        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control" required>{{ $objetivo->descripcion }}</textarea>
        </div>

        <div class="mb-3">
            <label>Horizonte</label>
            <input type="text" name="horizonte" class="form-control" value="{{ $objetivo->horizonte }}" required>
        </div>

        <div class="mb-3">
            <label>Línea Estratégica</label>
            <input type="text" name="linea_estrategica" class="form-control" value="{{ $objetivo->linea_estrategica }}"
                required>
        </div>

        <div class="mb-3">
            <label>Entidad Responsable</label>
            <select name="entidad_id" class="form-control" required>
                @foreach($entidades as $entidad)
                <option value="{{ $entidad->id }}" {{ $objetivo->entidad_id == $entidad->id ? 'selected' : '' }}>
                    {{ $entidad->nombre }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Estado</label>
            <select name="estado" class="form-control">
                <option value="1" {{ $objetivo->estado ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ !$objetivo->estado ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>

        <button class="btn btn-warning">Actualizar</button>
        <a href="{{ route('objetivos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection