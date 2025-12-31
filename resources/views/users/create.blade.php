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

@section('title', 'Crear Usuario')

@section('content')
<h3>Nuevo Usuario</h3>

<form action="{{ route('users.store') }}" method="POST">
    @include('users._form')
</form>
@endsection