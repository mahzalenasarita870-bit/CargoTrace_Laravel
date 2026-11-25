<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking History {{ $shipment->shipment_number }} — CargoTrace Maritime Visibility</title>

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
            --coral-err: #C53030;
            --coral-bg: #FEE2E2;
            --indigo-soft: #4338CA;
            --indigo-bg: #E0E7FF;
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
            color: #BAE6FD;
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

        .hero-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            z-index: 2;
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
        }

        .btn-hero-light:hover {
            background: rgba(255, 255, 255, 0.24);
        }

        .btn-hero-cta {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 10px 17px;
            background: #ffffff;
            color: var(--navy-deep);
            text-decoration: none;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 800;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.16);
            transition: all 0.2s ease;
        }

        .btn-hero-cta:hover {
            transform: translateY(-1px);
            background: #F0F9FF;
        }

        /* ================= 2-COLUMN WORKSPACE ================= */
        .history-layout {
            display: grid;
            grid-template-columns: 2.15fr 1fr;
            gap: 22px;
            align-items: start;
        }

        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: 18px;
            padding: 24px 26px;
            box-shadow: 0 8px 28px rgba(30, 58, 95, 0.06);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid rgba(30, 58, 95, 0.08);
        }

        .card-title-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-icon {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: rgba(43, 108, 176, 0.11);
            color: var(--ocean-blue);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-icon svg {
            width: 17px;
            height: 17px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
        }

        .card-title {
            font-size: 15.5px;
            font-weight: 800;
            color: var(--navy-deep);
        }

        .count-pill {
            padding: 4px 11px;
            border-radius: 999px;
            font-size: 11.5px;
            font-weight: 800;
            background: rgba(43, 108, 176, 0.11);
            color: var(--ocean-blue);
        }

        /* ================= VERTICAL TIMELINE ================= */
        .timeline {
            position: relative;
            padding-left: 28px;
            margin-left: 8px;
            border-left: 2px solid rgba(43, 108, 176, 0.25);
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .timeline-item {
            position: relative;
            background: rgba(255, 255, 255, 0.85);
            border: 1px solid rgba(30, 58, 95, 0.09);
            border-radius: 14px;
            padding: 15px 18px;
            transition: all 0.2s ease;
        }

        .timeline-item:hover {
            background: #ffffff;
            transform: translateX(3px);
            box-shadow: 0 6px 18px rgba(30, 58, 95, 0.07);
        }

        .timeline-dot {
            position: absolute;
            left: -37px;
            top: 18px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: var(--ocean-blue);
            border: 3px solid #ffffff;
            box-shadow: 0 0 0 3px rgba(43, 108, 176, 0.22);
        }

        .timeline-item.latest .timeline-dot {
            background: var(--teal-pos);
            box-shadow: 0 0 0 4px rgba(29, 122, 104, 0.24);
        }

        .timeline-item.latest {
            background: linear-gradient(135deg, rgba(240, 253, 250, 0.92), rgba(255, 255, 255, 0.96));
            border-color: rgba(29, 122, 104, 0.24);
        }

        .ev-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 8px;
        }

        .ev-left-tags {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .event-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 11px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.3px;
        }

        .ev-delivered { background: var(--teal-bg); color: var(--teal-pos); }
        .ev-transit   { background: rgba(43, 108, 176, 0.13); color: var(--ocean-blue); }
        .ev-departed  { background: var(--indigo-bg); color: var(--indigo-soft); }
        .ev-pickup    { background: var(--amber-bg); color: var(--amber-warn); }
        .ev-delayed   { background: var(--coral-bg); color: var(--coral-err); }
        .ev-created   { background: rgba(82, 109, 130, 0.12); color: var(--text-muted); }

        .latest-tag {
            padding: 3px 9px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            background: var(--navy-primary);
            color: #ffffff;
        }

        .ev-date {
            font-size: 12px;
            font-weight: 700;
            color: var(--text-muted);
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .ev-location {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13.5px;
            font-weight: 700;
            color: var(--navy-deep);
            margin-bottom: 6px;
        }

        .ev-location svg {
            width: 15px;
            height: 15px;
            stroke: var(--ocean-blue);
            stroke-width: 2;
            fill: none;
            flex-shrink: 0;
        }

        .ev-desc {
            font-size: 13px;
            color: var(--text-muted);
            line-height: 1.5;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: var(--text-muted);
            background: rgba(255, 255, 255, 0.65);
            border-radius: 14px;
            border: 1px dashed rgba(30, 58, 95, 0.18);
        }

        /* ================= RIGHT SHIPMENT SUMMARY PANEL ================= */
        .summary-stack {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .info-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            padding: 11px 13px;
            background: rgba(255, 255, 255, 0.78);
            border: 1px solid rgba(30, 58, 95, 0.08);
            border-radius: 11px;
            font-size: 12.5px;
        }

        .info-lbl {
            color: var(--text-muted);
            font-weight: 600;
        }

        .info-val {
            color: var(--navy-deep);
            font-weight: 800;
            text-align: right;
        }

        .status-pill {
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 800;
            background: rgba(43, 108, 176, 0.13);
            color: var(--ocean-blue);
        }

        .btn-detail-full {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            width: 100%;
            margin-top: 14px;
            padding: 11px 16px;
            background: linear-gradient(135deg, var(--navy-primary), var(--ocean-blue));
            color: #ffffff;
            text-decoration: none;
            border-radius: 11px;
            font-size: 13px;
            font-weight: 700;
            box-shadow: 0 5px 15px rgba(43, 108, 176, 0.24);
            transition: all 0.18s ease;
        }

        .btn-detail-full:hover {
            transform: translateY(-1px);
            box-shadow: 0 7px 19px rgba(43, 108, 176, 0.32);
        }

        @media (max-width: 1100px) {
            .history-layout { grid-template-columns: 1fr; }
        }

        @media (max-width: 860px) {
            body { flex-direction: column; }
            .sidebar { width: 100%; height: auto; position: static; }
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
                <a href="{{ route('tracking.index') }}" class="nav-link active">
                    <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    Tracking Events
                </a>
                <a href="{{ route('exceptions.index') }}" class="nav-link">
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
                        <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                    </svg>
                    Voyage Checkpoint History
                </div>
                <h1 class="hero-title">Tracking History: {{ $shipment->shipment_number }}</h1>
                <p class="hero-desc">Kronologi lengkap perjalanan kargo dan titik singgah pelabuhan dalam sistem CargoTrace</p>
            </div>

            <div class="hero-actions">
                <a href="{{ route('tracking.index') }}" class="btn-hero-light">
                    ← Kembali ke Tracking
                </a>
                <a href="{{ route('tracking.create') }}" class="btn-hero-cta">
                    + Tambah Checkpoint
                </a>
            </div>
        </div>

        @php
            $currentStatus = $shipment->current_status ?? $shipment->status ?? 'IN_TRANSIT';
        @endphp

        <!-- 2-Column Workspace -->
        <div class="history-layout">
            <!-- Left: Vertical Checkpoint Timeline -->
            <div class="glass-card">
                <div class="card-header">
                    <div class="card-title-wrap">
                        <div class="card-icon">
                            <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        </div>
                        <h2 class="card-title">Perjalanan Paket & Checkpoint Pelabuhan</h2>
                    </div>
                    <span class="count-pill">{{ $trackingEvents->count() }} Checkpoint</span>
                </div>

                @if($trackingEvents->count() > 0)
                    <div class="timeline">
                        @foreach($trackingEvents as $event)
                            @php
                                $evType = strtoupper($event->event_type ?? '');
                                $badgeClass = 'ev-created';
                                if ($evType === 'DELIVERED') {
                                    $badgeClass = 'ev-delivered';
                                } elseif ($evType === 'IN_TRANSIT') {
                                    $badgeClass = 'ev-transit';
                                } elseif ($evType === 'DEPARTED' || $evType === 'ARRIVED') {
                                    $badgeClass = 'ev-departed';
                                } elseif ($evType === 'PICKED_UP' || $evType === 'BOOKED') {
                                    $badgeClass = 'ev-pickup';
                                } elseif ($evType === 'DELAYED') {
                                    $badgeClass = 'ev-delayed';
                                }
                            @endphp

                            <div class="timeline-item {{ $loop->last ? 'latest' : '' }}">
                                <span class="timeline-dot"></span>

                                <div class="ev-top">
                                    <div class="ev-left-tags">
                                        <span class="event-badge {{ $badgeClass }}">
                                            ● {{ str_replace('_', ' ', $event->event_type) }}
                                        </span>

                                        @if($loop->last)
                                            <span class="latest-tag">Posisi Terkini</span>
                                        @endif
                                    </div>

                                    <div class="ev-date">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                                        </svg>
                                        {{ $event->event_time?->format('d-m-Y H:i') ?? '-' }}
                                    </div>
                                </div>

                                <div class="ev-location">
                                    <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                    {{ $event->location->name ?? '-' }}
                                </div>

                                <div class="ev-desc">
                                    {{ $event->description ?? 'Tidak ada deskripsi tambahan.' }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <p style="font-size: 15px; font-weight: 800; color: var(--navy-deep); margin-bottom: 4px;">Belum ada riwayat tracking</p>
                        <p style="font-size: 13px;">Belum ada titik checkpoint yang dicatat untuk shipment ini.</p>
                    </div>
                @endif
            </div>

            <!-- Right: Shipment Information Card -->
            <div class="summary-stack">
                <div class="glass-card">
                    <div class="card-header">
                        <div class="card-title-wrap">
                            <div class="card-icon">
                                <svg viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                            </div>
                            <h2 class="card-title">Shipment Information</h2>
                        </div>
                    </div>

                    <div class="info-list">
                        <div class="info-row">
                            <span class="info-lbl">Shipment Number</span>
                            <span class="info-val">{{ $shipment->shipment_number }}</span>
                        </div>

                        <div class="info-row">
                            <span class="info-lbl">Status Manifest</span>
                            <span class="status-pill">{{ str_replace('_', ' ', $currentStatus) }}</span>
                        </div>

                        @if($shipment->originLocation)
                            <div class="info-row">
                                <span class="info-lbl">Origin</span>
                                <span class="info-val">{{ $shipment->originLocation->name }}</span>
                            </div>
                        @endif

                        @if($shipment->destinationLocation)
                            <div class="info-row">
                                <span class="info-lbl">Destination</span>
                                <span class="info-val">{{ $shipment->destinationLocation->name }}</span>
                            </div>
                        @endif

                        @if($shipment->carrier)
                            <div class="info-row">
                                <span class="info-lbl">Carrier</span>
                                <span class="info-val">{{ $shipment->carrier->name }}</span>
                            </div>
                        @endif

                        <div class="info-row">
                            <span class="info-lbl">Total Checkpoint</span>
                            <span class="info-val">{{ $trackingEvents->count() }} Titik</span>
                        </div>
                    </div>

                    <a href="{{ route('shipments.show', $shipment->id) }}" class="btn-detail-full">
                        Lihat Detail & Peta Rute Shipment →
                    </a>
                </div>
            </div>
        </div>
    </main>

</body>
</html>