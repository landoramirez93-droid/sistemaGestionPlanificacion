@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div>
            <h4 class="mb-0">Auditoría</h4>
            <small class="text-muted">Total: {{ $auditorias->total() }}</small>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
    @endif

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <form class="row g-2" method="GET" action="{{ route('auditoria.index') }}">
                <div class="col-12 col-md-2">
                    <label class="form-label mb-1">Acción</label>
                    <select name="accion" class="form-select">
                        <option value="">Todas</option>
                        @foreach($acciones as $accion)
                        <option value="{{ $accion }}" @selected(request('accion')==$accion)>{{ $accion }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-2">
                    <label class="form-label mb-1">Módulo</label>
                    <input type="text" name="modulo" class="form-control" value="{{ request('modulo') }}"
                        placeholder="Usuarios...">
                </div>

                <div class="col-12 col-md-2">
                    <label class="form-label mb-1">Tabla</label>
                    <input type="text" name="tabla" class="form-control" value="{{ request('tabla') }}"
                        placeholder="users">
                </div>

                <div class="col-12 col-md-2">
                    <label class="form-label mb-1">Registro ID</label>
                    <input type="number" name="registro_id" class="form-control" value="{{ request('registro_id') }}"
                        placeholder="1">
                </div>

                <div class="col-12 col-md-2">
                    <label class="form-label mb-1">User ID</label>
                    <input type="number" name="user_id" class="form-control" value="{{ request('user_id') }}"
                        placeholder="1">
                </div>

                <div class="col-12 col-md-2 d-flex align-items-end gap-2">
                    <button class="btn btn-primary w-100" type="submit">Filtrar</button>
                    <a class="btn btn-outline-secondary w-100" href="{{ route('auditoria.index') }}">Limpiar</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Acción</th>
                        <th>Módulo</th>
                        <th>Tabla</th>
                        <th>Registro</th>
                        <th>Usuario</th>
                        <th>IP</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($auditorias as $a)
                    <tr>
                        <td>{{ $a->id }}</td>
                        <td>{{ $a->created_at?->format('Y-m-d H:i') }}</td>
                        <td><span class="badge text-bg-secondary">{{ $a->accion }}</span></td>
                        <td>{{ $a->modulo ?? '-' }}</td>
                        <td>{{ $a->tabla ?? '-' }}</td>
                        <td>{{ $a->registro_id ?? '-' }}</td>
                        <td>{{ $a->user?->name ?? 'N/A' }}</td>
                        <td>{{ $a->ip ?? '-' }}</td>
                        <td class="text-end">
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('auditoria.show', $a) }}">Ver</a>

                            <form class="d-inline" method="POST" action="{{ route('auditoria.destroy', $a) }}"
                                onsubmit="return confirm('¿Eliminar este registro de auditoría?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" type="submit">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">No hay registros de auditoría.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-body">
            {{ $auditorias->links() }}
        </div>
    </div>

</div>
@endsection