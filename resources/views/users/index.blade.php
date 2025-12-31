@extends('layouts.app')

@push('styles')
<link href="{{ asset('css/users.css') }}" rel="stylesheet">
@endpush

@section('title', 'Usuarios')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h1>Gestión de Usuarios</h1>
    <a href="{{ route('users.create') }}" class="btn btn-primary">Nuevo Usuario</a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th width="180">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($users as $user)
        <tr>
            <td class="text-muted">{{ $user->id }}</td>
            <td class="fw-semibold">{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td class="text-center">
                <div class="btn-group btn-group-sm" role="group">

                    <a href="{{ route('users.show', $user) }}" class="btn btn-outline-info" title="Ver usuario">
                        👁 Ver
                    </a>

                    <a href="{{ route('users.edit', $user) }}" class="btn btn-outline-warning" title="Editar usuario">
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
            <td colspan="4" class="text-center text-muted py-4">
                <em>No existen usuarios registrados</em>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection