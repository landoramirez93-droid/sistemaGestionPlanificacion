<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ObjetivosEstrategicosController;

Route::resource('users', UserController::class);

// ✅ Primero rutas especiales (antes del resource)
Route::get('objetivos/upload', [ObjetivosEstrategicosController::class, 'uploadForm'])
    ->name('objetivos.upload');

Route::post('objetivos/upload', [ObjetivosEstrategicosController::class, 'upload'])
    ->name('objetivos.upload.store');

// ✅ Luego el CRUD resource
Route::resource('objetivos', ObjetivosEstrategicosController::class);