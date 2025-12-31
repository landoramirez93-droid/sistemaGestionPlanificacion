@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')
<h3>Editar Usuario</h3>

<form action="{{ route('users.update', $user) }}" method="POST">
    @method('PUT')
    @include('users._form', ['user' => $user])
</form>
@endsection