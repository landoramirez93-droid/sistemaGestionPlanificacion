<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

/**
     * Muestra el formulario de inicio de sesión.
     */
    public function showLogin()
    {
        return view('auth.login');
    }
    
    /**
     * Procesa el inicio de sesión.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([ //valida los datos recibidos del formulario
            'email' => ['required','email'],
            'password' => ['required','string'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();  // Regenerar el ID de sesión por seguridad
            return redirect()->route('home');
        }

        return back()
            ->withErrors(['email' => 'Credenciales incorrectas.'])
            ->onlyInput('email');
    }

    /**
     * Cierra la sesión del usuario.
     */

    

    public function logout(Request $request)
    {
        Auth::logout(); 
    // Cierra la sesión del usuario autenticado (desloguea).
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
        // redirige a la pantalla de login.
    }
}