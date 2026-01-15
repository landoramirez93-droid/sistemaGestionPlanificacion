@extends('layouts.app')
@section('title','Editar Meta ODS')

@section('content')
<h4 class="mb-3">Editar Meta ODS</h4>
@include('ods.metas.partials._errors')

<form class="card p-3 shadow-sm" method="POST" action="{{ route('ods.metas.update',$meta) }}">
    @csrf
    @method('PUT')
    @include('ods.metas.partials._form')
    <div class="mt-3 d-flex gap-2">
        <button class="btn btn-primary">Actualizar</button>
        <a href="{{ route('ods.metas.index') }}" class="btn btn-secondary">Cancelar</a>
    </div>
</form>
@endsection