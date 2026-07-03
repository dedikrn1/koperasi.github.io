<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Koperasi') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" rel="stylesheet">

    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container-fluid">

            <a class="navbar-brand fw-bold" href="{{ url('/dashboard') }}">
                <i class="bi bi-bank"></i>
                Koperasi
            </a>

            <button class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarNav">

                <span class="navbar-toggler-icon"></span>

            </button>

            <div class="collapse navbar-collapse" id="navbarNav">

                @auth

                <ul class="navbar-nav me-auto">

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/dashboard') }}">
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('anggota.index') }}">
                            Anggota
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('simpanan.index') }}">
                            Simpanan
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            Pinjaman
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            Angsuran
                        </a>
                    </li>

                </ul>

                <ul class="navbar-nav">

                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle"
                           href="#"
                           role="button"
                           data-bs-toggle="dropdown">

                            {{ Auth::user()->name }}
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">

                            <li>
                                <form method="POST"
                                      action="{{ route('logout') }}">
                                    @csrf

                                    <button type="submit"
                                            class="dropdown-item">
                                        Logout
                                    </button>
                                </form>
                            </li>

                        </ul>

                    </li>

                </ul>

                @endauth

            </div>

        </div>
    </nav>

    <!-- Content -->
    <div class="container mt-4">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                </button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">

                <ul class="mb-0">
                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach
                </ul>

            </div>
        @endif

        @yield('content')

    </div>

    <!-- Footer -->
    <footer class="text-center mt-5 mb-3 text-muted">
        &copy; {{ date('Y') }} Sistem Informasi Koperasi
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>