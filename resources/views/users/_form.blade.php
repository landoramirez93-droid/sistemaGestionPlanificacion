@csrf

<div class="mb-3">
    <label class="form-label">Nombre</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Correo</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Rol</label>
    <select name="rol_id" class="form-control" required>
        <option value="">Seleccione un rol</option>

        @foreach($roles as $rol)
        <option value="{{ $rol->id }}"
            {{ (int) old('rol_id', $user->rol_id ?? 0) === (int) $rol->id ? 'selected' : '' }}>
            {{ $rol->nombre }}
        </option>
        @endforeach

    </select>
</div>

@if(!isset($user))
<div class="mb-3">
    <label class="form-label">Contraseña</label>
    <input type="password" name="password" class="form-control" required>
</div>
@endif

<button class="btn btn-success">Guardar</button>
<a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>