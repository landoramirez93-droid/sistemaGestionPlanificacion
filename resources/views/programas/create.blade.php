@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Nuevo Programa</h4>

    @if ($errors->any())
    <div class="alert alert-danger">Revise los campos marcados.</div>
    @endif

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('programas.store') }}">
                @include('programas._form', ['programa' => null])
            </form>
        </div>
    </div>
</div>
@endsection