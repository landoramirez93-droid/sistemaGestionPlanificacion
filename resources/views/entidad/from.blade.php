<div class="row">
    <div class="col-md-8 mb-3">
        <label class="form-label">Nombre *</label>
        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $entidad->nombre ?? '') }}"
            required>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Sigla</label>
        <input type="text" name="sigla" class="form-control" value="{{ old('sigla', $entidad->sigla ?? '') }}">
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Tipo</label>
        <input type="text" name="tipo" class="form-control" value="{{ old('tipo', $entidad->tipo ?? '') }}">
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Nivel</label>
        <input type="number" name="nivel" class="form-control" value="{{ old('nivel', $entidad->nivel ?? '') }}"
            min="1">
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Estado</label>
        <select name="estado" class="form-select">
            <option value="1" {{ old('estado', $entidad->estado ?? 1) == 1 ? 'selected' : '' }}>Activo</option>
            <option value="0" {{ old('estado', $entidad->estado ?? 1) == 0 ? 'selected' : '' }}>Inactivo</option>
        </select>
    </div>

</div>