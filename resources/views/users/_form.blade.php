@csrf

<div class="mb-3">
    <label class="form-label">Nombre</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Correo</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}">
</div>

@if(!isset($user))
<div class="mb-3">
    <label class="form-label">Contraseña</label>
    <input type="password" name="password" class="form-control">
</div>
@endif

<button class="btn btn-success">Guardar</button>
<a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>