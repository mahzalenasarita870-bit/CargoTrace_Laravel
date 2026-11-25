<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — CargoTrace Maritime Visibility</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --navy-deep: #132A46;
            --navy-primary: #1E3A5F;
            --ocean-blue: #2B6CB0;
            --cerulean: #4A90E2;
            --aqua-soft: #7FB3D5;
            --ice-bg-1: #D4E4F2;
            --ice-bg-2: #E8F2FA;
            --ice-bg-3: #F5F9FC;
            --glass-bg: rgba(255, 255, 255, 0.92);
            --glass-border: rgba(255, 255, 255, 0.96);
            --text-dark: #102A43;
            --text-muted: #526D82;
            --coral-err: #C53030;
            --coral-bg: #FEE2E2;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        html, body {
            width: 100%;
            min-height: 100vh;
        }

        body {
            background:
                radial-gradient(circle at 12% 10%, rgba(74, 144, 226, 0.32), transparent 40%),
                radial-gradient(circle at 88% 18%, rgba(127, 179, 213, 0.45), transparent 44%),
                radial-gradient(circle at 50% 92%, rgba(30, 58, 95, 0.20), transparent 52%),
                linear-gradient(155deg, var(--ice-bg-1) 0%, var(--ice-bg-2) 50%, var(--ice-bg-3) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 28px 20px;
            color: var(--text-dark);
        }

        .ct-login-wrapper {
            width: 100%;
            max-width: 960px;
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 26px;
            box-shadow: 0 24px 60px rgba(19, 42, 70, 0.16);
            display: flex;
            flex-direction: row;
            overflow: hidden;
        }

        /* ================= LEFT MARITIME HERO PANEL ================= */
        .ct-left-panel {
            width: 50%;
            flex: 0 0 50%;
            background: linear-gradient(145deg, #0F233D 0%, #193B64 52%, #2B6CB0 100%);
            color: #ffffff;
            padding: 46px 42px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .ct-left-panel::before {
            content: '';
            position: absolute;
            top: -70px;
            right: -70px;
            width: 240px;
            height: 240px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(127, 179, 213, 0.25) 0%, transparent 70%);
            pointer-events: none;
        }

        .ct-left-panel::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: -50px;
            width: 280px;
            height: 280px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(74, 144, 226, 0.22) 0%, transparent 70%);
            pointer-events: none;
        }

        .logo-row {
            display: flex;
            align-items: center;
            gap: 13px;
            position: relative;
            z-index: 2;
        }

        .logo-icon {
            width: 44px;
            height: 44px;
            border-radius: 13px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #BAE6FD;
            flex-shrink: 0;
        }

        .logo-title {
            font-size: 21px;
            font-weight: 800;
            letter-spacing: -0.4px;
            color: #ffffff;
        }

        .logo-sub {
            font-size: 11.5px;
            color: #93C5FD;
            font-weight: 600;
        }

        .hero-copy {
            position: relative;
            z-index: 2;
            margin: 32px 0;
        }

        .hero-pill {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.20);
            padding: 5px 12px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.6px;
            text-transform: uppercase;
            color: #BAE6FD;
            margin-bottom: 16px;
        }

        .pulse-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #34D399;
            box-shadow: 0 0 0 3px rgba(52, 211, 153, 0.25);
        }

        .ct-left-panel h1 {
            font-size: 32px;
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: -0.6px;
            margin-bottom: 14px;
            color: #ffffff;
        }

        .ct-left-panel p {
            font-size: 14px;
            line-height: 1.65;
            color: #CBD5E1;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            position: relative;
            z-index: 2;
        }

        .feat-item {
            background: rgba(255, 255, 255, 0.09);
            border: 1px solid rgba(255, 255, 255, 0.14);
            border-radius: 13px;
            padding: 12px 14px;
        }

        .feat-title {
            font-size: 12.5px;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 3px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .feat-desc {
            font-size: 11px;
            color: #BAE6FD;
            line-height: 1.4;
        }

        /* ================= RIGHT REGISTER FORM PANEL ================= */
        .ct-right-panel {
            width: 50%;
            flex: 0 0 50%;
            padding: 40px 44px;
            background: #ffffff;
            color: var(--text-dark);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .ct-right-panel h2 {
            font-size: 26px;
            font-weight: 800;
            color: var(--navy-deep);
            letter-spacing: -0.5px;
            margin-bottom: 4px;
        }

        .subtitle {
            font-size: 13.5px;
            color: var(--text-muted);
            margin-bottom: 20px;
        }

        .error {
            background: var(--coral-bg);
            color: var(--coral-err);
            border: 1px solid rgba(197, 48, 48, 0.22);
            padding: 11px 14px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 16px;
        }

        .error ul {
            margin-left: 18px;
        }

        .form-group {
            margin-bottom: 14px;
        }

        label {
            display: block;
            font-size: 12.5px;
            font-weight: 700;
            color: var(--navy-primary);
            margin-bottom: 6px;
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 17px;
            height: 17px;
            stroke: #7B93A8;
            stroke-width: 2;
            fill: none;
            pointer-events: none;
        }

        .ct-input {
            width: 100%;
            padding: 11px 42px;
            border-radius: 12px;
            border: 1.5px solid rgba(30, 58, 95, 0.14);
            background: #F4F8FC;
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text-dark);
            outline: none;
            transition: all 0.2s ease;
        }

        .ct-input:focus {
            background: #ffffff;
            border-color: var(--ocean-blue);
            box-shadow: 0 0 0 4px rgba(43, 108, 176, 0.12);
        }

        .btn-toggle-pw {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-toggle-pw:hover {
            color: var(--ocean-blue);
        }

        .btn-login {
            width: 100%;
            padding: 13px 18px;
            margin-top: 6px;
            border-radius: 12px;
            border: none;
            background: linear-gradient(135deg, var(--navy-primary) 0%, var(--ocean-blue) 100%);
            color: #ffffff;
            font-size: 14px;
            font-weight: 800;
            letter-spacing: 0.2px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 10px 22px rgba(30, 58, 95, 0.24);
            transition: all 0.2s ease;
        }

        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 26px rgba(30, 58, 95, 0.30);
        }

        .auth-switch {
            margin-top: 16px;
            text-align: center;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text-muted);
        }

        .auth-switch a {
            color: var(--ocean-blue);
            font-weight: 800;
            text-decoration: none;
        }

        .auth-switch a:hover {
            text-decoration: underline;
        }

        @media (max-width: 820px) {
            .ct-login-wrapper {
                flex-direction: column;
                max-width: 460px;
            }
            .ct-left-panel {
                display: none;
            }
            .ct-right-panel {
                width: 100%;
                flex: 1 1 auto;
                padding: 36px 28px;
            }
        }
    </style>
