@extends('layouts.app')

@push('styles')
<link href="{{ asset('css/users.css') }}" rel="stylesheet">
@endpush

@section('title', 'Objetivos Estratégicos')

@section('content')
<div class="container">

    <h4 class="mb-4">Gestión de Objetivos Estratégicos</h4>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3 d-flex gap-2">
        <a href="{{ route('objetivos.create') }}" class="btn btn-primary">Nuevo Objetivo</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Meta ODS</th>
                <th>Objetivo</th>
                <th>Descripción</th>
                <th>Línea Estratégica</th>
                <th>Entidad Responsable</th>
                <th>Estado</th>
                <th width="160">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @forelse($objetivos as $objetivo)
            <tr>
                {{-- META ODS (solo OdsMeta) --}}
                <td>
                    @forelse($objetivo->odsMetas as $meta)
                    <div class="mb-1">
                        <span class="badge bg-secondary">
                            {{ $meta->codigo ?? 'Meta' }} -
                            {{ \Illuminate\Support\Str::limit($meta->descripcion ?? '', 60) }}
                        </span>
                    </div>
                    @empty
                    <span class="text-muted">No definida</span>
                    @endforelse
                </td>

                {{-- OBJETIVO --}}
                <td>{{ $objetivo->nombre }}</td>

                {{-- DESCRIPCIÓN --}}
                <td>{{ $objetivo->descripcion }}</td>

                {{-- LÍNEA ESTRATÉGICA --}}
                <td>{{ $objetivo->linea_estrategica }}</td>

                {{-- ENTIDAD RESPONSABLE --}}
                <td>{{ $objetivo->entidadResponsable->nombre ?? 'No asignada' }}</td>

                {{-- ESTADO --}}
                <td>
                    <span class="badge {{ $objetivo->estado ? 'bg-success' : 'bg-secondary' }}">
                        {{ $objetivo->estado ? 'Activo' : 'Inactivo' }}
                    </span>
                </td>

                {{-- ACCIONES --}}
                <td width="160">
                    <a href="{{ route('objetivos.edit', $objetivo) }}" class="btn btn-warning btn-sm">Editar</a>

                    <form action="{{ route('objetivos.destroy', $objetivo) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('¿Está seguro de eliminar este objetivo?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">No existen objetivos registrados.</td>
            </tr>
            @endforelse
        </tbody>

    </table>

    {{ $objetivos->links() }}

</div>
@endsection