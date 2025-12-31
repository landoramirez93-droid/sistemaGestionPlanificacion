<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Sistema de Gestión de Planificación')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS propio -->
    <link href="{{ asset('css/inde.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body>

    <div class="d-flex" id="wrapper">

        <!-- SIDEBAR -->
        <aside class="bg-dark text-white p-3" style="width: 240px; min-height: 100vh;">
            <h5 class="text-center mb-4">📊 Planificación</h5>

            <ul class="nav nav-pills flex-column gap-2">
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link text-white">
                        👤 Usuarios
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-white">
                        📑 Planes
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-white">
                        🎯 Objetivos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-white">
                        📈 Seguimiento
                    </a>
                </li>
            </ul>
        </aside>

        <!-- CONTENIDO -->
        <div class="flex-grow-1">

            <!-- HEADER -->
            <nav class="navbar navbar-light bg-white shadow-sm px-4">
                <span class="navbar-text fw-semibold">
                    @yield('title')
                </span>

                <div>
                    <span class="me-3 text-muted">Administrador</span>
                    <a href="#" class="btn btn-outline-danger btn-sm">Salir</a>
                </div>
            </nav>

            <!-- MAIN -->
            <main class="p-4">
                @yield('content')
            </main>

            <!-- FOOTER -->
            <footer class="text-center text-muted py-3">
                © {{ date('Y') }} Sistema de Gestión de Planificación
            </footer>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>

</html>