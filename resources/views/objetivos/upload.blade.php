@extends('layouts.app')

@section('content')
<div class="container">

    <h4 class="mb-4">Cargar Objetivos Estratégicos</h4>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    {{-- Mensajes de error --}}
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('objetivos.upload.store') }}" method="POST" enctype="multipart/form-data" class="card p-3">
        @csrf

        <div class="mb-3">
            <label class="form-label">Seleccionar archivo (PDF o Excel)</label>
            <input type="file" name="archivo" class="form-control" accept=".pdf,.xlsx" required>
            <small class="text-muted">Tamaño máximo: 5 MB</small>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                Cargar archivo
            </button>

            <a href="{{ route('objetivos.index') }}" class="btn btn-secondary">
                Cancelar
            </a>
        </div>
    </form>

</div>
@endsection