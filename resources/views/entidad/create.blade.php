@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Crear Entidad</h4>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('entidad.store') }}" method="POST">
        @csrf

        @include('entidad.from', ['entidad' => null])

        <button class="btn btn-primary">Guardar</button>
        <a href="{{ route('entidad.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection