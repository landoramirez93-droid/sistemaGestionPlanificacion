@php
$selectedObjetivos = old('objetivo_ids', $meta?->objetivos?->pluck('id')->toArray() ?? []);
@endphp

<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">Código</label>
        <input type="text" class="form-control" name="codigo" value="{{ old('codigo', $meta->codigo ?? '') }}">
    </div>

    <div class="col-md-4">
        <label class="form-label">Año de referencia</label>
        <input type="number" class="form-control" name="anio_referencia" min="1900" max="2100"
            value="{{ old('anio_referencia', $meta->anio_referencia ?? '') }}">
    </div>

    <div class="col-md-4">
        <label class="form-label">Estado *</label>
        <select class="form-select" name="estado" required>
            @foreach(['ACTIVA','INACTIVA'] as $st)
            <option value="{{ $st }}" {{ old('estado', $meta->estado ?? 'ACTIVA')===$st?'selected':'' }}>
                {{ $st }}
            </option>
            @endforeach
        </select>
    </div>

    <div class="col-12">
        <label class="form-label">Descripción *</label>
        <textarea class="form-control" name="descripcion" rows="4"
            required>{{ old('descripcion', $meta->descripcion ?? '') }}</textarea>
    </div>

    <div class="col-12">
        <label class="form-label">Objetivos Estratégicos vinculados (múltiple)</label>
        <select class="form-select" name="objetivo_ids[]" multiple size="8">
            @foreach($objetivos as $o)
            <option value="{{ $o->id }}" {{ in_array($o->id, $selectedObjetivos) ? 'selected' : '' }}>
                #{{ $o->id }} - {{ \Illuminate\Support\Str::limit($o->descripcion, 120) }}
            </option>
            @endforeach
        </select>
        <small class="text-muted">CTRL para seleccionar varios.</small>
    </div>
</div>