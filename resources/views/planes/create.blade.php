@extends('layouts.app')

@section('title', 'Crear Plan')

@section('content')
<div class="container">
    <h4 class="mb-3">Crear Plan Institucional</h4>

    @include('partials._errors')

    @php
    $estado = old('estado', 'BORRADOR');

    // Normaliza ids seleccionados para evitar problemas por tipos (string/int)
    $selectedMetas = collect(old('ods_meta_ids', []))->map(fn($v) => (int) $v)->all();
    @endphp

    <form action="{{ route('planes.store') }}" method="POST" class="card shadow-sm p-3">
        @csrf

        {{-- Nombre --}}
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Plan</label>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}"
                class="form-control @error('nombre') is-invalid @enderror" required autocomplete="off">
            @error('nombre')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Descripción --}}
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción / Detalle</label>
            <textarea id="descripcion" name="descripcion"
                class="form-control @error('descripcion') is-invalid @enderror"
                rows="3">{{ old('descripcion') }}</textarea>
            @error('descripcion')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Fechas + Estado --}}
        <div class="row g-3">
            <div class="col-md-4">
                <label for="fecha_inicio" class="form-label">Fecha inicio</label>
                <input type="date" id="fecha_inicio" name="fecha_inicio" value="{{ old('fecha_inicio') }}"
                    class="form-control @error('fecha_inicio') is-invalid @enderror" required>
                @error('fecha_inicio')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="fecha_fin" class="form-label">Fecha fin</label>
                <input type="date" id="fecha_fin" name="fecha_fin" value="{{ old('fecha_fin') }}"
                    class="form-control @error('fecha_fin') is-invalid @enderror" required>
                @error('fecha_fin')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="estado" class="form-label">Estado</label>
                <select id="estado" name="estado" class="form-select @error('estado') is-invalid @enderror" required>
                    <option value="BORRADOR" @selected($estado==='BORRADOR' )>BORRADOR</option>
                    <option value="EN_REVISION" @selected($estado==='EN_REVISION' )>EN_REVISION</option>
                    <option value="APROBADO" @selected($estado==='APROBADO' )>APROBADO</option>
                    <option value="INACTIVO" @selected($estado==='INACTIVO' )>INACTIVO</option>
                </select>
                @error('estado')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Alineación ODS / Gestión --}}
        <div class="card border p-3 mt-3">
            <h6 class="mb-3">Alineación ODS / Gestión</h6>

            {{-- Metas ODS (multiple) --}}
            <div class="mb-3">
                <label for="ods_meta_ids" class="form-label">Metas ODS que apoya</label>
                <select id="ods_meta_ids" name="ods_meta_ids[]"
                    class="form-select @error('ods_meta_ids') is-invalid @enderror" multiple>
                    @foreach($odsMetas as $meta)
                    @php $id = (int) $meta->id; @endphp
                    <option value="{{ $id }}" @selected(in_array($id, $selectedMetas, true))>
                        {{ $meta->codigo ?? 'Meta' }} - {{ $meta->descripcion ?? '' }}
                    </option>
                    @endforeach
                </select>

                <div class="form-text">Seleccione una o varias metas ODS.</div>

                @error('ods_meta_ids')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
                @error('ods_meta_ids.*')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Objetivo del plan (selección) --}}
            <div class="mb-3">
                <label for="ods_meta_objetivo_id" class="form-label">Objetivo (desde Metas ODS registradas)</label>
                <select id="ods_meta_objetivo_id" name="ods_meta_objetivo_id"
                    class="form-select @error('ods_meta_objetivo_id') is-invalid @enderror" required>
                    <option value="">Seleccione un objetivo</option>
                    @foreach($odsMetas as $meta)
                    <option value="{{ $meta->id }}" @selected(old('ods_meta_objetivo_id')==$meta->id)>
                        {{ $meta->codigo ?? 'Meta' }} -
                        {{ \Illuminate\Support\Str::limit($meta->descripcion ?? '', 90) }}
                    </option>
                    @endforeach
                </select>

                <div class="form-text">
                    La lista se carga desde el módulo ODS Metas (tabla <code>ods_metas</code>).
                </div>

                @error('ods_meta_objetivo_id')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Acciones --}}
        <div class="mt-3 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('planes.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection