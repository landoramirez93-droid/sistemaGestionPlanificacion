@extends('layouts.app')

@section('content')
<div class="container">

    <h4 class="mb-4">Registrar Objetivo Estratégico</h4>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('objetivos.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Objetivo</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" rows="3" required>{{ old('descripcion') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Línea Estratégica</label>
            <input type="text" name="linea_estrategica" class="form-control" value="{{ old('linea_estrategica') }}"
                required>
        </div>

        <div class="mb-3">
            <label class="form-label">Entidad Responsable</label>
            <select name="entidad_id" class="form-control" required>
                <option value="">Seleccione una entidad</option>
                @foreach($entidades as $entidad)
                <option value="{{ $entidad->id }}" {{ old('entidad_id') == $entidad->id ? 'selected' : '' }}>
                    {{ $entidad->nombre }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Estado</label>
            <select name="estado" class="form-control" required>
                <option value="1" {{ old('estado', '1') == '1' ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ old('estado') == '0' ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>

        {{-- METAS ODS (CORREGIDO) --}}
        <div class="mb-3">
            <label class="form-label">Metas ODS que apoya</label>

            <div class="border rounded p-3" style="max-height: 260px; overflow:auto;">
                @forelse($odsMetas as $meta)
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="ods_meta_ids[]" value="{{ $meta->id }}"
                        id="meta_{{ $meta->id }}" {{ in_array($meta->id, old('ods_meta_ids', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="meta_{{ $meta->id }}">
                        <strong>{{ $meta->codigo ?? 'Meta' }}</strong>
                        — {{ $meta->descripcion ?? '' }}
                    </label>
                </div>
                @empty
                <span class="text-muted">No existen metas ODS registradas.</span>
                @endforelse
            </div>

            <small class="text-muted">
                Seleccione una o varias metas ODS alineadas a este objetivo estratégico.
            </small>
        </div>

        <button class="btn btn-primary">Guardar</button>
        <a href="{{ route('objetivos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection