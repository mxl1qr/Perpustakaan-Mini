<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} — Bootstrap</title>

        <!-- Google Fonts: Inter -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap Icons -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

        <style>
            body {
                font-family: 'Inter', sans-serif;
                background-color: #f0f2f5;
            }

            /* ── Navbar ── */
            .navbar-app {
                background: linear-gradient(135deg, #1e3a5f 0%, #2d5f8a 100%);
                box-shadow: 0 2px 12px rgba(0, 0, 0, .15);
            }
            .navbar-app .navbar-brand {
                font-weight: 700;
                font-size: 1.25rem;
                letter-spacing: -.5px;
            }
            .navbar-app .nav-link {
                font-weight: 500;
                transition: opacity .2s;
            }
            .navbar-app .nav-link:hover {
                opacity: .85;
            }

            /* ── Page Header ── */
            .page-header {
                background: #fff;
                border-bottom: 1px solid #dee2e6;
                box-shadow: 0 1px 4px rgba(0,0,0,.04);
            }
            .page-header h2 {
                font-weight: 600;
                font-size: 1.15rem;
                margin: 0;
                color: #1e293b;
            }

            /* ── Card ── */
            .card-main {
                border: none;
                border-radius: .75rem;
                box-shadow: 0 1px 6px rgba(0,0,0,.08);
            }

            /* ── Badge label ── */
            .badge-version {
                font-size: .65rem;
                vertical-align: middle;
                background: rgba(255,255,255,.2);
                border: 1px solid rgba(255,255,255,.3);
                border-radius: 999px;
                padding: 2px 8px;
                margin-left: 8px;
                font-weight: 600;
                letter-spacing: .5px;
            }

            /* ── Smooth transitions ── */
            .btn { transition: all .2s ease; }
            .table tbody tr { transition: background .15s ease; }
        </style>
    </head>
    <body>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark navbar-app py-2">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/buku-bootstrap') }}">
                    <i class="bi bi-book me-2"></i>
                    {{ config('app.name', 'Laravel') }}
                    <span class="badge-version text-white-50">Bootstrap</span>
                </a>
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/buku-bootstrap') }}">
                                <i class="bi bi-journal-bookmark-fill me-1"></i> Daftar Buku
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('buku.index') }}">
                                <i class="bi bi-arrow-left-right me-1"></i> Versi Tailwind
                            </a>
                        </li>
                        @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item" type="submit">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Page Header -->
        @isset($header)
        <div class="page-header">
            <div class="container py-3">
                {{ $header }}
            </div>
        </div>
        @endisset

        <!-- Page Content -->
        <main class="container py-4">
            {{ $slot }}
        </main>

        <!-- Bootstrap 5 JS Bundle -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
