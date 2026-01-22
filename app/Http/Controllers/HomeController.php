<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{

    /**
     * Muestra la pantalla principal (home) del sistema.
     */
    public function index()
    {
        return view('home');
    }
}