@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Editar Programa #{{ $programa->id }}</h4>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('programas.update', $programa) }}">
                @method('PUT')
                @include('programas._form', ['programa' => $programa])
            </form>
        </div>
    </div>
</div>
@endsection