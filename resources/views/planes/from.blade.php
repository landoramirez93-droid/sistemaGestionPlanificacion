@php
$metas = old('metas', $plan?->metas?->toArray() ?? []);
$indicadores = old('indicadores', $plan?->indicadores?->toArray() ?? []);
$cronogramas = old('cronogramas', $plan?->cronogramas?->toArray() ?? []);
@endphp

<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">Código</label>
        <input type="text" name="codigo" class="form-control" value="{{ old('codigo', $plan->codigo ?? '') }}">
    </div>

    <div class="col-md-8">
        <label class="form-label">Nombre *</label>
        <input type="text" name="nombre" class="form-control" required value="{{ old('nombre', $plan->nombre ?? '') }}">
    </div>

    <div class="col-12">
        <label class="form-label">Descripción</label>
        <textarea name="descripcion" class="form-control"
            rows="3">{{ old('descripcion', $plan->descripcion ?? '') }}</textarea>
    </div>

    <div class="col-md-6">
        <label class="form-label">Fecha Inicio *</label>
        <input type="date" name="fecha_inicio" class="form-control" required
            value="{{ old('fecha_inicio', isset($plan) && $plan?->fecha_inicio ? $plan->fecha_inicio->format('Y-m-d') : '') }}">
    </div>

    <div class="col-md-6">
        <label class="form-label">Fecha Fin *</label>
        <input type="date" name="fecha_fin" class="form-control" required
            value="{{ old('fecha_fin', isset($plan) && $plan?->fecha_fin ? $plan->fecha_fin->format('Y-m-d') : '') }}">
    </div>

    <div class="col-md-6">
        <label class="form-label">Estado *</label>
        <select name="estado" class="form-select" required>
            @foreach(['BORRADOR','EN_REVISION','APROBADO','INACTIVO'] as $st)
            <option value="{{ $st }}" {{ old('estado', $plan->estado ?? 'BORRADOR') === $st ? 'selected' : '' }}>
                {{ $st }}
            </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Versión</label>
        <input type="number" min="1" name="version" class="form-control"
            value="{{ old('version', $plan->version ?? 1) }}">
    </div>
</div>

<hr class="my-4">

<!-- METAS -->
<div class="d-flex justify-content-between align-items-center mb-2">
    <h5 class="mb-0">Metas</h5>
    <button type="button" class="btn btn-sm btn-outline-primary" id="addMeta">+ Agregar meta</button>
</div>

<div class="table-responsive">
    <table class="table table-bordered align-middle" id="metasTable">
        <thead class="table-light">
            <tr>
                <th style="width: 22%">Nombre *</th>
                <th>Descripción</th>
                <th style="width: 12%">Valor</th>
                <th style="width: 12%">Unidad</th>
                <th style="width: 12%">Estado</th>
                <th style="width: 14%">Inicio</th>
                <th style="width: 14%">Fin</th>
                <th style="width: 70px"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($metas as $i => $m)
            <tr>
                <td><input class="form-control" name="metas[{{ $i }}][nombre]" value="{{ $m['nombre'] ?? '' }}" /></td>
                <td><input class="form-control" name="metas[{{ $i }}][descripcion]"
                        value="{{ $m['descripcion'] ?? '' }}" /></td>
                <td><input class="form-control" name="metas[{{ $i }}][valor_objetivo]"
                        value="{{ $m['valor_objetivo'] ?? '' }}" /></td>
                <td><input class="form-control" name="metas[{{ $i }}][unidad_medida]"
                        value="{{ $m['unidad_medida'] ?? '' }}" /></td>
                <td>
                    <select class="form-select" name="metas[{{ $i }}][estado]">
                        <option value="ACTIVA" {{ ($m['estado'] ?? 'ACTIVA') === 'ACTIVA' ? 'selected' : '' }}>ACTIVA
                        </option>
                        <option value="INACTIVA" {{ ($m['estado'] ?? '') === 'INACTIVA' ? 'selected' : '' }}>INACTIVA
                        </option>
                    </select>
                </td>
                <td><input type="date" class="form-control" name="metas[{{ $i }}][fecha_inicio]"
                        value="{{ $m['fecha_inicio'] ?? '' }}" /></td>
                <td><input type="date" class="form-control" name="metas[{{ $i }}][fecha_fin]"
                        value="{{ $m['fecha_fin'] ?? '' }}" /></td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger removeRow">X</button>
                </td>
            </tr>
            @empty
            <!-- sin filas -->
            @endforelse
        </tbody>
    </table>
</div>

<hr class="my-4">

<!-- INDICADORES -->
<div class="d-flex justify-content-between align-items-center mb-2">
    <h5 class="mb-0">Indicadores</h5>
    <button type="button" class="btn btn-sm btn-outline-primary" id="addIndicador">+ Agregar indicador</button>
</div>

