@extends('layouts.app')

@push('styles')
<link href="{{ asset('css/users.css') }}" rel="stylesheet">
@endpush

@section('title', 'Inicio')

@section('content')
<div class="container py-4">

    <div class="p-4 bg-light border rounded">
        <h2 class="mb-2">Bienvenido al Sistema de Gestión de Planificación</h2>
        <p class="text-muted mb-0">
            Desde aquí puedes gestionar Usuarios, Objetivos, Programas y Proyectos.
        </p>
    </div>

    <div class="row g-3 mt-3">
        <div class="col-md-3">
            <a href="{{ route('users.index') }}" class="text-decoration-none">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title mb-1">👤 Usuarios</h5>
                        <p class="card-text text-muted">Administrar usuarios y roles.</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('objetivos.index') }}" class="text-decoration-none">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title mb-1">🎯 Objetivos</h5>
                        <p class="card-text text-muted">Gestionar objetivos estratégicos.</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('programas.index') }}" class="text-decoration-none">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title mb-1">📌 Programas</h5>
                        <p class="card-text text-muted">Gestionar programas institucionales.</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('proyectos.index') }}" class="text-decoration-none">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title mb-1">📁 Proyectos</h5>
                        <p class="card-text text-muted">Gestionar proyectos por programa.</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

</div>
@endsection