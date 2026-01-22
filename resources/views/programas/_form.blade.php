@csrf

<div class="mb-3">
    <label class="form-label">Nombre del Programa</label>
    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
        value="{{ old('nombre', $programa->nombre ?? '') }}" required>
    @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Descripción</label>
    <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror"
        rows="3">{{ old('descripcion', $programa->descripcion ?? '') }}</textarea>
    @error('descripcion') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="row g-2">
    <div class="col-md-6 mb-3">
        <label class="form-label">Fecha inicio *</label>
        <input type="date" name="fecha_inicio" class="form-control @error('fecha_inicio') is-invalid @enderror"
            value="{{ old('fecha_inicio', isset($programa) ? $programa->fecha_inicio?->format('Y-m-d') : '') }}"
            required>
        @error('fecha_inicio') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Fecha fin *</label>
        <input type="date" name="fecha_fin" class="form-control @error('fecha_fin') is-invalid @enderror"
            value="{{ old('fecha_fin', isset($programa) ? $programa->fecha_fin?->format('Y-m-d') : '') }}" required>
        @error('fecha_fin') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row g-2">
    <div class="col-md-6 mb-3">
        <label class="form-label">Responsable</label>
        <select name="responsable_id" class="form-select @error('responsable_id') is-invalid @enderror">
            <option value="">— Seleccione —</option>
            @foreach($responsables as $u)
            <option value="{{ $u->id }}"
                {{ (string)old('responsable_id', $programa->responsable_id ?? '') === (string)$u->id ? 'selected' : '' }}>
                {{ $u->name }}
            </option>
            @endforeach
        </select>
        @error('responsable_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Estado *</label>
        <select name="estado" class="form-select @error('estado') is-invalid @enderror" required>
            @php $estado = old('estado', $programa->estado ?? 'ACTIVO'); @endphp
            <option value="ACTIVO" {{ $estado==='ACTIVO' ? 'selected' : '' }}>ACTIVO</option>
            <option value="INACTIVO" {{ $estado==='INACTIVO' ? 'selected' : '' }}>INACTIVO</option>
        </select>
        @error('estado') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="d-flex gap-2">
    <button class="btn btn-primary">Guardar</button>
    <a href="{{ route('programas.index') }}" class="btn btn-secondary">Cancelar</a>
</div>