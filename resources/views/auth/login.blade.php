<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kalku Beasiswa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* ── CSS Variables ─────────────────────────────── */
        :root {
            --primary: #7c3aed;
            --primary-dark: #5b21b6;
            --radius-sm: 8px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            overflow: hidden;
        }

        /* ── Halaman Login ─────────────────────────────── */
        #loginPage {
            position: fixed;
            inset: 0;
            background: linear-gradient(135deg, #7c3aed 0%, #5b21b6 50%, #6d28d9 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* background shapes animasi */
        .login-bg-shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
            background: #fff;
            animation: floatShape 6s ease-in-out infinite;
        }
        .login-bg-shape:nth-child(1) { width:300px;height:300px;top:-50px;left:-50px;animation-delay:0s; }
        .login-bg-shape:nth-child(2) { width:200px;height:200px;top:60%;right:-30px;animation-delay:2s;animation-duration:8s; }
        .login-bg-shape:nth-child(3) { width:150px;height:150px;bottom:-30px;left:40%;animation-delay:4s;animation-duration:7s; }
        .login-bg-shape:nth-child(4) { width:100px;height:100px;top:20%;right:20%;animation-delay:1s;animation-duration:5s; }

        /* card login */
        .login-card {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.25);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            text-align: center;
            animation: fadeInUp 0.6s ease;
            position: relative;
            z-index: 1;
        }

        .login-card .logo-login {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            margin-bottom: 16px;
            object-fit: contain;
            border: 2px solid rgba(255,255,255,0.3);
            background: rgba(255,255,255,0.1);
        }

        .login-card h1 {
            color: #fff;
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .login-card .subtitle {
            color: rgba(255,255,255,0.7);
            font-size: 13px;
            margin-bottom: 28px;
        }

        /* field */
        .login-field {
            margin-bottom: 16px;
            text-align: left;
            position: relative;
        }
        .login-field label {
            display: block;
            color: rgba(255,255,255,0.9);
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 6px;
        }
        .login-field input {
            width: 100%;
            padding: 12px 14px 12px 40px;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: var(--radius-sm);
            color: #fff;
            font-size: 14px;
            font-family: inherit;
            outline: none;
            transition: border-color 0.2s, background 0.2s;
        }
        .login-field input::placeholder { color: rgba(255,255,255,0.5); }
        .login-field input:focus {
            border-color: #fff;
            background: rgba(255,255,255,0.25);
        }
        .login-field .field-icon {
            position: absolute;
            left: 14px;
            top: 38px;
            color: rgba(255,255,255,0.6);
            font-size: 14px;
        }

        /* error */
        .login-error {
            background: rgba(239,68,68,0.2);
            border: 1px solid rgba(239,68,68,0.4);
            color: #fca5a5;
            padding: 10px 14px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            text-align: left;
        }

        /* success/info flash */
        .login-flash {
            padding: 10px 14px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            text-align: left;
        }
        .login-flash.success {
            background: rgba(16,185,129,0.2);
            border: 1px solid rgba(16,185,129,0.4);
            color: #6ee7b7;
        }
        .login-flash.info {
            background: rgba(59,130,246,0.2);
            border: 1px solid rgba(59,130,246,0.4);
            color: #93c5fd;
        }

        /* remember + tombol */
        .login-options {
            display: flex;
            align-items: center;
            margin-bottom: 16px;
            text-align: left;
        }
        .login-options label {
            display: flex;
            align-items: center;
            gap: 6px;
            color: rgba(255,255,255,0.8);
            font-size: 13px;
            cursor: pointer;
        }

        .btn-login {
            width: 100%;
            padding: 13px;
            background: #fff;
            color: var(--primary);
            border: none;
            border-radius: var(--radius-sm);
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.15s, box-shadow 0.15s;
            font-family: inherit;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-login:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,0.2); }
        .btn-login:active { transform: translateY(0); }
        .btn-login:disabled { opacity: 0.7; cursor: not-allowed; transform: none; }

        /* demo box */
        .demo-box {
            margin-top: 20px;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: var(--radius-sm);
            padding: 14px;
            text-align: left;
        }
        .demo-box h4 {
            color: rgba(255,255,255,0.9);
            font-size: 12px;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .demo-box p {
            color: rgba(255,255,255,0.7);
            font-size: 12px;
            line-height: 1.8;
        }

        /* theme toggle */
        .login-theme-toggle {
            position: absolute;
            top: 16px;
            right: 16px;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.25);
            color: #fff;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }
        .login-theme-toggle:hover { background: rgba(255,255,255,0.25); }

        /* ── Animasi ────────────────────────────────────── */
        @keyframes fadeInUp {
            from { opacity:0; transform:translateY(20px); }
            to   { opacity:1; transform:translateY(0); }
        }
        @keyframes floatShape {
            0%,100% { transform: translateY(0) rotate(0deg); }
            50%      { transform: translateY(-20px) rotate(5deg); }
        }

        /* ── Dark mode (opsional) ───────────────────────── */
        [data-theme="dark"] #loginPage {
            background: linear-gradient(135deg, #4c1d95 0%, #2e1065 50%, #3b0764 100%);
        }
    </style>
</head>
<body>
<div id="loginPage">
    <!-- Background shapes dekoratif -->
    <div class="login-bg-shape"></div>
    <div class="login-bg-shape"></div>
    <div class="login-bg-shape"></div>
    <div class="login-bg-shape"></div>

    <div class="login-card">
        <!-- Logo -->
        <img src="{{ asset('images/logo.png') }}"
             onerror="this.src='https://placehold.co/80x80/7c3aed/ffffff?text=KB'"
             alt="Logo Kalku Beasiswa"
             class="logo-login">

        <h1>Kalku Beasiswa</h1>
        <p class="subtitle">Sistem Pendukung Keputusan Penerima Beasiswa</p>

        <!-- Flash messages ─────────────────────────────── -->
        @if (session('success'))
            <div class="login-flash success">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('info'))
            <div class="login-flash info">
                <i class="fas fa-info-circle"></i>
                <span>{{ session('info') }}</span>
            </div>
        @endif

        <!-- Error validasi ─────────────────────────────── -->
        @if ($errors->any())
            <div class="login-error">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <!-- Form Login ─────────────────────────────────── -->
        <form method="POST" action="{{ route('login.post') }}" id="loginForm">
            @csrf

            <div class="login-field">
                <i class="fas fa-user field-icon"></i>
                <label for="username">Username</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    value="{{ old('username') }}"
                    placeholder="Masukkan username"
                    autocomplete="username"
                    required
                    autofocus
                >
            </div>

            <div class="login-field">
                <i class="fas fa-lock field-icon"></i>
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Masukkan password"
                    autocomplete="current-password"
                    required
                >
            </div>

            <!-- Remember me -->
            <div class="login-options">
                <label>
                    <input type="checkbox" name="remember" id="remember"
                        {{ old('remember') ? 'checked' : '' }}>
                    Ingat saya
                </label>
            </div>

            <button type="submit" class="btn-login" id="btnLogin">
                <i class="fas fa-sign-in-alt"></i>
                Masuk
            </button>
        </form>

        <!-- Demo credentials ───────────────────────────── -->
        <div class="demo-box">
            <h4><i class="fas fa-info-circle"></i> Akun Demo</h4>
            <p>
                <strong>Admin:</strong> admin / admin123<br>
                <strong>Mahasiswa:</strong> 12345 / student123
            </p>
        </div>
    </div><!-- /.login-card -->
</div><!-- /#loginPage -->

<script>
    // Loading state saat submit
    document.getElementById('loginForm').addEventListener('submit', function () {
        var btn = document.getElementById('btnLogin');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
    });
</script>
</body>
</html>