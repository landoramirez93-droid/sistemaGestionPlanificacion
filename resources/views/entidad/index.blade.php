@extends('layouts.app')

@push('styles')
<link href="{{ asset('css/users.css') }}" rel="stylesheet">
@endpush

@section('title', 'Entidades')

@section('content')
<div class="container">

    {{-- Encabezado --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div>
            <h4 class="mb-0">Entidades</h4>
            <small class="text-muted">
                Total: {{ method_exists($entidades, 'total') ? $entidades->total() : $entidades->count() }}
            </small>
        </div>

        <a href="{{ route('entidad.create') }}" class="btn btn-primary">
            Nueva Entidad
        </a>
    </div>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 70px;">ID</th>
                            <th>Nombre</th>
                            <th>Sigla</th>
                            <th>Tipo</th>
                            <th>Nivel</th>
                            <th>Estado</th>
                            <th class="text-end" style="width: 190px;">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($entidades as $entidad)
                        <tr>
                            <td class="fw-semibold">{{ $entidad->id }}</td>
                            <td>{{ $entidad->nombre }}</td>
                            <td><span class="badge text-bg-secondary">{{ $entidad->sigla }}</span></td>
                            <td>{{ $entidad->tipo }}</td>
                            <td>{{ $entidad->nivel }}</td>

                            {{-- Estado --}}
                            <td>
                                @if($entidad->estado == 1)
                                <span class="badge text-bg-success">Activo</span>
                                @else
                                <span class="badge text-bg-danger">Inactivo</span>
                                @endif
                            </td>

                            <td class="text-end">
                                <div class="btn-group" role="group" aria-label="Acciones">
                                    <a href="{{ route('entidad.show', $entidad) }}"
                                        class="btn btn-sm btn-outline-info">👁 Ver</a>
                                    <a href="{{ route('entidad.edit', $entidad) }}"
                                        class="btn btn-sm btn-outline-warning">✏ Editar</a>

                                    <form action="{{ route('entidad.destroy', $entidad) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('¿Eliminar esta entidad? Esta acción no se puede deshacer.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">🗑 Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                No existen entidades registradas.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>

        {{-- Paginación --}}
        @if(method_exists($entidades, 'links'))
        <div class="card-footer d-flex justify-content-end">
            {{ $entidades->links() }}
        </div>
        @endif
    </div>

</div>
@endsection