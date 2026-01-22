@php
// Objetivos seleccionados (para edición y para old() si vuelve con errores)
$selected = old('objetivo_ids', $meta?->objetivos?->pluck('id')->all() ?? []);
@endphp

<div class="row g-3">

    {{-- ✅ ODS N° (OBLIGATORIO) --}}
    <div class="col-md-3">
        <label class="form-label">ODS N° (1–17) <span class="text-danger">*</span></label>
        <select name="ods_numero" class="form-select @error('ods_numero') is-invalid @enderror" required>
            <option value="">-- Seleccione --</option>
            @for ($i = 1; $i <= 17; $i++) <option value="{{ $i }}" @selected(old('ods_numero', $meta->ods_numero ?? '')
                == $i)>
                ODS {{ $i }}
                </option>
                @endfor
        </select>
        @error('ods_numero')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- ✅ Meta N° (dentro del ODS) --}}
    <div class="col-md-2">
        <label class="form-label">Meta N° <span class="text-danger">*</span></label>
        <input type="number" min="1" name="numero" class="form-control @error('numero') is-invalid @enderror"
            value="{{ old('numero', $meta->numero ?? '') }}" required>
        @error('numero')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Código --}}
    <div class="col-md-4">
        <label class="form-label">Código</label>
        <input name="codigo" class="form-control @error('codigo') is-invalid @enderror"
            value="{{ old('codigo', $meta->codigo ?? '') }}" placeholder="ODS-01">
        @error('codigo')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Año --}}
    <div class="col-md-3">
        <label class="form-label">Año de referencia</label>
        <input type="number" min="1900" max="2100" name="anio_referencia"
            class="form-control @error('anio_referencia') is-invalid @enderror"
            value="{{ old('anio_referencia', $meta->anio_referencia ?? '') }}">
        @error('anio_referencia')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Nombre --}}
    <div class="col-12">
        <label class="form-label">Nombre <span class="text-danger">*</span></label>
        <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
            value="{{ old('nombre', $meta->nombre ?? '') }}" required>
        @error('nombre')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- ✅ Estado (ARREGLADO: usar $meta, no $ods_meta) --}}
    <div class="col-md-3">
        <label class="form-label">Estado <span class="text-danger">*</span></label>
        <select name="estado" class="form-select @error('estado') is-invalid @enderror" required>
            <option value="1" @selected((string)old('estado', $meta->estado ?? '1') === '1')>ACTIVA</option>
            <option value="0" @selected((string)old('estado', $meta->estado ?? '1') === '0')>INACTIVA</option>
        </select>
        @error('estado')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Objetivo --}}
    <div class="col-12">
        <label class="form-label">Objetivo <span class="text-danger">*</span></label>
        <input name="objetivo" class="form-control @error('objetivo') is-invalid @enderror"
            value="{{ old('objetivo', $meta->objetivo ?? '') }}" required>
        @error('objetivo')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Descripción --}}
    <div class="col-12">
        <label class="form-label">Descripción <span class="text-danger">*</span></label>
        <textarea name="descripcion" rows="5" class="form-control @error('descripcion') is-invalid @enderror"
            required>{{ old('descripcion', $meta->descripcion ?? '') }}</textarea>
        @error('descripcion')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Meta --}}
    <div class="col-12">
        <label class="form-label">Meta <span class="text-danger">*</span></label>
        <textarea name="meta" rows="5" class="form-control @error('meta') is-invalid @enderror"
            required>{{ old('meta', $meta->meta ?? '') }}</textarea>
        @error('meta')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Presupuesto --}}
    <div class="col-md-4">
        <label class="form-label">Presupuesto</label>
        <input type="text" name="presupuesto" class="form-control @error('presupuesto') is-invalid @enderror"
            value="{{ old('presupuesto', $meta->presupuesto ?? '') }}" placeholder="123.000">
        <div class="form-text">Puedes ingresar con puntos o comas; el sistema lo normaliza.</div>
        @error('presupuesto')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Observación --}}
    <div class="col-12">
        <label class="form-label">Observación</label>
        <textarea name="observacion" rows="4" class="form-control @error('observacion') is-invalid @enderror"
            placeholder="Observaciones adicionales...">{{ old('observacion', $meta->observacion ?? '') }}</textarea>
        @error('observacion')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Objetivos Estratégicos vinculados --}}
    <div class="col-12">
        <label class="form-label">Objetivos Estratégicos vinculados (opcional)</label>

        <div class="border rounded p-2" style="max-height: 240px; overflow:auto;">
            @forelse($objetivos as $o)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="objetivo_ids[]" value="{{ $o->id }}"
                    id="obj{{ $o->id }}" {{ in_array($o->id, $selected) ? 'checked' : '' }}>
                <label class="form-check-label" for="obj{{ $o->id }}">
                    #{{ $o->id }} - {{ $o->descripcion }}
                </label>
            </div>
            @empty
            <div class="text-muted">No hay objetivos estratégicos disponibles.</div>
            @endforelse
        </div>
    </div>

</div>