<div class="table-responsive">
    <table class="table table-bordered align-middle" id="indicadoresTable">
        <thead class="table-light">
            <tr>
                <th style="width: 20%">Nombre *</th>
                <th>Descripción</th>
                <th style="width: 10%">Línea base</th>
                <th style="width: 10%">Meta</th>
                <th style="width: 12%">Frecuencia</th>
                <th style="width: 12%">Unidad</th>
                <th style="width: 12%">Estado</th>
                <th style="width: 70px"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($indicadores as $i => $k)
            <tr>
                <td><input class="form-control" name="indicadores[{{ $i }}][nombre]" value="{{ $k['nombre'] ?? '' }}" />
                </td>
                <td><input class="form-control" name="indicadores[{{ $i }}][descripcion]"
                        value="{{ $k['descripcion'] ?? '' }}" /></td>
                <td><input class="form-control" name="indicadores[{{ $i }}][linea_base]"
                        value="{{ $k['linea_base'] ?? '' }}" /></td>
                <td><input class="form-control" name="indicadores[{{ $i }}][meta]" value="{{ $k['meta'] ?? '' }}" />
                </td>
                <td>
                    <select class="form-select" name="indicadores[{{ $i }}][frecuencia]">
                        @php $freq = $k['frecuencia'] ?? '' @endphp
                        <option value="">--</option>
                        <option value="MENSUAL" {{ $freq==='MENSUAL'?'selected':'' }}>MENSUAL</option>
                        <option value="TRIMESTRAL" {{ $freq==='TRIMESTRAL'?'selected':'' }}>TRIMESTRAL</option>
                        <option value="SEMESTRAL" {{ $freq==='SEMESTRAL'?'selected':'' }}>SEMESTRAL</option>
                        <option value="ANUAL" {{ $freq==='ANUAL'?'selected':'' }}>ANUAL</option>
                    </select>
                </td>
                <td><input class="form-control" name="indicadores[{{ $i }}][unidad_medida]"
                        value="{{ $k['unidad_medida'] ?? '' }}" /></td>
                <td>
                    <select class="form-select" name="indicadores[{{ $i }}][estado]">
                        @php $est = $k['estado'] ?? 'ACTIVO' @endphp
                        <option value="ACTIVO" {{ $est==='ACTIVO'?'selected':'' }}>ACTIVO</option>
                        <option value="INACTIVO" {{ $est==='INACTIVO'?'selected':'' }}>INACTIVO</option>
                    </select>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger removeRow">X</button>
                </td>
            </tr>
            @empty
            <!-- sin filas -->
            @endforelse
        </tbody>
    </table>
</div>

<hr class="my-4">

<!-- CRONOGRAMA -->
<div class="d-flex justify-content-between align-items-center mb-2">
    <h5 class="mb-0">Cronograma</h5>
    <button type="button" class="btn btn-sm btn-outline-primary" id="addCronograma">+ Agregar actividad</button>
</div>

<div class="table-responsive">
    <table class="table table-bordered align-middle" id="cronogramasTable">
        <thead class="table-light">
            <tr>
                <th style="width: 22%">Actividad *</th>
                <th>Detalle</th>
                <th style="width: 12%">Inicio</th>
                <th style="width: 12%">Fin</th>
                <th style="width: 10%">%</th>
                <th style="width: 14%">Estado</th>
                <th style="width: 70px"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($cronogramas as $i => $c)
            <tr>
                <td><input class="form-control" name="cronogramas[{{ $i }}][actividad]"
                        value="{{ $c['actividad'] ?? '' }}" /></td>
                <td><input class="form-control" name="cronogramas[{{ $i }}][detalle]"
                        value="{{ $c['detalle'] ?? '' }}" /></td>
                <td><input type="date" class="form-control" name="cronogramas[{{ $i }}][fecha_inicio]"
                        value="{{ $c['fecha_inicio'] ?? '' }}" /></td>
                <td><input type="date" class="form-control" name="cronogramas[{{ $i }}][fecha_fin]"
                        value="{{ $c['fecha_fin'] ?? '' }}" /></td>
                <td><input type="number" min="0" max="100" class="form-control" name="cronogramas[{{ $i }}][porcentaje]"
                        value="{{ $c['porcentaje'] ?? 0 }}" /></td>
                <td>
                    @php $st = $c['estado'] ?? 'PENDIENTE' @endphp
                    <select class="form-select" name="cronogramas[{{ $i }}][estado]">
                        <option value="PENDIENTE" {{ $st==='PENDIENTE'?'selected':'' }}>PENDIENTE</option>
                        <option value="EN_PROCESO" {{ $st==='EN_PROCESO'?'selected':'' }}>EN_PROCESO</option>
                        <option value="CUMPLIDA" {{ $st==='CUMPLIDA'?'selected':'' }}>CUMPLIDA</option>
                        <option value="RETRASADA" {{ $st==='RETRASADA'?'selected':'' }}>RETRASADA</option>
                    </select>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger removeRow">X</button>
                </td>
            </tr>
            @empty
            <!-- sin filas -->
            @endforelse
        </tbody>
    </table>
