<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;



class UserController extends Controller
{
    /**
     * Listar usuarios
     */
    public function index()
    {
        $users = User::with('rol')->get();
        return view('users.index', compact('users'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        $roles = Rol::orderBy('nombre')->get();
        return view('users.create', compact('roles'));
    }

    /**
     * Guardar usuario en la BD
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'rol_id'   => 'required|exists:roles,id',
        ]);

        User::create([
            'name'     => $request->input('name'),
            'email'    => $request->input('email'),
            'password' => Hash::make($request->input('password')), // correcto
            'rol_id'   => $request->input('rol_id'),
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuario creado correctamente');
    }

    /**
     * Mostrar usuario específico
     */
    public function show(User $user)
    {
        // Si tu vista necesita el listado de roles, lo cargas:
        $roles = Rol::orderBy('nombre')->get();

        return view('users.show', compact('user', 'roles'));
        // Si tu vista NO necesita roles, usa:
        // return view('users.show', compact('user'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(User $user)
    {
        $roles = Rol::orderBy('nombre')->get();
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Actualizar usuario
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:users,email,' . $user->id,
            'rol_id' => 'required|exists:roles,id',
            // Si deseas permitir cambio de password:
            // 'password' => 'nullable|string|min:8'
        ]);

        $user->update($request->only('name', 'email', 'rol_id'));

        // Si permites cambio de password:
        // if ($request->filled('password')) {
        //     $user->update(['password' => Hash::make($request->input('password'))]);
        // }

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuario actualizado correctamente');
    }

    /**
     * Eliminar usuario
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuario eliminado correctamente');
    }
    
}