@php
$plan = $plan ?? null;

// Fechas: soporta Carbon (format) o string ya guardado
$fechaInicio = old(
'fecha_inicio',
optional($plan)->fecha_inicio?->format('Y-m-d') ?? ($plan->fecha_inicio ?? '')
);

$fechaFin = old(
'fecha_fin',
optional($plan)->fecha_fin?->format('Y-m-d') ?? ($plan->fecha_fin ?? '')
);

$estado = old('estado', $plan->estado ?? 'BORRADOR');

$estados = [
'BORRADOR' => 'Borrador',
'EN_REVISION' => 'En revisión',
'APROBADO' => 'Aprobado',
'INACTIVO' => 'Inactivo',
];

// Mantener checks si hay error de validación (old), o cargar desde el modelo si existe (edit)
$selectedMetas = collect(
old('ods_meta_ids', $plan?->odsMetas?->pluck('id')?->all() ?? [])
)->map(fn($v) => (int) $v);
@endphp

<div class="mb-3">
    <label for="fecha_inicio" class="form-label">Fecha inicio</label>
    <input type="date" id="fecha_inicio" name="fecha_inicio"
        class="form-control @error('fecha_inicio') is-invalid @enderror" value="{{ $fechaInicio }}" required>
    @error('fecha_inicio')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="fecha_fin" class="form-label">Fecha fin</label>
    <input type="date" id="fecha_fin" name="fecha_fin" class="form-control @error('fecha_fin') is-invalid @enderror"
        value="{{ $fechaFin }}" required>
    @error('fecha_fin')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="estado" class="form-label">Estado</label>
    <select id="estado" name="estado" class="form-select @error('estado') is-invalid @enderror" required>
        @foreach($estados as $value => $label)
        <option value="{{ $value }}" @selected($estado===$value)>{{ $label }}</option>
        @endforeach
    </select>
    @error('estado')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- ODS Metas (solo si el controlador envía $odsMetas) --}}
@if(isset($odsMetas))
<div class="mt-3">
    <label class="form-label d-block">ODS - Metas asociadas</label>

    @forelse($odsMetas as $meta)
    @php
    $metaId = (int) $meta->id;
    $codigo = $meta->codigo_meta ?? $meta->codigo ?? $meta->id;
    $desc = $meta->descripcion ?? $meta->nombre ?? '';
    @endphp

    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="ods_meta_ids[]" value="{{ $metaId }}"
            id="meta{{ $metaId }}" @checked($selectedMetas->contains($metaId))
        >
        <label class="form-check-label" for="meta{{ $metaId }}">
            {{ $codigo }} - {{ $desc }}
        </label>
    </div>
    @empty
    <div class="text-muted">No hay metas ODS disponibles.</div>
    @endforelse

    @error('ods_meta_ids')
    <div class="text-danger small mt-2">{{ $message }}</div>
    @enderror
</div>
@endif