@extends('layouts.app')
@section('title','Editar Plan')

@section('content')
<h4 class="mb-3">Editar Plan: <span class="text-primary">{{ $plan->nombre }}</span></h4>

@include('planes.partials._errors')

<form action="{{ route('planes.update', $plan) }}" method="POST" class="card shadow-sm p-3">
    @csrf
    @method('PUT')
    @include('planes.partials._form', ['plan' => $plan])
    <div class="mt-3 d-flex gap-2">
        <button class="btn btn-primary">Actualizar</button>
        <a href="{{ route('planes.index') }}" class="btn btn-secondary">Cancelar</a>
    </div>
</form>
@endsection