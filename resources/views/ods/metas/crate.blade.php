@extends('layouts.app')
@section('title','Crear Meta ODS')

@section('content')
<h4 class="mb-3">Crear Meta ODS</h4>
@include('ods.metas.partials._errors')

<form class="card p-3 shadow-sm" method="POST" action="{{ route('ods.metas.store') }}">
    @csrf
    @include('ods.metas.partials._form', ['meta' => null])
    <div class="mt-3 d-flex gap-2">
        <button class="btn btn-primary">Guardar</button>
        <a href="{{ route('ods.metas.index') }}" class="btn btn-secondary">Cancelar</a>
    </div>
</form>
@endsection