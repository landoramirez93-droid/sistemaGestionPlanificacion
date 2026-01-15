@php
$antes = $auditoria->antes ?? [];
$despues = $auditoria->despues ?? [];

// Unión de claves, pero EXCLUYE las claves que generan ruido/recursión
$excluir = ['antes', 'despues'];

$campos = collect(array_unique(array_merge(array_keys($antes), array_keys($despues))))
->reject(fn($k) => in_array($k, $excluir, true))
->values();

// Solo mostrar campos que cambiaron (opcional pero recomendado)
$campos = $campos->filter(function ($k) use ($antes, $despues) {
return ($antes[$k] ?? null) !== ($despues[$k] ?? null);
})->values();

$format = function ($campo, $valor) use ($roles) {
if ($valor === null || $valor === '') return '-';

// Si viene como JSON en string, intentar decodificarlo
if (is_string($valor)) {
$trim = trim($valor);
if ((str_starts_with($trim, '{') && str_ends_with($trim, '}')) ||
(str_starts_with($trim, '[') && str_ends_with($trim, ']'))) {
$decoded = json_decode($trim, true);
if (json_last_error() === JSON_ERROR_NONE) {
$valor = $decoded;
}
}
}

// Mapear rol_id a nombre si aplica
if ($campo === 'rol_id') {
return e($roles[(int)$valor] ?? $valor);
}

// Si es array/objeto, mostrar bonito en PRE
if (is_array($valor)) {
$pretty = json_encode($valor, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
return '
<pre class="mb-0 small" style="white-space: pre-wrap; word-break: break-word;">' . e($pretty) . '</pre>';
}

// Si es string largo, permitir wrap
$txt = (string) $valor;
return '<span style="word-break: break-word;">' . e($txt) . '</span>';
};
@endphp

<div class="table-responsive">
    <table class="table table-sm align-middle">
        <thead>
            <tr>
                <th style="width: 25%;">Campo</th>
                <th style="width: 37%;">Antes</th>
                <th style="width: 38%;">Después</th>
            </tr>
        </thead>
        <tbody>
            @forelse($campos as $campo)
            <tr>
                <td class="fw-semibold">{{ $campo }}</td>
                <td>{!! $format($campo, $antes[$campo] ?? null) !!}</td>
                <td>{!! $format($campo, $despues[$campo] ?? null) !!}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-muted">Sin cambios relevantes.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>