</div>

@push('scripts')
<script>
(function() {
    const metasTable = document.querySelector('#metasTable tbody');
    const indicadoresTable = document.querySelector('#indicadoresTable tbody');
    const cronogramasTable = document.querySelector('#cronogramasTable tbody');

    function onRemoveRow(e) {
        if (e.target.classList.contains('removeRow')) {
            e.target.closest('tr').remove();
        }
    }

    metasTable.addEventListener('click', onRemoveRow);
    indicadoresTable.addEventListener('click', onRemoveRow);
    cronogramasTable.addEventListener('click', onRemoveRow);

    function nextIndex(tbody, prefix) {
        // Calcula el próximo índice basado en inputs existentes
        const inputs = tbody.querySelectorAll(`input[name^="${prefix}["], select[name^="${prefix}["]`);
        let max = -1;
        inputs.forEach(el => {
            const m = el.name.match(new RegExp('^' + prefix.replace('[', '\\[').replace(']', '\\]') +
                '\\[(\\d+)\\]'));
            if (m && m[1]) max = Math.max(max, parseInt(m[1], 10));
        });
        return max + 1;
    }

    document.getElementById('addMeta').addEventListener('click', function() {
        const i = nextIndex(metasTable, 'metas');
        metasTable.insertAdjacentHTML('beforeend', `
            <tr>
                <td><input class="form-control" name="metas[${i}][nombre]" /></td>
                <td><input class="form-control" name="metas[${i}][descripcion]" /></td>
                <td><input class="form-control" name="metas[${i}][valor_objetivo]" /></td>
                <td><input class="form-control" name="metas[${i}][unidad_medida]" /></td>
                <td>
                    <select class="form-select" name="metas[${i}][estado]">
                        <option value="ACTIVA" selected>ACTIVA</option>
                        <option value="INACTIVA">INACTIVA</option>
                    </select>
                </td>
                <td><input type="date" class="form-control" name="metas[${i}][fecha_inicio]" /></td>
                <td><input type="date" class="form-control" name="metas[${i}][fecha_fin]" /></td>
                <td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger removeRow">X</button></td>
            </tr>
        `);
    });

    document.getElementById('addIndicador').addEventListener('click', function() {
        const i = nextIndex(indicadoresTable, 'indicadores');
        indicadoresTable.insertAdjacentHTML('beforeend', `
            <tr>
                <td><input class="form-control" name="indicadores[${i}][nombre]" /></td>
                <td><input class="form-control" name="indicadores[${i}][descripcion]" /></td>
                <td><input class="form-control" name="indicadores[${i}][linea_base]" /></td>
                <td><input class="form-control" name="indicadores[${i}][meta]" /></td>
                <td>
                    <select class="form-select" name="indicadores[${i}][frecuencia]">
                        <option value="">--</option>
                        <option value="MENSUAL">MENSUAL</option>
                        <option value="TRIMESTRAL">TRIMESTRAL</option>
                        <option value="SEMESTRAL">SEMESTRAL</option>
                        <option value="ANUAL">ANUAL</option>
                    </select>
                </td>
                <td><input class="form-control" name="indicadores[${i}][unidad_medida]" /></td>
                <td>
                    <select class="form-select" name="indicadores[${i}][estado]">
                        <option value="ACTIVO" selected>ACTIVO</option>
                        <option value="INACTIVO">INACTIVO</option>
                    </select>
                </td>
                <td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger removeRow">X</button></td>
            </tr>
        `);
    });

    document.getElementById('addCronograma').addEventListener('click', function() {
        const i = nextIndex(cronogramasTable, 'cronogramas');
        cronogramasTable.insertAdjacentHTML('beforeend', `
            <tr>
                <td><input class="form-control" name="cronogramas[${i}][actividad]" /></td>
                <td><input class="form-control" name="cronogramas[${i}][detalle]" /></td>
                <td><input type="date" class="form-control" name="cronogramas[${i}][fecha_inicio]" /></td>
                <td><input type="date" class="form-control" name="cronogramas[${i}][fecha_fin]" /></td>
                <td><input type="number" min="0" max="100" class="form-control" name="cronogramas[${i}][porcentaje]" value="0" /></td>
                <td>
                    <select class="form-select" name="cronogramas[${i}][estado]">
                        <option value="PENDIENTE" selected>PENDIENTE</option>
                        <option value="EN_PROCESO">EN_PROCESO</option>
                        <option value="CUMPLIDA">CUMPLIDA</option>
                        <option value="RETRASADA">RETRASADA</option>
                    </select>
                </td>
                <td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger removeRow">X</button></td>
            </tr>
        `);
    });
})();
</script>
@endpush