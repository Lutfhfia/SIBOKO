<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SIBOKO - Panel Dosen">
    <title>@yield('title', 'Dashboard Dosen') — SIBOKO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <style>
        /* Dosen Panel specific colors - Teal/Green theme */
        .dosen-sidebar {
            background: linear-gradient(180deg, #0f766e 0%, #0d9488 100%);
            width: 250px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            color: white;
            z-index: 1000;
        }
        .sidebar-menu li a.active {
            background: rgba(255,255,255,0.15);
            border-left: 4px solid #34d399;
            color: white;
        }
        .sidebar-menu li a:hover {
            background: rgba(255,255,255,0.1);
        }
        .btn-dosen {
            background-color: #0f766e;
            color: white;
        }
        .btn-dosen:hover {
            background-color: #0d9488;
            color: white;
        }
    </style>
</head>
<body>
    {{-- Sidebar --}}
    <aside class="dosen-sidebar admin-sidebar">
        <div class="sidebar-brand">
            <h4><i class="bi bi-calendar2-check"></i> SIBOKO</h4>
            <small>Panel Dosen</small>
        </div>
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('dosen-panel.dashboard') }}" class="{{ request()->routeIs('dosen-panel.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2-fill"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('dosen-panel.jadwal.index') }}" class="{{ request()->routeIs('dosen-panel.jadwal.*') ? 'active' : '' }}">
                    <i class="bi bi-clock-fill"></i> Buka Bimbingan
                </a>
            </li>
            <li>
                <a href="{{ route('dosen-panel.booking.index') }}" class="{{ request()->routeIs('dosen-panel.booking.*') ? 'active' : '' }}">
                    <i class="bi bi-journal-bookmark-fill"></i> Booking Masuk
                </a>
            </li>
            <li style="margin-top: 20px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 10px;">
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-link text-white text-decoration-none" style="width: 100%; text-align: left; padding: 12px 20px;">
                        <i class="bi bi-box-arrow-right"></i> Keluar
                    </button>
                </form>
            </li>
        </ul>
    </aside>

    {{-- Main Content --}}
    <div class="admin-content">
        <div class="admin-topbar">
            <h5>@yield('page-title', 'Dashboard')</h5>
            <div class="d-flex align-items-center gap-2">
                <span class="text-muted fw-bold" style="font-size:0.9rem;">
                    <i class="bi bi-person-circle text-teal"></i> {{ auth()->user()->dosen->nama_dosen ?? auth()->user()->name }}
                </span>
            </div>
        </div>

        <div class="admin-main">
            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius:10px; border: none; background: rgba(16,185,129,0.1); color: #047857;">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius:10px; border: none; background: rgba(239,68,68,0.1); color: #b91c1c;">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
