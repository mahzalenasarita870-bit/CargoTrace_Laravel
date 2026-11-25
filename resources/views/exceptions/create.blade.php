<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Shipment Exception — CargoTrace Maritime Visibility</title>

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
            --glass-bg: rgba(255, 255, 255, 0.84);
            --glass-strong: rgba(255, 255, 255, 0.96);
            --glass-border: rgba(255, 255, 255, 0.95);
            --text-dark: #102A43;
            --text-muted: #526D82;
            --teal-pos: #1D7A68;
            --teal-bg: #E0F2EE;
            --amber-warn: #B7791F;
            --amber-bg: #FEF3C7;
            --orange-high: #C2410C;
            --orange-bg: #FFEDD5;
            --coral-err: #C53030;
            --coral-bg: #FEE2E2;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background:
                radial-gradient(circle at 10% 8%, rgba(74, 144, 226, 0.28), transparent 38%),
                radial-gradient(circle at 90% 15%, rgba(127, 179, 213, 0.42), transparent 42%),
                radial-gradient(circle at 50% 95%, rgba(43, 108, 176, 0.16), transparent 50%),
                linear-gradient(160deg, var(--ice-bg-1) 0%, var(--ice-bg-2) 50%, var(--ice-bg-3) 100%);
            color: var(--text-dark);
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ================= SIDEBAR ================= */
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.88) 0%, rgba(238, 246, 252, 0.84) 100%);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border-right: 1px solid var(--glass-border);
            box-shadow: 4px 0 24px rgba(30, 58, 95, 0.06);
            display: flex;
            flex-direction: column;
            padding: 24px 16px;
            flex-shrink: 0;
            position: sticky;
            top: 0;
            height: 100vh;
            z-index: 20;
        }

        .brand-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 4px 8px;
            margin-bottom: 14px;
        }

        .brand-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--navy-primary), var(--cerulean));
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 14px rgba(43, 108, 176, 0.28);
        }

        .brand-text {
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -0.4px;
            color: var(--navy-deep);
        }

        .brand-sub {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 500;
        }

        .role-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(43, 108, 176, 0.10);
            color: var(--ocean-blue);
            border: 1px solid rgba(43, 108, 176, 0.20);
            font-size: 11px;
            font-weight: 700;
            padding: 5px 12px;
            border-radius: 999px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin: 0 8px 22px 8px;
            width: fit-content;
        }

        .role-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--teal-pos);
        }

        .nav-section-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.9px;
            color: #7B93A8;
            padding: 8px 12px 6px;
        }

        .nav-list {
            flex: 1;
            overflow-y: auto;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 11px;
            color: var(--text-muted);
            text-decoration: none;
            padding: 10px 14px;
            border-radius: 11px;
            margin-bottom: 4px;
            font-size: 13.5px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .nav-link svg {
            width: 17px;
            height: 17px;
            stroke: currentColor;
            stroke-width: 1.9;
            fill: none;
            flex-shrink: 0;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.9);
            color: var(--navy-primary);
            transform: translateX(2px);
        }

        .nav-link.active {
            background: linear-gradient(135deg, var(--navy-primary), var(--ocean-blue));
            color: #ffffff;
            box-shadow: 0 6px 16px rgba(30, 58, 95, 0.22);
        }

        .logout-form {
            margin-top: 14px;
            padding-top: 14px;
            border-top: 1px solid rgba(30, 58, 95, 0.08);
        }

        .btn-logout {
            width: 100%;
            padding: 10px 14px;
            background: rgba(197, 48, 48, 0.08);
            color: var(--coral-err);
            border: 1px solid rgba(197, 48, 48, 0.18);
            border-radius: 11px;
            cursor: pointer;
            font-weight: 700;
            font-size: 13.5px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s ease;
        }

        .btn-logout:hover {
            background: var(--coral-err);
            color: #ffffff;
        }

        /* ================= MAIN AREA ================= */
        .main {
            flex: 1;
            padding: 24px 32px;
            overflow-x: hidden;
        }

        /* MARITIME HERO BANNER */
        .hero-banner {
            background: linear-gradient(125deg, #132A46 0%, #1E4976 55%, #2B6CB0 100%);
            border-radius: 20px;
            padding: 24px 28px;
            color: #ffffff;
            margin-bottom: 22px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 18px;
            box-shadow: 0 12px 30px rgba(19, 42, 70, 0.18);
            position: relative;
            overflow: hidden;
        }

        .hero-banner::after {
            content: '';
            position: absolute;
            right: -40px;
            bottom: -60px;
            width: 240px;
            height: 240px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(127, 179, 213, 0.26) 0%, transparent 70%);
            pointer-events: none;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.22);
            padding: 5px 12px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.6px;
            text-transform: uppercase;
            margin-bottom: 8px;
            color: #FDE68A;
        }

        .hero-title {
            font-size: 23px;
            font-weight: 800;
            letter-spacing: -0.4px;
        }

        .hero-desc {
            font-size: 13.5px;
            color: #CBD5E1;
            margin-top: 4px;
        }

        .btn-hero-light {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 10px 16px;
            background: rgba(255, 255, 255, 0.14);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.26);
            text-decoration: none;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 700;
            backdrop-filter: blur(8px);
            transition: all 0.2s ease;
            z-index: 2;
        }

        .btn-hero-light:hover {
            background: rgba(255, 255, 255, 0.24);
        }

        /* ================= 2-COLUMN WORKSPACE LAYOUT ================= */
        .content-layout {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 22px;
            align-items: start;
        }

        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: 18px;
            padding: 26px 28px;
            box-shadow: 0 8px 28px rgba(30, 58, 95, 0.06);
        }

        .error-alert {
            background: var(--coral-bg);
            color: var(--coral-err);
            border: 1px solid rgba(197, 48, 48, 0.24);
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 22px;
            font-size: 13px;
        }

        .error-alert ul {
            margin-left: 20px;
            margin-top: 6px;
        }

        .section-block {
            margin-bottom: 24px;
            padding-bottom: 22px;
            border-bottom: 1px solid rgba(30, 58, 95, 0.08);
        }

        .section-block:last-of-type {
            border-bottom: none;
            margin-bottom: 8px;
            padding-bottom: 0;
        }

        .section-head {
            display: flex;
            align-items: center;
            gap: 11px;
            margin-bottom: 16px;
        }

        .section-icon {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: rgba(197, 48, 48, 0.10);
            color: var(--coral-err);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .section-icon.blue {
            background: rgba(43, 108, 176, 0.11);
            color: var(--ocean-blue);
        }

        .section-icon svg {
            width: 17px;
            height: 17px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
        }

        .section-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--navy-deep);
        }

        .section-sub {
            font-size: 12px;
            color: var(--text-muted);
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px 20px;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        .form-group label {
            display: block;
            margin-bottom: 7px;
            color: var(--navy-primary);
            font-size: 12.5px;
            font-weight: 700;
        }

        .required-star {
            color: var(--coral-err);
            margin-left: 2px;
        }

        .time-row {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .btn-now {
            padding: 11px 14px;
            background: rgba(43, 108, 176, 0.10);
            color: var(--ocean-blue);
            border: 1px solid rgba(43, 108, 176, 0.22);
            border-radius: 10px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            white-space: nowrap;
            transition: all 0.16s ease;
        }

        .btn-now:hover {
            background: var(--ocean-blue);
            color: #ffffff;
        }

        input, select, textarea {
            width: 100%;
            padding: 11px 14px;
            border: 1px solid rgba(30, 58, 95, 0.16);
            border-radius: 10px;
            font-size: 13.5px;
            color: var(--text-dark);
            background: var(--glass-strong);
            transition: all 0.18s ease;
        }

        input::placeholder, textarea::placeholder {
            color: #94A3B8;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--ocean-blue);
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(43, 108, 176, 0.14);
        }

        .form-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 22px;
            padding-top: 20px;
            border-top: 1px solid rgba(30, 58, 95, 0.08);
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 11px 18px;
            background: rgba(255, 255, 255, 0.9);
            color: var(--navy-primary);
            border: 1px solid rgba(30, 58, 95, 0.16);
            border-radius: 11px;
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 700;
            transition: all 0.18s ease;
        }

        .btn-back:hover {
            background: #ffffff;
            border-color: var(--navy-primary);
        }

        .btn-save {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 22px;
            background: linear-gradient(135deg, var(--navy-primary), var(--ocean-blue));
            color: #ffffff;
            border: none;
            border-radius: 11px;
            cursor: pointer;
            font-size: 13.5px;
            font-weight: 700;
            box-shadow: 0 6px 16px rgba(43, 108, 176, 0.26);
            transition: all 0.18s ease;
        }

        .btn-save:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(43, 108, 176, 0.34);
        }

        /* ================= RIGHT SIDE TEMPLATES & SEVERITY GUIDE ================= */
        .guide-stack {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .guide-title {
            font-size: 14.5px;
            font-weight: 800;
            color: var(--navy-deep);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .guide-title svg {
            width: 17px;
            height: 17px;
            stroke: var(--ocean-blue);
            stroke-width: 2;
            fill: none;
        }

        .tpl-list {
            display: flex;
            flex-direction: column;
            gap: 9px;
        }

        .tpl-btn {
            display: flex;
            flex-direction: column;
            gap: 3px;
            width: 100%;
            padding: 10px 13px;
            background: rgba(255, 255, 255, 0.80);
            border: 1px solid rgba(30, 58, 95, 0.10);
            border-radius: 10px;
            cursor: pointer;
            text-align: left;
            transition: all 0.16s ease;
        }

        .tpl-btn:hover {
            background: #ffffff;
            border-color: var(--ocean-blue);
            transform: translateX(2px);
        }

        .tpl-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .tpl-name {
            font-size: 12.5px;
            font-weight: 800;
            color: var(--navy-deep);
        }

        .tpl-tag {
            font-size: 10px;
            font-weight: 800;
            padding: 2px 8px;
            border-radius: 999px;
        }

        .tpl-desc {
            font-size: 11.5px;
            color: var(--text-muted);
        }

        .sev-guide-list {
            display: flex;
            flex-direction: column;
            gap: 9px;
        }

        .sev-guide-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 9px 11px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.72);
            border: 1px solid rgba(30, 58, 95, 0.07);
            font-size: 12px;
            color: var(--text-muted);
            line-height: 1.45;
        }

        .sev-pill {
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 10px;
            font-weight: 800;
            flex-shrink: 0;
            margin-top: 1px;
        }

        @media (max-width: 1120px) {
            .content-layout { grid-template-columns: 1fr; }
        }

        @media (max-width: 860px) {
            body { flex-direction: column; }
            .sidebar { width: 100%; height: auto; position: static; }
            .form-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <!-- Sidebar Navigation -->
    <aside class="sidebar">
        <div class="brand-wrap">
            <div class="brand-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1">
                    <path d="M2 21c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1 .6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"/>
                    <path d="M19.38 20A11.6 11.6 0 0 0 21 14l-9-4-9 4c0 2.9.94 5.34 2.81 7.76"/>
                    <path d="M19 13V7a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v6"/>
                    <path d="M12 10v4"/>
                    <path d="M12 2v3"/>
                </svg>
            </div>
            <div>
                <div class="brand-text">CargoTrace</div>
                <div class="brand-sub">Maritime Supply Visibility</div>
            </div>
        </div>

        <div class="role-pill">
            <span class="role-dot"></span>
            {{ auth()->user()->role ?? 'user' }}
        </div>

        <div class="nav-list">
            <div class="nav-section-label">Menu Utama</div>
            <a href="{{ route('dashboard') }}" class="nav-link">
                <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>
                Dashboard
            </a>
            <a href="{{ route('shipments.index') }}" class="nav-link">
                <svg viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
                Shipments
            </a>
            <a href="{{ route('notifications.index') }}" class="nav-link">
                <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                Notifications
            </a>

            @if(auth()->user()->hasRole(['admin', 'operator']))
                <div class="nav-section-label" style="margin-top: 10px;">Operasional</div>
                <a href="{{ route('tracking.index') }}" class="nav-link">
                    <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    Tracking Events
                </a>
                <a href="{{ route('exceptions.index') }}" class="nav-link active">
                    <svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    Exceptions
                </a>
                <a href="{{ route('reports.index') }}" class="nav-link">
                    <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    Reports
                </a>
            @endif

            @if(auth()->user()->isAdmin())
                <div class="nav-section-label" style="margin-top: 10px;">Master & Sistem</div>
                <a href="{{ route('carriers.index') }}" class="nav-link">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="5" r="3"/><line x1="12" y1="22" x2="12" y2="8"/><path d="M5 12H2a10 10 0 0 0 20 0h-3"/></svg>
                    Carriers
                </a>
                <a href="{{ route('locations.index') }}" class="nav-link">
                    <svg viewBox="0 0 24 24"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"/><line x1="8" y1="2" x2="8" y2="18"/><line x1="16" y1="6" x2="16" y2="22"/></svg>
                    Locations
                </a>
                <a href="{{ route('users.index') }}" class="nav-link">
                    <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Users
                </a>
                <a href="{{ route('audit-logs.index') }}" class="nav-link">
                    <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    Audit Logs
                </a>
            @endif
        </div>

        <form action="{{ route('logout') }}" method="POST" class="logout-form">
            @csrf
            <button type="submit" class="btn-logout">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
                </svg>
                Logs Out
            </button>
        </form>
    </aside>

    <!-- Main Content -->
    <main class="main">
        <!-- Maritime Hero Header -->
        <div class="hero-banner">
            <div>
                <div class="hero-badge">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                    </svg>
                    Incident Reporting & Escalation
                </div>
                <h1 class="hero-title">Tambah Shipment Exception</h1>
                <p class="hero-desc">Catat kendala operasional, keterlambatan jadwal pelayaran, kerusakan kargo, atau penahanan bea cukai</p>
            </div>

            <a href="{{ route('exceptions.index') }}" class="btn-hero-light">
                ← Kembali ke Daftar Exceptions
            </a>
        </div>

        <!-- 2-Column Balanced Workspace -->
        <div class="content-layout">
            <!-- Left: Exception Form -->
            <div class="glass-card">
                @if ($errors->any())
                    <div class="error-alert">
                        <strong>Terjadi kesalahan pengisian data:</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('exceptions.store') }}" method="POST">
                    @csrf

                    <!-- Bagian 1: Klasifikasi Kendala -->
                    <div class="section-block">
                        <div class="section-head">
                            <div class="section-icon">
                                <svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                            </div>
                            <div>
                                <div class="section-title">Klasifikasi Insiden & Tingkat Keparahan</div>
                                <div class="section-sub">Pilih nomor shipment terdampak, jenis masalah, dan prioritas penanganan</div>
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-group full">
                                <label>Shipment <span class="required-star">*</span></label>
                                <select name="shipment_id" required>
                                    <option value="">-- Pilih Shipment --</option>
                                    @foreach($shipments as $shipment)
                                        <option value="{{ $shipment->id }}"
                                            {{ old('shipment_id') == $shipment->id ? 'selected' : '' }}>
                                            {{ $shipment->shipment_number }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Exception Type <span class="required-star">*</span></label>
                                <select name="exception_type" id="exceptionTypeSelect" required>
                                    <option value="">-- Pilih Jenis Masalah --</option>
                                    @foreach([
                                        'DELAYED',
                                        'DAMAGED',
                                        'LOST',
                                        'CUSTOMS_HOLD',
                                        'ADDRESS_ISSUE',
                                        'OTHER'
                                    ] as $type)
                                        <option value="{{ $type }}"
                                            {{ old('exception_type') == $type ? 'selected' : '' }}>
                                            {{ str_replace('_', ' ', $type) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Severity <span class="required-star">*</span></label>
                                <select name="severity" id="severitySelect" required>
                                    @foreach(['LOW', 'MEDIUM', 'HIGH', 'CRITICAL'] as $severity)
                                        <option value="{{ $severity }}"
                                            {{ old('severity', 'LOW') == $severity ? 'selected' : '' }}>
                                            {{ $severity }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group full">
                                <label>Detected At <span class="required-star">*</span></label>
                                <div class="time-row">
                                    <input type="datetime-local"
                                           id="detectedAtInput"
                                           name="detected_at"
                                           value="{{ old('detected_at') }}"
                                           required>
                                    <button type="button" class="btn-now" onclick="setNowDateTime()">
                                        Waktu Sekarang
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bagian 2: Kronologi Masalah -->
                    <div class="section-block">
                        <div class="section-head">
                            <div class="section-icon blue">
                                <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                            </div>
                            <div>
                                <div class="section-title">Detail Kronologi & Dampak Pengiriman</div>
                                <div class="section-sub">Jelaskan lokasi kejadian, estimasi keterlambatan, dan tindakan awal</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Description <span class="required-star">*</span></label>
                            <textarea name="description"
                                      id="descriptionTextarea"
                                      rows="4"
                                      placeholder="Jelaskan detail masalah pengiriman secara jelas..."
                                      required>{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('exceptions.index') }}" class="btn-back">
                            ← Batal
                        </a>

                        <button type="submit" class="btn-save">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                            Simpan Exception
                        </button>
                    </div>
                </form>
            </div>

            <!-- Right: Quick Incident Templates & Severity Standards -->
            <div class="guide-stack">
                <div class="glass-card">
                    <div class="guide-title">
                        <svg viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                        Template Laporan Cepat
                    </div>
                    <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 12px;">
                        Klik salah satu skenario di bawah untuk mengisi otomatis jenis kendala, tingkat keparahan, dan deskripsi:
                    </p>
                    <div class="tpl-list">
                        <button type="button" class="tpl-btn" onclick="applyTemplate('DELAYED', 'HIGH', 'Kepadatan sandar di pelabuhan transit (Berth Congestion) menyebabkan keterlambatan bongkar muat sekitar 24 jam.')">
                            <div class="tpl-top">
                                <span class="tpl-name">Port Congestion / Antrean Sandar</span>
                                <span class="tpl-tag" style="background: var(--orange-bg); color: var(--orange-high);">HIGH</span>
                            </div>
                            <span class="tpl-desc">Keterlambatan jadwal kapal akibat antrean dermaga</span>
                        </button>

                        <button type="button" class="tpl-btn" onclick="applyTemplate('CUSTOMS_HOLD', 'MEDIUM', 'Kargo ditahan sementara di terminal pabean untuk verifikasi dokumen manifest dan pemeriksaan fisik.')">
                            <div class="tpl-top">
                                <span class="tpl-name">Customs Hold / Pemeriksaan Pabean</span>
                                <span class="tpl-tag" style="background: var(--amber-bg); color: var(--amber-warn);">MEDIUM</span>
                            </div>
                            <span class="tpl-desc">Tertahan proses verifikasi dokumen bea cukai</span>
                        </button>

                        <button type="button" class="tpl-btn" onclick="applyTemplate('DAMAGED', 'CRITICAL', 'Terdeteksi kerusakan segel dan penyok pada dinding kontainer saat proses pemindahan crane di dermaga.')">
                            <div class="tpl-top">
                                <span class="tpl-name">Container / Cargo Damaged</span>
                                <span class="tpl-tag" style="background: var(--coral-bg); color: var(--coral-err);">CRITICAL</span>
                            </div>
                            <span class="tpl-desc">Kerusakan fisik kemasan atau segel kontainer</span>
                        </button>

                        <button type="button" class="tpl-btn" onclick="applyTemplate('ADDRESS_ISSUE', 'LOW', 'Perlu konfirmasi ulang alamat gudang penerima (consignee) sebelum jadwal pengiriman darat terakhir.')">
                            <div class="tpl-top">
                                <span class="tpl-name">Consignee Address Verification</span>
                                <span class="tpl-tag" style="background: rgba(43, 108, 176, 0.13); color: var(--ocean-blue);">LOW</span>
                            </div>
                            <span class="tpl-desc">Penyesuaian koordinat atau kontak gudang tujuan</span>
                        </button>
                    </div>
                </div>

                <div class="glass-card">
                    <div class="guide-title">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                        Standar Tingkat Keparahan
                    </div>
                    <div class="sev-guide-list">
                        <div class="sev-guide-item">
                            <span class="sev-pill" style="background: var(--coral-bg); color: var(--coral-err);">CRITICAL</span>
                            <span>Kargo hilang, rusak berat, atau terhenti total. Wajib eskalasi segera.</span>
                        </div>
                        <div class="sev-guide-item">
                            <span class="sev-pill" style="background: var(--orange-bg); color: var(--orange-high);">HIGH</span>
                            <span>Keterlambatan signifikan (&gt; 24 jam) yang memengaruhi ETA pelabuhan tujuan.</span>
                        </div>
                        <div class="sev-guide-item">
                            <span class="sev-pill" style="background: var(--amber-bg); color: var(--amber-warn);">MEDIUM</span>
                            <span>Kendala administratif atau bea cukai yang memerlukan tindak lanjut dokumen.</span>
                        </div>
                        <div class="sev-guide-item">
                            <span class="sev-pill" style="background: rgba(43, 108, 176, 0.13); color: var(--ocean-blue);">LOW</span>
                            <span>Catatan minor yang tidak menunda jadwal kedatangan kapal.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        function applyTemplate(type, severity, desc) {
            document.getElementById('exceptionTypeSelect').value = type;
            document.getElementById('severitySelect').value = severity;
            document.getElementById('descriptionTextarea').value = desc;
        }

        function setNowDateTime() {
            const now = new Date();
            const pad = n => String(n).padStart(2, '0');
            const formatted = `${now.getFullYear()}-${pad(now.getMonth() + 1)}-${pad(now.getDate())}T${pad(now.getHours())}:${pad(now.getMinutes())}`;
            document.getElementById('detectedAtInput').value = formatted;
        }
    </script>

</body>
</html>