</head>
<body>

<div class="ct-login-wrapper">

    <!-- Left Maritime Hero Panel -->
    <div class="ct-left-panel">
        <div class="logo-row">
            <div class="logo-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1">
                    <path d="M2 21c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1 .6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"/>
                    <path d="M19.38 20A11.6 11.6 0 0 0 21 14l-9-4-9 4c0 2.9.94 5.34 2.81 7.76"/>
                    <path d="M19 13V7a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v6"/>
                    <path d="M12 10v4"/>
                    <path d="M12 2v3"/>
                </svg>
            </div>
            <div>
                <div class="logo-title">CargoTrace</div>
                <div class="logo-sub">Maritime Supply Visibility</div>
            </div>
        </div>

        <div class="hero-copy">
            <div class="hero-pill">
                <span class="pulse-dot"></span>
                Real-Time Logistics Telemetry
            </div>

            <h1>Create Your Account</h1>

            <p>
                Daftar akun baru untuk mulai memantau status pengiriman,
                riwayat tracking, dan informasi logistik di CargoTrace.
            </p>
        </div>

        <div class="feature-grid">
            <div class="feat-item">
                <div class="feat-title">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#7DD3FC" stroke-width="2.2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                    </svg>
                    Live GPS &amp; Rute
                </div>
                <div class="feat-desc">Visualisasi jalur pelabuhan asal hingga tujuan akhir</div>
            </div>

            <div class="feat-item">
                <div class="feat-title">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#7DD3FC" stroke-width="2.2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                    Instant Access
                </div>
                <div class="feat-desc">Langsung masuk ke dashboard setelah pendaftaran</div>
            </div>
        </div>
    </div>

    <!-- Right Register Form Panel -->
    <div class="ct-right-panel">

        <h2>Create Account</h2>

        <p class="subtitle">
            Buat akun CargoTrace menggunakan email dan password pilihan Anda.
        </p>

        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <div class="input-wrap">
                    <svg class="input-icon" viewBox="0 0 24 24">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="ct-input"
                        placeholder="Masukkan nama lengkap"
                        value="{{ old('name') }}"
                        required
                        autofocus
                    >
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-wrap">
                    <svg class="input-icon" viewBox="0 0 24 24">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <polyline points="22,6 12,13 2,6"/>
                    </svg>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="ct-input"
                        placeholder="Masukkan email"
                        value="{{ old('email') }}"
                        required
                    >
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <svg class="input-icon" viewBox="0 0 24 24">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="ct-input"
                        placeholder="Minimal 6 karakter"
                        required
                    >
                    <button type="button" class="btn-toggle-pw" onclick="togglePassword('password')" title="Tampilkan / Sembunyikan Password">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <div class="input-wrap">
                    <svg class="input-icon" viewBox="0 0 24 24">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="ct-input"
                        placeholder="Ulangi password"
                        required
                    >
                    <button type="button" class="btn-toggle-pw" onclick="togglePassword('password_confirmation')" title="Tampilkan / Sembunyikan Konfirmasi Password">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-login">
                <span>Register</span>
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3">
                    <line x1="5" y1="12" x2="19" y2="12"/>
                    <polyline points="12 5 19 12 12 19"/>
                </svg>
            </button>
        </form>

        <div class="auth-switch">
            Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
        </div>

    </div>

</div>

<script>
    function togglePassword(inputId) {
        const passInput = document.getElementById(inputId);
        if (!passInput) return;
        passInput.type = passInput.type === 'password' ? 'text' : 'password';
    }
</script>

</body>
</html>