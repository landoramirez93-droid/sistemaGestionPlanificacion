@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')
<h3>Editar Usuario</h3>

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('users.update', $user) }}" method="POST">
    @csrf
    @method('PUT')

    @include('users._form', ['user' => $user, 'roles' => $roles])
</form>
@endsection