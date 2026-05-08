<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SIBOKO - Sistem Booking Konsultasi Mahasiswa - Panel Admin">
    <title>@yield('title', 'Dashboard') — SIBOKO Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    {{-- Sidebar --}}
    <aside class="admin-sidebar">
        <div class="sidebar-brand">
            <h4><i class="bi bi-calendar2-check"></i> SIBOKO</h4>
            <small>Panel Admin</small>
        </div>
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2-fill"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('dosen.index') }}" class="{Z{ request()->routeIs('dosen.*') ? 'active' : '' }}">
                    <i class="bi bi-person-badge-fill"></i> Data Dosen
                </a>
            </li>
            <li>
                <a href="{{ route('admin.mahasiswa.index') }}" class="{{ request()->routeIs('admin.mahasiswa.*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i> Data Mahasiswa
                </a>
            </li>
            <li>
                <a href="{{ route('booking.laporan') }}" class="{{ request()->routeIs('booking.laporan') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-bar-graph-fill"></i> Laporan Booking
                </a>
            </li>
            <li>
                <a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                    <i class="bi bi-gear-fill"></i> Pengaturan
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
                <span class="text-muted" style="font-size:0.85rem;">
                    <i class="bi bi-person-circle"></i> {{ auth()->user()->name ?? 'Admin' }}
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
