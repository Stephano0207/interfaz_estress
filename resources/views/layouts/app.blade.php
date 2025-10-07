<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Student Stress Predictor') }}</title>

    <!-- Fuentes -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Estilos del layout -->
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --success-color: #4cc9f0;
            --warning-color: #f8961e;
            --danger-color: #f72585;
        }
        body { font-family: 'Open Sans', sans-serif; background-color: #f5f7fb; color: var(--dark-color); }
        .navbar { background-color: white; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); }
        .navbar-brand { font-family: 'Poppins', sans-serif; font-weight: 600; color: var(--primary-color) !important; font-size: 1.5rem; }

        /* OJO: esta clase afecta a TODAS las .container de la página (incluida la navbar) */
        .container {
            max-width: 800px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 2.5rem;
            margin-top: 2rem;
            margin-bottom: 2rem;
        }

        h1, h2, h3, h4 { font-family: 'Poppins', sans-serif; color: var(--primary-color); }
        .btn-primary { background-color: var(--primary-color); border-color: var(--primary-color); padding: 0.5rem 1.75rem; font-weight: 500; transition: all 0.3s ease; }
        .btn-primary:hover { background-color: var(--secondary-color); border-color: var(--secondary-color); transform: translateY(-2px); }
        .form-label { font-weight: 500; margin-bottom: 0.5rem; }
        .form-control { border-radius: 8px; padding: 0.75rem 1rem; border: 1px solid #dee2e6; }
        .form-control:focus { border-color: var(--primary-color); box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25); }
        .table-hover tbody tr:hover { background-color: rgba(67, 97, 238, 0.05); }
        .badge.bg-danger { background-color: #f72585 !important; }
        .badge.bg-warning { background-color: #f8961e !important; }
        .badge.bg-success { background-color: #4cc9f0 !important; color: #000; }
        .pagination .page-item.active .page-link { background-color: var(--primary-color); border-color: var(--primary-color); }
        .pagination .page-link { color: var(--primary-color); }
        /* Estado activo en navbar */
        .nav-link.active { font-weight: 600; color: var(--secondary-color) !important; }
        .nav-link i { margin-right: .35rem; }
    </style>

    {{-- Para que las vistas puedan inyectar estilos propios --}}
    @stack('styles')
</head>

<body>
<div id="app">
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container-fluid py-2 px-3" style="box-shadow:none;background:white;border-radius:0;margin:0;max-width:100%;padding:0 1rem;">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-brain me-2"></i>{{ config('app.name', 'Stress Predictor') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                @auth
                    <ul class="navbar-nav ms-auto align-items-lg-center">
                        @if (auth()->user()->roles[0]->name == 'admin')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('stress.form') ? 'active' : '' }}" href="{{ route('stress.form') }}">
                                    <i class="fas fa-chart-line"></i>Stress Prediction
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('survey.*') ? 'active' : '' }}" href="{{ route('survey.form') }}">
                                    <i class="fas fa-clipboard-list"></i>Encuesta
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('predictions.list') ? 'active' : '' }}" href="{{ route('predictions.list') }}">
                                    <i class="fa-solid fa-users"></i>Students
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}" href="{{ route('users.index') }}">
                                    <i class="fa-solid fa-user-gear"></i>Users
                                </a>
                            </li>
                        @endif

                        @if (auth()->user()->roles[0]->name == 'psychologist')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('predictions.list') ? 'active' : '' }}" href="{{ route('predictions.list') }}">
                                    <i class="fa-solid fa-users"></i>Students
                                </a>
                            </li>
                        @endif

                        @if (auth()->user()->roles[0]->name == 'student')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('stress.form') ? 'active' : '' }}" href="{{ route('stress.form') }}">
                                    <i class="fas fa-chart-line"></i>Stress Prediction
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('survey.*') ? 'active' : '' }}" href="{{ route('survey.form') }}">
                                    <i class="fas fa-clipboard-list"></i>Encuesta
                                </a>
                            </li>
                        @endif

                        <li class="nav-item ms-lg-3">
                            <form method="POST" action="{{ route('logout') }}" class="mb-0">
                                @csrf
                                <a href="{{ route('logout') }}"
                                   class="nav-link"
                                   onclick="event.preventDefault(); this.closest('form').submit();">
                                    <i class="fas fa-sign-out-alt"></i>Cerrar Sesión
                                </a>
                            </form>
                        </li>
                    </ul>
                @endauth
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</div>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Scripts por-vista -->
@stack('scripts')
</body>
</html>
