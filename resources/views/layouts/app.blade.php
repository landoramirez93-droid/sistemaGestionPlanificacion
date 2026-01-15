<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Sistema de Gestión de Planificación')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS propio -->
    <link href="{{ asset('css/inde.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body class="bg-light">

    <div class="d-flex min-vh-100" id="wrapper">

        <!-- SIDEBAR -->
        <aside class="sidebar bg-dark text-white d-flex flex-column p-3">

            <!-- Brand -->
            <div class="d-flex align-items-center gap-2 mb-4">
                <div class="brand-icon">📊</div>
                <div class="lh-sm">
                    <div class="fw-semibold">Planificación</div>
                    <small class="text-secondary">SGP</small>
                </div>
            </div>

            <!-- Menu -->
            <nav class="sidebar-nav flex-grow-1">
                <ul class="nav nav-pills flex-column gap-1">

                    <li class="sidebar-section">Administración</li>

                    @if(\Illuminate\Support\Facades\Route::has('users.index'))
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}"
                            class="nav-link sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                            <span class="me-2">👤</span>
                            <span>Usuarios</span>
                        </a>
                    </li>
                    @endif

                    @if(\Illuminate\Support\Facades\Route::has('entidad.index'))
                    <li class="nav-item">
                        <a href="{{ route('entidad.index') }}"
                            class="nav-link sidebar-link {{ request()->routeIs('entidad.*') ? 'active' : '' }}">
                            <span class="me-2">🏛️</span>
                            <span>Entidades</span>
                        </a>
                    </li>
                    @endif

                    <li class="sidebar-section mt-3">Planificación</li>

                    @if(\Illuminate\Support\Facades\Route::has('objetivos.index'))
                    <li class="nav-item">
                        <a href="{{ route('objetivos.index') }}"
                            class="nav-link sidebar-link {{ request()->routeIs('objetivos.*') ? 'active' : '' }}">
                            <span class="me-2">🎯</span>
                            <span>Objetivos Estratégicos</span>
                        </a>
                    </li>
                    @endif

                    @if(\Illuminate\Support\Facades\Route::has('proyectos.index'))
                    <li class="nav-item">
                        <a href="{{ route('proyectos.index') }}"
                            class="nav-link sidebar-link {{ request()->routeIs('proyectos.*') ? 'active' : '' }}">
                            <span class="me-2">🧩</span>
                            <span>Proyectos</span>
                        </a>
                    </li>
                    @endif

                    @if(\Illuminate\Support\Facades\Route::has('programas.index'))
                    <li class="nav-item">
                        <a href="{{ route('programas.index') }}"
                            class="nav-link sidebar-link {{ request()->routeIs('programas.*') ? 'active' : '' }}">
                            <span class="me-2">📌</span>
                            <span>Programas</span>
                        </a>
                    </li>
                    @endif

                    @if(\Illuminate\Support\Facades\Route::has('planes.index'))
                    <li class="nav-item">
                        <a href="{{ route('planes.index') }}"
                            class="nav-link sidebar-link {{ request()->routeIs('planes.*') ? 'active' : '' }}">
                            <span class="me-2">📑</span>
                            <span>Planes</span>
                        </a>
                    </li>
                    @endif

                    <!-- ODS (desplegable) -->
                    <li class="nav-item">
                        <a class="nav-link sidebar-link d-flex justify-content-between align-items-center"
                            data-bs-toggle="collapse" href="#menuOds" role="button"
                            aria-expanded="{{ request()->routeIs('ods.*') ? 'true' : 'false' }}"
                            aria-controls="menuOds">
                            <span>
                                <span class="me-2">🌍</span>
                                <span>ODS</span>
                            </span>
                            <span class="small opacity-75">▾</span>
                        </a>

                        <div class="collapse {{ request()->routeIs('ods.*') ? 'show' : '' }}" id="menuOds">
                            <ul class="nav flex-column ms-3 mt-1 gap-1">

                                @if(\Illuminate\Support\Facades\Route::has('ods.metas.index'))
                                <li class="nav-item">
                                    <a class="nav-link sidebar-link sidebar-sublink {{ request()->routeIs('ods.metas.*') ? 'active' : '' }}"
                                        href="{{ route('ods.metas.index') }}">
                                        • Metas
                                    </a>
                                </li>
                                @endif

                                @if(\Illuminate\Support\Facades\Route::has('ods.indicadores.index'))
                                <li class="nav-item">
                                    <a class="nav-link sidebar-link sidebar-sublink {{ request()->routeIs('ods.indicadores.*') ? 'active' : '' }}"
                                        href="{{ route('ods.indicadores.index') }}">
                                        • Indicadores
                                    </a>
                                </li>
                                @endif

                            </ul>
                        </div>
                    </li>

                    <li class="sidebar-section mt-3">Control</li>

                    @if(\Illuminate\Support\Facades\Route::has('auditoria.index'))
                    <li class="nav-item">
                        <a href="{{ route('auditoria.index') }}"
                            class="nav-link sidebar-link {{ request()->routeIs('auditoria.*') ? 'active' : '' }}">
                            <span class="me-2">✅</span>
                            <span>Auditoría</span>
                        </a>
                    </li>
                    @endif

                </ul>
            </nav>

            <!-- Footer sidebar -->
            <div class="pt-3 border-top border-secondary small">
                <div class="text-secondary">© {{ date('Y') }}</div>
                <div class="text-secondary">SGP - Planificación</div>
            </div>
        </aside>

        <!-- CONTENIDO PRINCIPAL -->
        <div class="flex-grow-1 d-flex flex-column">

            <!-- HEADER -->
            <nav class="navbar navbar-light bg-white shadow-sm px-4">
                <span class="navbar-text fw-semibold">
                    @yield('title', 'Dashboard')
                </span>

                <div class="d-flex align-items-center gap-2">
                    @auth
                    <div class="d-flex align-items-center gap-3">

                        {{-- Nombre + rol (en columna) --}}
                        <div class="d-flex flex-column lh-sm">
                            <span class="fw-semibold">{{ auth()->user()->name }}</span>
                            <span class="badge bg-primary align-self-start mt-1">
                                {{ auth()->user()->rol->nombre ?? 'Sin rol' }}
                            </span>
                        </div>

                        {{-- Botón salir --}}
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm">Salir</button>
                        </form>

                    </div>
                    @endauth

                </div>
            </nav>

            <!-- MAIN -->
            <main class="p-4 flex-grow-1">
                @yield('content')
            </main>

            <!-- FOOTER -->
            <footer class="text-center text-muted py-3 bg-white border-top">
                © {{ date('Y') }} Sistema de Gestión de Planificación
            </footer>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>