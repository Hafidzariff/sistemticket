<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Helpdesk Surabraja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .alert { transition: opacity 0.5s ease-in-out; }

        /* 🔹 Styling logo agar rapi di navbar */
        .navbar-brand img {
            width: 35px;
            height: 35px;
            object-fit: contain;
            background-color: white;
            border-radius: 6px;
            padding: 2px;
            margin-right: 8px;
            box-shadow: 0 0 3px rgba(0, 0, 0, 0.2);
        }

        /* 🔹 Responsive tweak */
        @media (max-width: 576px) {
            .navbar-brand img {
                width: 28px;
                height: 28px;
            }
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4 shadow-sm">
    <div class="container">
        {{-- 🔹 Logo + Nama Aplikasi --}}
        <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ url('/') }}">
            <img src="{{ asset('/img/logosurabraja.png') }}" alt="Logo Surabraja">
            Helpdesk Surabraja
        </a>

        {{-- 🔹 Menu kanan --}}
        <div>
            @if(session('is_admin'))
                {{-- Menu untuk ADMIN --}}
                <a href="{{ route('dashboard') }}" class="btn btn-light btn-sm me-2">📊 Dashboard</a>
                <a href="{{ route('reports.index') }}" class="btn btn-light btn-sm me-2">📋 Daftar Laporan</a>
                <a href="{{ route('admin.logout') }}" class="btn btn-danger btn-sm">🚪 Logout</a>
            @else
                {{-- Menu untuk USER --}}
                <a href="{{ route('reports.create') }}" class="btn btn-light btn-sm me-2">📝 Form Laporan</a>
                <a href="{{ route('admin.login') }}" class="btn btn-outline-light btn-sm">🔐 Login Admin</a>
            @endif
        </div>
    </div>
</nav>

<div class="container">
    {{-- ✅ Notifikasi umum --}}
    @if(session('success') || session('error') || $errors->any())
        @php
            $type = session('success') ? 'success' : (session('error') ? 'danger' : 'warning');
            $message = session('success') ?? session('error') ?? null;
        @endphp
        <div class="alert alert-{{ $type }} alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert" id="main-alert">
            <div>
                @if($message)
                    {{ $message }}
                @elseif($errors->any())
                    ⚠️ Terjadi kesalahan:
                    <ul class="mb-0 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    setTimeout(() => {
        const alert = document.getElementById('main-alert');
        if (alert) {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }
    }, 3000);
</script>
</body>
</html>
