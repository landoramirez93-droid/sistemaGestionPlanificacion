@extends('layouts.app')

@section('title', 'Detalle Usuario')

@section('content')
<h3>Detalle del Usuario</h3>

<ul class="list-group">
    <li class="list-group-item"><strong>ID:</strong> {{ $user->id }}</li>
    <li class="list-group-item"><strong>Nombre:</strong> {{ $user->name }}</li>
    <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
</ul>

<a href="{{ route('users.index') }}" class="btn btn-secondary mt-3">Volver</a>
@endsection