@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Editar Entidad</h4>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('entidad.update', $entidad->id) }}" method="POST">
        @csrf
        @method('PUT')

        @include('entidad.from', ['entidad' => $entidad])

        <button class="btn btn-primary">Actualizar</button>
        <a href="{{ route('entidad.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection