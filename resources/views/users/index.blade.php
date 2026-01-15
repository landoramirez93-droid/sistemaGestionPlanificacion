@extends('layouts.app')

@push('styles')
<link href="{{ asset('css/users.css') }}" rel="stylesheet">
@endpush

@section('title', 'Usuarios')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Gestión de Usuarios</h1>
        <a href="{{ route('users.create') }}" class="btn btn-primary">Nuevo Usuario</a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th style="width: 70px;">ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th style="width: 220px;" class="text-center">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse($users as $user)
                <tr>
                    <td class="text-muted">{{ $user->id }}</td>
                    <td class="fw-semibold">{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>

                    {{-- Rol --}}
                    <td>
                        @if($user->rol)
                        <span class="badge bg-info text-dark">
                            {{ $user->rol->nombre }}
                        </span>
                        @else
                        <span class="badge bg-secondary">
                            Sin rol
                        </span>
                        @endif
                    </td>

                    <td class="text-center">
                        <div class="btn-group btn-group-sm" role="group">

                            <a href="{{ route('users.show', $user) }}" class="btn btn-outline-info" title="Ver usuario">
                                👁 Ver
                            </a>

                            <a href="{{ route('users.edit', $user) }}" class="btn btn-outline-warning"
                                title="Editar usuario">
                                ✏ Editar
                            </a>

                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('¿Está seguro de eliminar este usuario?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger" title="Eliminar usuario">
                                    🗑 Eliminar
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        <em>No existen usuarios registrados</em>
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

</div>
@endsection