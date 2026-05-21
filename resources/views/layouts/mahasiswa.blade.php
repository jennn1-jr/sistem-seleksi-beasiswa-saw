<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SPK Beasiswa — Portal Mahasiswa">
    <title>@yield('title', 'Portal Mahasiswa') | SPK Beasiswa</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @stack('styles')
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            corePlugins: {
                preflight: false,
            }
        }
    </script>

    <style>
        /* ─────────────────────────────────────────────────────
           RESET & BASE
        ───────────────────────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        /* Dark Mode (default) */
        :root {
            --bg:          #0f1117;
            --surface:     #16181f;
            --border:      #1f2430;
            --text:        #e5e7eb;
            --text-muted:  #94a3b8;
            --text-sub:    #64748b;
            --text-head:   #f1f5f9;
            --table-head:  #1a1d27;
            --table-hover: #1a1d27;
            --row-border:  #1a1d27;
            --nim-bg:      #1e2130;
            --nav-hover:   #1e2130;
            --primary:     #7c3aed;
            --primary-g1:  #6d28d9;
            --primary-g2:  #4c1d95;
            --accent:      #a78bfa;
        }

        /* Light Mode */
        [data-theme="light"] {
            --bg:          #f5f6fa;
            --surface:     #ffffff;
            --border:      #e2e8f0;
            --text:        #1e293b;
            --text-muted:  #475569;
            --text-sub:    #64748b;
            --text-head:   #0f172a;
            --table-head:  #f8fafc;
            --table-hover: #f1f5f9;
            --row-border:  #e2e8f0;
            --nim-bg:      #f1f5f9;
            --nav-hover:   #f1f5f9;
            --primary:     #7c3aed;
            --primary-g1:  #7c3aed;
            --primary-g2:  #5b21b6;
            --accent:      #7c3aed;
        }
        /* Nav light */
        [data-theme="light"] .nav-item            { color: #475569; border-left-color: transparent; }
        [data-theme="light"] .nav-item:hover      { color: #0f172a; background: #f1f5f9; }
        [data-theme="light"] .nav-item.active     { color: #7c3aed; background: #ede9fe; border-left-color: #7c3aed; }
        /* Brand & user */
        [data-theme="light"] .brand-title         { color: #0f172a; }
        [data-theme="light"] .brand-sub           { color: #64748b; }
        [data-theme="light"] .user-name           { color: #0f172a; }
        [data-theme="light"] .user-nim            { color: #64748b; }
        [data-theme="light"] .nav-label           { color: #94a3b8; }
        /* Topbar */
        [data-theme="light"] .topbar-left h2      { color: #0f172a; }
        [data-theme="light"] .topbar-left p       { color: #64748b; }
        [data-theme="light"] .topbar-nim          { color: #475569; background: #f1f5f9; border-color: #e2e8f0; }
        /* Cards & content */
        [data-theme="light"] .card-title          { color: #0f172a; }
        [data-theme="light"] .page-header-left h1 { color: #0f172a; }
        [data-theme="light"] .page-header-left p  { color: #64748b; }
        /* Stat */
        [data-theme="light"] .stat-value          { color: #0f172a; }
        [data-theme="light"] .stat-label          { color: #64748b; }
        [data-theme="light"] .stat-icon.purple    { background: #ede9fe; color: #7c3aed; }
        [data-theme="light"] .stat-icon.green     { background: #d1fae5; color: #059669; }
        [data-theme="light"] .stat-icon.yellow    { background: #fef3c7; color: #d97706; }
        [data-theme="light"] .stat-icon.blue      { background: #dbeafe; color: #2563eb; }
        /* Table */
        [data-theme="light"] thead th             { color: #475569; }
        [data-theme="light"] tbody td             { color: #1e293b; }
        /* Badge */
        [data-theme="light"] .badge-success       { background: #dcfce7; color: #166534; }
        [data-theme="light"] .badge-warning       { background: #fef9c3; color: #854d0e; }
        [data-theme="light"] .badge-danger        { background: #fee2e2; color: #991b1b; }
        [data-theme="light"] .badge-purple        { background: #ede9fe; color: #6d28d9; }
        /* Logout */
        [data-theme="light"] .logout-btn          { color: #ef4444; }
        [data-theme="light"] .logout-btn:hover    { background: #fee2e2; }
        /* Flash */
        [data-theme="light"] .flash-success       { background: #ecfdf5; color: #065f46; border-color: #a7f3d0; }
        [data-theme="light"] .flash-error         { background: #fef2f2; color: #991b1b; border-color: #fecaca; }
        /* Alert */
        [data-theme="light"] .alert-info          { background: #eff6ff; color: #1d4ed8; border-color: #bfdbfe; }
        [data-theme="light"] .alert-success       { background: #ecfdf5; color: #065f46; border-color: #a7f3d0; }
        [data-theme="light"] .alert-warning       { background: #fffbeb; color: #92400e; border-color: #fde68a; }
        [data-theme="light"] .alert-danger        { background: #fef2f2; color: #991b1b; border-color: #fecaca; }
        /* Form inputs light mode (teks jelas terbaca) */
        [data-theme="light"] input:not([type="checkbox"]):not([type="radio"]):not([type="range"]):not([type="submit"]):not([type="button"]),
        [data-theme="light"] select,
        [data-theme="light"] textarea {
            background-color: #ffffff !important;
            color: #1e293b !important;
            border-color: #cbd5e1 !important;
        }
        [data-theme="light"] input::placeholder,
        [data-theme="light"] textarea::placeholder { color: #94a3b8 !important; }
        [data-theme="light"] label   { color: #374151; }
        [data-theme="light"] small   { color: #64748b; }
        [data-theme="light"] .logout-btn i { color: #ef4444; }

        /* Theme Toggle Button */
        .btn-theme-toggle {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 34px; height: 34px;
            border-radius: 50%;
            background: var(--surface);
            border: 1px solid var(--border);
            color: var(--text-muted);
            cursor: pointer;
            font-size: 15px;
            transition: background 0.2s, color 0.2s, transform 0.3s;
            flex-shrink: 0;
        }
        .btn-theme-toggle:hover {
            background: var(--primary);
            color: #fff;
            transform: rotate(15deg);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            transition: background 0.25s, color 0.25s;
        }

        /* ─────────────────────────────────────────────────────
           SIDEBAR
        ───────────────────────────────────────────────────── */
        .sidebar {
            width: 240px;
            min-height: 100vh;
            background: var(--surface);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 100;
            transition: transform 0.3s, background 0.25s;
        }

        /* Logo / Brand */
        .sidebar-brand {
            padding: 22px 20px 16px;
            border-bottom: 1px solid var(--border);
        }
        .brand-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .brand-icon {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, #6d28d9, #4c1d95);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
            box-shadow: 0 4px 12px rgba(109,40,217,0.4);
        }
        .brand-text { line-height: 1.2; }
        .brand-title { font-size: 14px; font-weight: 700; color: var(--text-head); }
        .brand-sub   { font-size: 10px; color: var(--text-sub); font-weight: 400; }

        /* User Info */
        .sidebar-user {
            padding: 14px 18px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .user-avatar {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #6d28d9, #4c1d95);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 700;
            color: #fff; flex-shrink: 0;
        }
        .user-name { font-size: 13px; font-weight: 600; color: var(--text-head); }
        .user-nim  { font-size: 11px; color: var(--text-sub); }

        /* Nav */
        .sidebar-nav { padding: 12px 0; flex: 1; }
        .nav-label {
            font-size: 10px; font-weight: 600; color: var(--text-sub);
            text-transform: uppercase; letter-spacing: 0.8px;
            padding: 10px 20px 4px;
        }
        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            border-left: 3px solid transparent;
            transition: all 0.15s;
        }
        .nav-item:hover { color: var(--text); background: var(--nav-hover); }
        .nav-item.active {
            color: var(--accent);
            background: rgba(109,40,217,0.12);
            border-left-color: var(--primary);
        }
        .nav-item i { width: 16px; text-align: center; font-size: 13px; }

        /* Logout */
        .sidebar-footer {
            padding: 12px 0;
            border-top: 1px solid var(--border);
        }
        .logout-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            color: #ef4444;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            width: 100%;
            background: none;
            border: none;
            cursor: pointer;
            transition: background 0.15s;
        }
        .logout-btn:hover { background: rgba(239,68,68,0.08); }
        .logout-btn i { width: 16px; text-align: center; }

        /* ─────────────────────────────────────────────────────
           MAIN CONTENT
        ───────────────────────────────────────────────────── */
        .main-wrapper {
            margin-left: 0;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        @media (min-width: 768px) {
            .main-wrapper { margin-left: 240px; }
        }
        }

        /* Topbar */
        .topbar {
            height: 60px;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            position: sticky;
            top: 0;
            z-index: 50;
            transition: background 0.25s;
        }
        .topbar-left h2  { font-size: 16px; font-weight: 700; color: var(--text-head); }
        .topbar-left p   { font-size: 12px; color: var(--text-sub); margin-top: 1px; }
        .topbar-right    { display: flex; align-items: center; gap: 10px; }
        .topbar-nim {
            font-size: 12px; color: var(--text-sub);
            background: var(--nim-bg);
            padding: 5px 12px;
            border-radius: 20px;
            border: 1px solid var(--border);
        }

        /* Content area */
        .content-area { padding: 24px; flex: 1; }

        /* Page header */
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 12px;
        }
        .page-header-left h1 { font-size: 22px; font-weight: 800; color: #f1f5f9; }
        .page-header-left p  { font-size: 13px; color: #64748b; margin-top: 4px; }

        /* ─────────────────────────────────────────────────────
           CARDS
        ───────────────────────────────────────────────────── */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            transition: background 0.25s;
        }
        .card-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .card-title {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text-head);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .card-body { padding: 20px; }

        /* ─────────────────────────────────────────────────────
           STAT CARDS (mahasiswa)
        ───────────────────────────────────────────────────── */
        .stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; }
        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 18px;
            display: flex;
            align-items: center;
            gap: 14px;
            transition: background 0.25s;
        }
        .stat-icon {
            width: 44px; height: 44px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; flex-shrink: 0;
        }
        .stat-icon.purple { background: rgba(109,40,217,0.2); color: #a78bfa; }
        .stat-icon.green  { background: rgba(16,185,129,0.15); color: #34d399; }
        .stat-icon.yellow { background: rgba(245,158,11,0.15); color: #fbbf24; }
        .stat-icon.blue   { background: rgba(59,130,246,0.15); color: #60a5fa; }
        .stat-value { font-size: 24px; font-weight: 800; color: var(--text-head); }
        .stat-label { font-size: 12px; color: var(--text-sub); margin-top: 2px; }

        /* ─────────────────────────────────────────────────────
           BADGES
        ───────────────────────────────────────────────────── */
        .badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 3px 10px; border-radius: 20px;
            font-size: 11.5px; font-weight: 600;
        }
        .badge-success { background: rgba(16,185,129,0.15); color: #34d399; }
        .badge-warning { background: rgba(245,158,11,0.15);  color: #fbbf24; }
        .badge-danger  { background: rgba(239,68,68,0.15);   color: #f87171; }
        .badge-purple  { background: rgba(139,92,246,0.15);  color: #a78bfa; }

        /* ─────────────────────────────────────────────────────
           TABLE
        ───────────────────────────────────────────────────── */
        .table-wrapper { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        thead th {
            padding: 10px 14px;
            text-align: left;
            font-size: 11px;
            font-weight: 600;
            color: var(--text-sub);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background: var(--table-head);
            border-bottom: 1px solid var(--border);
        }
        tbody td {
            padding: 12px 14px;
            border-bottom: 1px solid var(--row-border);
            color: var(--text-muted);
            vertical-align: middle;
        }
        tbody tr:hover { background: var(--table-hover); }
        tbody tr:last-child td { border-bottom: none; }

        /* ─────────────────────────────────────────────────────
           ALERTS
        ───────────────────────────────────────────────────── */
        .alert {
            display: flex; align-items: flex-start; gap: 10px;
            padding: 12px 16px; border-radius: 10px;
            font-size: 13px; line-height: 1.5;
            border: 1px solid;
        }
        .alert i { margin-top: 1px; flex-shrink: 0; }
        .alert-info    { background: rgba(59,130,246,0.1);   color: #93c5fd; border-color: rgba(59,130,246,0.2); }
        .alert-success { background: rgba(16,185,129,0.1);   color: #6ee7b7; border-color: rgba(16,185,129,0.2); }
        .alert-warning { background: rgba(245,158,11,0.1);   color: #fcd34d; border-color: rgba(245,158,11,0.2); }
        .alert-danger  { background: rgba(239,68,68,0.1);    color: #fca5a5; border-color: rgba(239,68,68,0.2); }

        /* ─────────────────────────────────────────────────────
           FLASH MESSAGES
        ───────────────────────────────────────────────────── */
        .flash-container {
            position: fixed; top: 72px; right: 20px;
            z-index: 999; display: flex; flex-direction: column; gap: 8px;
        }
        .flash {
            display: flex; align-items: center; gap: 10px;
            padding: 12px 16px; border-radius: 10px;
            font-size: 13px; font-weight: 500;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            animation: slideIn 0.3s ease;
            border: 1px solid;
            min-width: 280px;
        }
        .flash-success { background: #064e3b; color: #6ee7b7; border-color: #065f46; }
        .flash-error   { background: #7f1d1d; color: #fca5a5; border-color: #991b1b; }
        @keyframes slideIn { from { opacity:0; transform: translateX(20px); } to { opacity:1; transform: translateX(0); } }
    </style>
</head>
<body>

{{-- ── Sidebar ─────────────────────────────────────────── --}}
<aside class="sidebar -translate-x-full md:translate-x-0" id="sidebar">

    {{-- Brand --}}
    <div class="sidebar-brand">
        <a href="{{ route('mahasiswa.dashboard') }}" class="brand-logo">
            <img src="{{ asset('images/logo.png') }}"
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'"
                 alt="Logo" class="brand-icon" style="object-fit:contain; padding:4px; background:linear-gradient(135deg,#6d28d9,#4c1d95);">
            <div class="brand-icon" style="display:none;">🎓</div>
            <div class="brand-text">
                <div class="brand-title">SPK Beasiswa</div>
                <div class="brand-sub">Portal Mahasiswa</div>
            </div>
        </a>
    </div>

    {{-- User Info --}}
    <div class="sidebar-user">
        <div class="user-avatar">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
        <div>
            <div class="user-name">{{ Auth::user()->name }}</div>
            <div class="user-nim">{{ Auth::user()->username }}</div>
        </div>
    </div>

    {{-- Nav --}}
    <nav class="sidebar-nav">
        <div class="nav-label">Menu</div>

        <a href="{{ route('mahasiswa.dashboard') }}"
           class="nav-item {{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}">
            <i class="fas fa-house"></i> Dashboard
        </a>

        <a href="{{ route('mahasiswa.pengumuman') }}"
           class="nav-item {{ request()->routeIs('mahasiswa.pengumuman') ? 'active' : '' }}">
            <i class="fas fa-bullhorn"></i> Pengumuman
        </a>
    </nav>

    {{-- Logout --}}
    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-right-from-bracket"></i> Keluar
            </button>
        </form>
    </div>
</aside>

{{-- Sidebar Backdrop (Mobile) --}}
<div id="sidebarBackdrop" class="fixed inset-0 bg-black/50 z-[90] hidden md:hidden"></div>

{{-- ── Main Wrapper ────────────────────────────────────── --}}
<div class="main-wrapper">

    {{-- Topbar --}}
    <div class="topbar flex items-center justify-between">
        <div class="topbar-left flex items-center gap-3">
            <button class="md:hidden bg-transparent border-none p-2 cursor-pointer outline-none flex items-center justify-center" id="btnHamburger">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-gray-800 dark:text-gray-200 hover:text-purple-600 dark:hover:text-purple-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <div>
                <h2>@yield('page-title', 'Dashboard')</h2>
                <p>@yield('breadcrumb', '')</p>
            </div>
        </div>
        <div class="topbar-right">
            <button class="btn-theme-toggle" id="btnThemeToggle" title="Ganti Tema" aria-label="Toggle dark mode">
                <i class="fas fa-sun" id="themeIcon"></i>
            </button>
            <span class="topbar-nim">
                <i class="fas fa-id-card" style="color:#7c3aed;"></i>
                {{ Auth::user()->username }}
            </span>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success') || session('error'))
    <div class="flash-container" id="flashContainer">
        @if(session('success'))
            <div class="flash flash-success">
                <i class="fas fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="flash flash-error">
                <i class="fas fa-circle-xmark"></i> {{ session('error') }}
            </div>
        @endif
    </div>
    <script>
        setTimeout(() => {
            const el = document.getElementById('flashContainer');
            if (el) el.style.display = 'none';
        }, 4000);
    </script>
    @endif

    {{-- Content --}}
    <main class="content-area">
        @yield('content')
    </main>
</div>

<script>
    // Apply saved theme immediately (no flash)
    (function() {
        const saved = localStorage.getItem('kalku_theme') || 'dark';
        document.documentElement.setAttribute('data-theme', saved);
    })();
</script>

<script>
    const btnToggle = document.getElementById('btnThemeToggle');
    const themeIcon = document.getElementById('themeIcon');
    const html      = document.documentElement;

    function applyThemeMhs(theme) {
        html.setAttribute('data-theme', theme);
        localStorage.setItem('kalku_theme', theme);
        if (theme === 'dark') {
            themeIcon.className = 'fas fa-sun';
            btnToggle.title = 'Ganti ke Mode Terang';
        } else {
            themeIcon.className = 'fas fa-moon';
            btnToggle.title = 'Ganti ke Mode Gelap';
        }
    }

    // Sync icon on load
    applyThemeMhs(localStorage.getItem('kalku_theme') || 'dark');

    btnToggle?.addEventListener('click', () => {
        const current = html.getAttribute('data-theme');
        applyThemeMhs(current === 'dark' ? 'light' : 'dark');
    });

    const sidebar = document.getElementById('sidebar');
    const btnHamburger = document.getElementById('btnHamburger');
    const sidebarBackdrop = document.getElementById('sidebarBackdrop');

    function toggleSidebar() {
        sidebar.classList.toggle('-translate-x-full');
        if (sidebarBackdrop) {
            sidebarBackdrop.classList.toggle('hidden');
        }
    }

    btnHamburger?.addEventListener('click', toggleSidebar);
    sidebarBackdrop?.addEventListener('click', toggleSidebar);
</script>

@stack('scripts')
</body>
</html>
