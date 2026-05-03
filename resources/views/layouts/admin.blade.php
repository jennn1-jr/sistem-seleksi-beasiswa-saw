<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — SPK Beasiswa</title>

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* ── Reset & Base ─────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary:       #7c3aed;
            --primary-dark:  #5b21b6;
            --primary-light: #ede9fe;
            --sidebar-w:     260px;
            --topbar-h:      64px;
            --bg:            #f5f6fa;
            --surface:       #ffffff;
            --border:        #e5e7eb;
            --text:          #1f2937;
            --text-muted:    #6b7280;
            --success:       #10b981;
            --warning:       #f59e0b;
            --danger:        #ef4444;
            --info:          #3b82f6;
            --radius:        12px;
            --radius-sm:     8px;
            --shadow:        0 1px 3px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.06);
            --shadow-md:     0 4px 6px rgba(0,0,0,0.07), 0 2px 4px rgba(0,0,0,0.06);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }

        /* ── Sidebar ───────────────────────────────────────── */
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--sidebar-w);
            height: 100vh;
            background: var(--surface);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            z-index: 100;
            transition: transform 0.3s ease;
        }

        /* Brand / Logo */
        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 20px 20px;
            border-bottom: 1px solid var(--border);
            text-decoration: none;
            min-height: var(--topbar-h);
        }
        .sidebar-brand .brand-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 18px;
            flex-shrink: 0;
        }
        .sidebar-brand .brand-text {
            display: flex;
            flex-direction: column;
        }
        .sidebar-brand .brand-name {
            font-size: 14px;
            font-weight: 700;
            color: var(--text);
            line-height: 1.2;
        }
        .sidebar-brand .brand-sub {
            font-size: 10px;
            color: var(--text-muted);
            font-weight: 400;
        }

        /* Nav Menu */
        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 16px 12px;
        }
        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }

        .nav-section-label {
            font-size: 10px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.8px;
            padding: 8px 10px 4px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: var(--radius-sm);
            text-decoration: none;
            color: var(--text-muted);
            font-size: 13.5px;
            font-weight: 500;
            transition: background 0.15s, color 0.15s;
            margin-bottom: 2px;
        }
        .nav-item i {
            width: 18px;
            text-align: center;
            font-size: 14px;
            flex-shrink: 0;
        }
        .nav-item:hover {
            background: var(--primary-light);
            color: var(--primary);
        }
        .nav-item.active {
            background: var(--primary-light);
            color: var(--primary);
            font-weight: 600;
        }
        .nav-item.active i { color: var(--primary); }

        /* Sidebar Footer (logout) */
        .sidebar-footer {
            padding: 12px;
            border-top: 1px solid var(--border);
        }
        .sidebar-footer form { margin: 0; }
        .btn-logout {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 10px 12px;
            border-radius: var(--radius-sm);
            background: none;
            border: none;
            color: var(--danger);
            font-size: 13.5px;
            font-weight: 500;
            cursor: pointer;
            font-family: inherit;
            transition: background 0.15s;
            text-decoration: none;
        }
        .btn-logout:hover { background: #fee2e2; }
        .btn-logout i { width: 18px; text-align: center; font-size: 14px; }

        /* ── Topbar ────────────────────────────────────────── */
        .topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-w);
            right: 0;
            height: var(--topbar-h);
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            z-index: 99;
            box-shadow: var(--shadow);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .topbar-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text);
        }
        .topbar-breadcrumb {
            font-size: 12px;
            color: var(--text-muted);
        }

        /* Hamburger (mobile) */
        .btn-hamburger {
            display: none;
            background: none;
            border: none;
            font-size: 18px;
            color: var(--text-muted);
            cursor: pointer;
            padding: 4px 8px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* User badge di topbar */
        .topbar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 14px 6px 6px;
            background: var(--bg);
            border-radius: 40px;
            border: 1px solid var(--border);
        }
        .topbar-avatar {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            flex-shrink: 0;
        }
        .topbar-user-info {
            display: flex;
            flex-direction: column;
            line-height: 1.3;
        }
        .topbar-user-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--text);
        }
        .topbar-user-role {
            font-size: 11px;
            color: var(--primary);
            font-weight: 500;
        }

        /* ── Main Content ──────────────────────────────────── */
        .main-wrapper {
            margin-left: var(--sidebar-w);
            padding-top: var(--topbar-h);
            min-height: 100vh;
        }
        .main-content {
            padding: 28px 28px;
        }

        /* ── Alert / Flash Messages ────────────────────────── */
        .alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 12px 16px;
            border-radius: var(--radius-sm);
            font-size: 13.5px;
            margin-bottom: 20px;
            border: 1px solid transparent;
        }
        .alert-success { background: #ecfdf5; border-color: #a7f3d0; color: #065f46; }
        .alert-danger  { background: #fef2f2; border-color: #fecaca; color: #991b1b; }
        .alert-warning { background: #fffbeb; border-color: #fde68a; color: #92400e; }
        .alert-info    { background: #eff6ff; border-color: #bfdbfe; color: #1e40af; }
        .alert i { margin-top: 1px; flex-shrink: 0; }
        .alert-close {
            margin-left: auto;
            background: none;
            border: none;
            cursor: pointer;
            color: inherit;
            opacity: 0.6;
            font-size: 14px;
            padding: 0 2px;
        }
        .alert-close:hover { opacity: 1; }

        /* ── Card ──────────────────────────────────────────── */
        .card {
            background: var(--surface);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
        }
        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
        }
        .card-title {
            font-size: 15px;
            font-weight: 600;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .card-title i { color: var(--primary); }
        .card-body { padding: 20px; }

        /* ── Stat Cards ────────────────────────────────────── */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        .stat-card {
            background: var(--surface);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .stat-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }
        .stat-icon.purple { background: var(--primary-light); color: var(--primary); }
        .stat-icon.green  { background: #d1fae5; color: var(--success); }
        .stat-icon.yellow { background: #fef3c7; color: var(--warning); }
        .stat-icon.blue   { background: #dbeafe; color: var(--info); }
        .stat-info { flex: 1; }
        .stat-value {
            font-size: 28px;
            font-weight: 800;
            color: var(--text);
            line-height: 1;
            margin-bottom: 4px;
        }
        .stat-label {
            font-size: 12px;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* ── Table ─────────────────────────────────────────── */
        .table-wrapper { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        thead th {
            padding: 10px 14px;
            text-align: left;
            font-size: 11px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid var(--border);
            background: var(--bg);
        }
        tbody td {
            padding: 12px 14px;
            font-size: 13.5px;
            color: var(--text);
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover { background: #fafafa; }

        /* ── Badge ─────────────────────────────────────────── */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 600;
        }
        .badge-success  { background: #d1fae5; color: #065f46; }
        .badge-warning  { background: #fef3c7; color: #92400e; }
        .badge-danger   { background: #fee2e2; color: #991b1b; }
        .badge-info     { background: #dbeafe; color: #1e40af; }
        .badge-purple   { background: var(--primary-light); color: var(--primary); }

        /* ── Button ────────────────────────────────────────── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 500;
            font-family: inherit;
            cursor: pointer;
            border: 1px solid transparent;
            text-decoration: none;
            transition: all 0.15s;
            white-space: nowrap;
        }
        .btn-primary  { background: var(--primary); color: #fff; border-color: var(--primary); }
        .btn-primary:hover { background: var(--primary-dark); border-color: var(--primary-dark); }
        .btn-secondary { background: var(--bg); color: var(--text); border-color: var(--border); }
        .btn-secondary:hover { background: var(--border); }
        .btn-success  { background: var(--success); color: #fff; border-color: var(--success); }
        .btn-success:hover { background: #059669; }
        .btn-danger   { background: var(--danger); color: #fff; border-color: var(--danger); }
        .btn-danger:hover { background: #dc2626; }
        .btn-sm { padding: 5px 10px; font-size: 12px; }
        .btn-icon { padding: 7px 10px; }
        .btn:disabled { opacity: 0.6; cursor: not-allowed; }

        /* ── Page Header ───────────────────────────────────── */
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 12px;
        }
        .page-header-left h1 {
            font-size: 22px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 4px;
        }
        .page-header-left p {
            font-size: 13px;
            color: var(--text-muted);
        }

        /* ── Sidebar Overlay (mobile) ──────────────────────── */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            z-index: 99;
        }

        /* ── Responsive ────────────────────────────────────── */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .sidebar-overlay { display: none; }
            .sidebar-overlay.show { display: block; }
            .topbar { left: 0; }
            .main-wrapper { margin-left: 0; }
            .btn-hamburger { display: block; }
            .topbar-user-info { display: none; }
            .main-content { padding: 20px 16px; }
        }
    </style>

    @stack('styles')
</head>
<body>

{{-- ── Sidebar ─────────────────────────────────────────── --}}
<aside class="sidebar" id="sidebar">

    {{-- Brand --}}
    <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
        <div class="brand-icon"><i class="fas fa-graduation-cap"></i></div>
        <div class="brand-text">
            <span class="brand-name">SPK Beasiswa</span>
            <span class="brand-sub">Panel Administrator</span>
        </div>
    </a>

    {{-- Navigation --}}
    <nav class="sidebar-nav">

        {{-- Utama --}}
        <div class="nav-section-label">Utama</div>
        <a href="{{ route('admin.dashboard') }}"
           class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-pie"></i>
            Dashboard
        </a>

        {{-- Manajemen Data --}}
        <div class="nav-section-label" style="margin-top:12px">Manajemen Data</div>
        <a href="{{ route('admin.pendaftar.index') }}"
           class="nav-item {{ request()->routeIs('admin.pendaftar.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i>
            Data Pendaftar
        </a>
        <a href="{{ route('admin.kriteria.index') }}"
           class="nav-item {{ request()->routeIs('admin.kriteria.*') ? 'active' : '' }}">
            <i class="fas fa-list-check"></i>
            Kelola Kriteria
        </a>
        <a href="{{ route('admin.sub-kriteria.index') }}"
           class="nav-item {{ request()->routeIs('admin.sub-kriteria.*') ? 'active' : '' }}">
            <i class="fas fa-sliders"></i>
            Kelola Sub Kriteria
        </a>

        {{-- Perhitungan SAW --}}
        <div class="nav-section-label" style="margin-top:12px">Perhitungan SAW</div>
        <a href="{{ route('admin.saw.index') }}"
           class="nav-item {{ request()->routeIs('admin.saw.*') ? 'active' : '' }}">
            <i class="fas fa-calculator"></i>
            Eksekusi SAW
        </a>
        <a href="{{ route('admin.laporan.index') }}"
           class="nav-item {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
            <i class="fas fa-file-chart-column"></i>
            Laporan Hasil
        </a>

        {{-- Sistem --}}
        <div class="nav-section-label" style="margin-top:12px">Sistem</div>
        <a href="{{ route('admin.manajemen-admin.index') }}"
           class="nav-item {{ request()->routeIs('admin.manajemen-admin.*') ? 'active' : '' }}">
            <i class="fas fa-user-shield"></i>
            Manajemen Admin
        </a>
        <a href="{{ route('admin.pengaturan.index') }}"
           class="nav-item {{ request()->routeIs('admin.pengaturan.*') ? 'active' : '' }}">
            <i class="fas fa-gear"></i>
            Pengaturan Sistem
        </a>

    </nav>

    {{-- Logout --}}
    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="fas fa-right-from-bracket"></i>
                Keluar
            </button>
        </form>
    </div>

</aside>

{{-- Overlay mobile --}}
<div class="sidebar-overlay" id="sidebarOverlay"></div>

{{-- ── Topbar ───────────────────────────────────────────── --}}
<header class="topbar">
    <div class="topbar-left">
        <button class="btn-hamburger" id="btnHamburger">
            <i class="fas fa-bars"></i>
        </button>
        <div>
            <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
            <div class="topbar-breadcrumb">@yield('breadcrumb', 'Selamat datang di panel admin')</div>
        </div>
    </div>
    <div class="topbar-right">
        <div class="topbar-user">
            <div class="topbar-avatar">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="topbar-user-info">
                <span class="topbar-user-name">{{ Auth::user()->name }}</span>
                <span class="topbar-user-role">Administrator</span>
            </div>
        </div>
    </div>
</header>

{{-- ── Main Content ─────────────────────────────────────── --}}
<div class="main-wrapper">
    <main class="main-content">

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="alert alert-success" id="flashMsg">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
                <button class="alert-close" onclick="this.parentElement.remove()"><i class="fas fa-xmark"></i></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger" id="flashMsg">
                <i class="fas fa-circle-xmark"></i>
                <span>{{ session('error') }}</span>
                <button class="alert-close" onclick="this.parentElement.remove()"><i class="fas fa-xmark"></i></button>
            </div>
        @endif
        @if (session('warning'))
            <div class="alert alert-warning">
                <i class="fas fa-triangle-exclamation"></i>
                <span>{{ session('warning') }}</span>
                <button class="alert-close" onclick="this.parentElement.remove()"><i class="fas fa-xmark"></i></button>
            </div>
        @endif
        @if (session('info'))
            <div class="alert alert-info">
                <i class="fas fa-circle-info"></i>
                <span>{{ session('info') }}</span>
                <button class="alert-close" onclick="this.parentElement.remove()"><i class="fas fa-xmark"></i></button>
            </div>
        @endif

        @yield('content')

    </main>
</div>

<script>
    // ── Hamburger toggle (mobile) ───────────────────────
    const sidebar  = document.getElementById('sidebar');
    const overlay  = document.getElementById('sidebarOverlay');
    const hamburger = document.getElementById('btnHamburger');

    hamburger?.addEventListener('click', () => {
        sidebar.classList.toggle('open');
        overlay.classList.toggle('show');
    });
    overlay?.addEventListener('click', () => {
        sidebar.classList.remove('open');
        overlay.classList.remove('show');
    });

    // ── Auto-dismiss flash messages (5 detik) ──────────
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(el => {
            el.style.transition = 'opacity 0.4s';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 400);
        });
    }, 5000);
</script>

@stack('scripts')
</body>
</html>
