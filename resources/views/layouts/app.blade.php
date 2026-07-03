<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Koperasi') }} | Dashboard</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        
        /* Sidebar Styling */
        .sidebar { min-height: 100vh; background: #2c3e50; color: #fff; width: 260px; transition: 0.3s; }
        .nav-link { color: #bdc3c7; padding: 12px 20px; border-radius: 8px; margin: 4px 10px; transition: 0.2s; }
        .nav-link:hover, .nav-link.active { background: #34495e; color: #fff; }
        .nav-link i { margin-right: 10px; }
        
        /* Main Content */
        .main-content { flex: 1; padding: 2rem; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

<div class="d-flex">
    <nav class="sidebar d-flex flex-column flex-shrink-0 p-3">
        <a href="/" class="d-flex align-items-center mb-4 text-white text-decoration-none px-2">
            <i class="bi bi-bank fs-4 me-2"></i>
            <span class="fs-5 fw-bold">Koperasi</span>
        </a>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="{{ url('/dashboard') }}" class="nav-link {{ request()->is('dashboard*') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/anggota') }}" class="nav-link {{ request()->is('anggota*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Anggota
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/simpanan') }}" class="nav-link {{ request()->is('simpanan*') ? 'active' : '' }}">
                    <i class="bi bi-wallet2"></i> Simpanan
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/pinjaman') }}" class="nav-link {{ request()->is('pinjaman*') ? 'active' : '' }}">
                    <i class="bi bi-cash-stack"></i> Pinjaman
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/angsuran') }}" class="nav-link {{ request()->is('angsuran*') ? 'active' : '' }}">
                    <i class="bi bi-graph-up-arrow"></i> Angsuran
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/tamu') }}" class="nav-link {{ request()->is('tamu*') ? 'active' : '' }}">
                    <i class="bi bi-person-lines-fill"></i> Tamu
                </a>
            </li>
        </ul>
    </nav>

    <div class="main-content">
        <header class="d-flex justify-content-between align-items-center pb-4 border-bottom mb-4">
            <h4 class="m-0 fw-bold text-secondary">Sistem Koperasi</h4>
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                    {{ Auth::user()->name }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Profil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="dropdown-item text-danger"><i class="bi bi-box-arrow-right"></i> Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </header>

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>    @stack('scripts')</body>
</html>