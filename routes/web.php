<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EntidadController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\ObjetivoEstrategicoController;
use App\Http\Controllers\ProgramaController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\OdsMetaController;

/*
|--------------------------------------------------------------------------
| Rutas públicas (auth)
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => redirect()->route('login'));

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Rutas protegidas
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    /*
    |--------------------------------------------------------------------------
    | USUARIOS (solo Administrador / TI)
    |--------------------------------------------------------------------------
    */
    Route::resource('users', UserController::class)
        ->middleware('role:Administrador,TI');

    /*
    |--------------------------------------------------------------------------
    | AUDITORÍA (Auditor / Administrador / TI) - solo lectura
    |--------------------------------------------------------------------------
    | Nota: ajusto names/parameters para que route('auditoria.index') funcione.
    */
    Route::resource('auditorias', AuditoriaController::class)
        ->only(['index', 'show'])
        ->names('auditoria')
        ->parameters(['auditorias' => 'auditoria'])
        ->middleware('role:Auditor,Administrador,TI');

    /*
    |--------------------------------------------------------------------------
    | ENTIDADES (VER vs CRUD)
    |--------------------------------------------------------------------------
    */
    Route::resource('entidades', EntidadController::class)
        ->except(['index', 'show'])
        ->names('entidad')
        ->parameters(['entidades' => 'entidad'])
        ->middleware('role:Administrador,TI');
        
    Route::resource('entidades', EntidadController::class)
        ->only(['index', 'show'])
        ->names('entidad')
        ->parameters(['entidades' => 'entidad'])
        ->middleware('role:Administrador,TI,Técnico de Planificación,Revisor Institucional,Validador (SNP / Ente Rector),Auditor');

    /*
    |--------------------------------------------------------------------------
    | ODS / METAS (VER vs CRUD)
    |--------------------------------------------------------------------------
    | Importante: el parámetro debe ser {meta} para que OdsMeta $meta funcione.
    */
        // CRUD (solo Admin/TI)
    Route::resource('ods-metas', OdsMetaController::class)
        ->names('ods.metas')
        ->except(['index', 'show'])
        ->middleware('role:Administrador,TI');
        
    // VER (internos)
    Route::resource('ods-metas', OdsMetaController::class)
        ->names('ods.metas')
        ->only(['index', 'show'])
        ->middleware('role:Administrador,TI,Técnico de Planificación,Revisor Institucional,Validador (SNP / Ente Rector),Auditor');

    /*
    |--------------------------------------------------------------------------
    | OBJETIVOS ESTRATÉGICOS (VER vs CRUD)
    |--------------------------------------------------------------------------
    | Tu controller NO tiene show(), así que dejo solo index en lectura.
    | Si luego creas show(), puedes agregarlo.
    */
    Route::resource('objetivos-estrategicos', ObjetivoEstrategicoController::class)
        ->only(['index'])
        ->names('objetivos')
        ->parameters(['objetivos-estrategicos' => 'objetivo'])
        ->middleware('role:Administrador,TI,Técnico de Planificación,Revisor Institucional,Validador (SNP / Ente Rector),Auditor');

    Route::resource('objetivos-estrategicos', ObjetivoEstrategicoController::class)
        ->except(['index', 'show'])
        ->names('objetivos')
        ->parameters(['objetivos-estrategicos' => 'objetivo'])
        ->middleware('role:Administrador,TI');

    // Rutas extra de upload (si las estás usando)
    Route::get('objetivos-estrategicos/upload', [ObjetivoEstrategicoController::class, 'uploadForm'])
        ->name('objetivos.uploadForm')
        ->middleware('role:Administrador,TI');

    Route::post('objetivos-estrategicos/upload', [ObjetivoEstrategicoController::class, 'upload'])
        ->name('objetivos.upload')
        ->middleware('role:Administrador,TI');

    /*
    |--------------------------------------------------------------------------
    | PLANES (VER vs CRUD)
    |--------------------------------------------------------------------------
    | Tu controller NO tiene show(), así que dejo solo index en lectura.
    | Importante: el parámetro debe ser {plan} (no {plane}).
    */
    Route::resource('planes', PlanController::class)
        ->only(['index'])
        ->parameters(['planes' => 'plan'])
        ->middleware('role:Administrador,TI,Técnico de Planificación,Revisor Institucional,Validador (SNP / Ente Rector),Auditor');

    Route::resource('planes', PlanController::class)
        ->except(['index', 'show'])
        ->parameters(['planes' => 'plan'])
        ->middleware('role:Administrador,TI');

    /*
    |--------------------------------------------------------------------------
    | PROGRAMAS (VER vs CRUD)
    |--------------------------------------------------------------------------
    */
    Route::resource('programas', ProgramaController::class)
        ->only(['index', 'show'])
        ->parameters(['programas' => 'programa'])
        ->middleware('role:Administrador,TI,Técnico de Planificación,Revisor Institucional,Validador (SNP / Ente Rector),Auditor');

    Route::resource('programas', ProgramaController::class)
        ->except(['index', 'show'])
        ->parameters(['programas' => 'programa'])
        ->middleware('role:Administrador,TI');

    /*
    |--------------------------------------------------------------------------
    | PROYECTOS (VER vs CRUD + flujo)
    |--------------------------------------------------------------------------
    */
    Route::resource('proyectos', ProyectoController::class)
        ->only(['index', 'show'])
        ->parameters(['proyectos' => 'proyecto'])
        ->middleware('role:Administrador,TI,Técnico de Planificación,Revisor Institucional,Validador (SNP / Ente Rector),Auditor');

    Route::resource('proyectos', ProyectoController::class)
        ->except(['index', 'show'])
        ->parameters(['proyectos' => 'proyecto'])
        ->middleware('role:Administrador,TI');

    Route::post('proyectos/{proyecto}/aprobar', [ProyectoController::class, 'aprobar'])
        ->name('proyectos.aprobar')
        ->middleware('role:Administrador,TI,Técnico de Planificación,Revisor Institucional');

    Route::post('proyectos/{proyecto}/validar', [ProyectoController::class, 'validar'])
        ->name('proyectos.validar')
        ->middleware('role:Administrador,TI,Validador (SNP / Ente Rector)');

    Route::post('proyectos/{proyecto}/rechazar', [ProyectoController::class, 'rechazar'])
        ->name('proyectos.rechazar')
        ->middleware('role:Administrador,TI,Validador (SNP / Ente Rector)');
});