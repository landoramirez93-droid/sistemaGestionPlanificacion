@extends('layouts.app')
@section('title','Crear Plan')

@section('content')
<h4 class="mb-3">Crear Plan Institucional</h4>

@include('planes.partials._errors')

<form action="{{ route('planes.store') }}" method="POST" class="card shadow-sm p-3">
    @csrf
    @include('planes.partials._form', ['plan' => null])
    <div class="mt-3 d-flex gap-2">
        <button class="btn btn-primary">Guardar</button>
        <a href="{{ route('planes.index') }}" class="btn btn-secondary">Cancelar</a>
    </div>
</form>
@endsection