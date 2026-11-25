<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Shipment {{ $shipment->shipment_number }} — CargoTrace Maritime Visibility</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Leaflet.js CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

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
            margin-bottom: 20px;
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

        .hero-title-row {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .hero-title {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.4px;
        }

        .hero-desc {
            font-size: 13.5px;
            color: #CBD5E1;
            margin-top: 4px;
        }

        .schedule-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 13px;
            border-radius: 999px;
            font-size: 11.5px;
            font-weight: 800;
            letter-spacing: 0.3px;
        }

        .schedule-pill.ontime {
            background: rgba(224, 242, 238, 0.95);
            color: var(--teal-pos);
        }

        .schedule-pill.delayed {
            background: rgba(254, 226, 226, 0.96);
            color: var(--coral-err);
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
            padding: 10px 18px;
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
            transform: translateY(-2px);
            background: #F0F9FF;
        }

        /* Alert Banners */
        .alert-box {
            padding: 14px 18px;
            border-radius: 14px;
            font-size: 13.5px;
            line-height: 1.5;
            margin-bottom: 18px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            backdrop-filter: blur(12px);
        }

        .alert-box svg {
            width: 18px;
            height: 18px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .alert-danger {
            background: rgba(254, 226, 226, 0.92);
            border: 1px solid rgba(197, 48, 48, 0.24);
            color: var(--coral-err);
        }

        .alert-info {
            background: rgba(255, 255, 255, 0.88);
            border: 1px solid rgba(43, 108, 176, 0.22);
            color: var(--navy-primary);
        }

        /* ================= 2-COLUMN WORKSPACE ================= */
        .detail-layout {
            display: grid;
            grid-template-columns: 1.35fr 1fr;
            gap: 22px;
            align-items: start;
        }

        .stack-col {
            display: flex;
            flex-direction: column;
            gap: 22px;
        }

        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: 18px;
            padding: 22px 24px;
            box-shadow: 0 8px 26px rgba(30, 58, 95, 0.06);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid rgba(30, 58, 95, 0.08);
        }

        .card-title-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-icon {
            width: 32px;
            height: 32px;
            border-radius: 9px;
            background: rgba(43, 108, 176, 0.11);
            color: var(--ocean-blue);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-icon svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
        }

        .card-title {
            font-size: 15.5px;
            font-weight: 800;
            color: var(--navy-deep);
        }

        /* Info Spec Grid */
        .spec-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .spec-item {
            padding: 14px 16px;
            background: rgba(255, 255, 255, 0.78);
            border-radius: 12px;
            border: 1px solid rgba(30, 58, 95, 0.09);
        }

        .spec-item label {
            display: block;
            color: var(--text-muted);
            font-size: 11px;
            font-weight: 700;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .spec-item p {
            font-weight: 700;
            font-size: 14px;
            color: var(--navy-deep);
            word-break: break-word;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 11px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 800;
            background: rgba(43, 108, 176, 0.14);
            color: var(--ocean-blue);
        }

        /* Map Legend & Container */
        .map-legend {
            display: flex;
            gap: 14px;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
        }

        .legend-dot {
            display: inline-block;
            width: 9px;
            height: 9px;
            border-radius: 50%;
            margin-right: 5px;
        }

        #shipment-map {
            width: 100%;
            height: 360px;
            border-radius: 12px;
            border: 1px solid rgba(30, 58, 95, 0.14);
            z-index: 1;
        }

        /* Timeline */
        .timeline {
            list-style: none;
            margin-top: 6px;
            border-left: 2px solid rgba(43, 108, 176, 0.25);
            padding-left: 18px;
            margin-left: 6px;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 14px;
            background: rgba(255, 255, 255, 0.85);
            padding: 13px 16px;
            border-radius: 12px;
            border: 1px solid rgba(30, 58, 95, 0.09);
        }

        .timeline-item:last-child {
            margin-bottom: 0;
        }

        .timeline-item::before {
            content: "";
            position: absolute;
            left: -24px;
            top: 17px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--ocean-blue);
            border: 2px solid #ffffff;
            box-shadow: 0 0 0 2px rgba(43, 108, 176, 0.25);
        }

        .timeline-item.exception {
            background: rgba(254, 226, 226, 0.65);
            border-color: rgba(197, 48, 48, 0.22);
        }

        .timeline-item.exception::before {
            background: var(--coral-err);
            box-shadow: 0 0 0 2px rgba(197, 48, 48, 0.25);
        }

        .timeline-meta {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
            font-size: 11.5px;
            color: var(--text-muted);
            margin-bottom: 4px;
        }

        .timeline-title {
            font-weight: 800;
            font-size: 14px;
            color: var(--navy-deep);
        }

        .timeline-desc {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 4px;
            line-height: 1.45;
        }

        .empty-note {
            font-size: 13px;
            color: var(--text-muted);
            padding: 8px 0;
        }

        @media (max-width: 1140px) {
            .detail-layout { grid-template-columns: 1fr; }
        }

        @media (max-width: 860px) {
            body { flex-direction: column; }
            .sidebar { width: 100%; height: auto; position: static; }
            .spec-grid { grid-template-columns: 1fr; }
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
            <a href="{{ route('shipments.index') }}" class="nav-link active">
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
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                    </svg>
                    Manifest Telemetry & Tracking
                </div>
                <div class="hero-title-row">
                    <h1 class="hero-title">Detail Shipment: {{ $shipment->shipment_number }}</h1>
                    @if($shipment->is_delayed)
                        <span class="schedule-pill delayed">
                            ● DELAYED ({{ $shipment->delay_hours }} jam - {{ $shipment->delay_severity ?? 'HIGH' }})
                        </span>
                    @else
                        <span class="schedule-pill ontime">
                            ● ON SCHEDULE
                        </span>
                    @endif
                </div>
                <p class="hero-desc">Informasi lengkap pengiriman, status ETA, peta koridor pelayaran, dan riwayat tracking CargoTrace</p>
            </div>

            <div class="hero-actions">
                <a href="{{ route('shipments.index') }}" class="btn-hero-light">
                    ← Kembali
                </a>

                @if(auth()->user()->hasRole(['admin', 'operator']))
                    <a href="{{ route('shipments.edit', $shipment->id) }}" class="btn-hero-cta">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                        Edit Shipment
                    </a>
                @endif
            </div>
        </div>

        <!-- Alert Keterlambatan -->
        @if($shipment->is_delayed && $shipment->delay_reason)
            <div class="alert-box alert-danger">
                <svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                <div>
                    <strong>Alasan Keterlambatan:</strong> {{ $shipment->delay_reason }}
                </div>
            </div>
        @endif

        <!-- Alert Cuaca Operasional -->
        @if(isset($weather) && ($weather['available'] ?? false))
            <div class="alert-box alert-info">
                <svg viewBox="0 0 24 24"><path d="M17.5 19H9a7 7 0 1 1 6.71-9h1.79a4.5 4.5 0 1 1 0 9Z"/></svg>
                <div>
                    <strong>Cuaca Operasional Sekitar Lokasi Terkini:</strong>
                    Suhu {{ $weather['temperature_c'] }}°C, Kecepatan Angin {{ $weather['windspeed_kmh'] }} km/jam.
                    <br><small style="color: var(--text-muted);">{{ $weather['disclaimer'] }}</small>
                </div>
            </div>
        @endif

        <!-- 2-Column Balanced Workspace -->
        <div class="detail-layout">
            <!-- Left Column: Manifest Spec + Timeline & Exceptions -->
            <div class="stack-col">
                <!-- Card 1: Spesifikasi Manifest -->
                <div class="glass-card">
                    <div class="card-header">
                        <div class="card-title-wrap">
                            <div class="card-icon">
                                <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            </div>
                            <h2 class="card-title">Informasi & Spesifikasi Manifest</h2>
                        </div>
                    </div>

                    <div class="spec-grid">
                        <div class="spec-item">
                            <label>Shipment Number</label>
                            <p>{{ $shipment->shipment_number }}</p>
                        </div>

                        <div class="spec-item">
                            <label>Current Status</label>
                            <p>
                                <span class="status-badge">
                                    ● {{ str_replace('_', ' ', $shipment->current_status) }}
                                </span>
                            </p>
                        </div>

                        <div class="spec-item">
                            <label>Customer</label>
                            <p>{{ $shipment->customer->name ?? '-' }}</p>
                        </div>

                        <div class="spec-item">
                            <label>Carrier</label>
                            <p>{{ $shipment->carrier->name ?? '-' }}</p>
                        </div>

                        <div class="spec-item">
                            <label>Origin Location</label>
                            <p>{{ $shipment->origin->name ?? '-' }}</p>
                        </div>

                        <div class="spec-item">
                            <label>Destination Location</label>
                            <p>{{ $shipment->destination->name ?? '-' }}</p>
                        </div>

                        <div class="spec-item">
                            <label>Cargo Type</label>
                            <p>{{ $shipment->cargo_type }}</p>
                        </div>

                        <div class="spec-item">
                            <label>Weight / Volume</label>
                            <p>{{ $shipment->weight ?? '-' }} kg / {{ $shipment->volume ?? '-' }} m³</p>
                        </div>

                        <div class="spec-item">
                            <label>Expected Departure (ETD)</label>
                            <p>
                                {{ $shipment->expected_departure
                                    ? \Carbon\Carbon::parse($shipment->expected_departure)->format('d-m-Y H:i')
                                    : '-' }}
                            </p>
                        </div>

                        <div class="spec-item">
                            <label>Expected Arrival</label>
                            <p>
                                {{ $shipment->expected_arrival
                                    ? \Carbon\Carbon::parse($shipment->expected_arrival)->format('d-m-Y H:i')
                                    : '-' }}
                            </p>
                        </div>

                        <div class="spec-item">
                            <label>Estimated Arrival (ETA)</label>
                            <p>
                                {{ $shipment->estimated_arrival
                                    ? \Carbon\Carbon::parse($shipment->estimated_arrival)->format('d-m-Y H:i')
                                    : '-' }}
                            </p>
                        </div>

                        <div class="spec-item">
                            <label>Current Location (Latest Valid Event)</label>
                            <p>
                                {{ $shipment->trackingEvents->last()?->location?->name
                                    ?? $shipment->origin->name
                                    ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Laporan Kendala (Exceptions) jika ada -->
                @if($shipment->exceptions && $shipment->exceptions->count() > 0)
                    <div class="glass-card">
                        <div class="card-header">
                            <div class="card-title-wrap">
                                <div class="card-icon" style="background: var(--coral-bg); color: var(--coral-err);">
                                    <svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                                </div>
                                <h2 class="card-title">Laporan Kendala (Exceptions)</h2>
                            </div>
                        </div>

                        <ul class="timeline">
                            @foreach($shipment->exceptions as $exc)
                                <li class="timeline-item exception">
                                    <div class="timeline-meta">
                                        Terdeteksi: {{ \Carbon\Carbon::parse($exc->detected_at)->format('d-m-Y H:i') }}
                                        • Severity: <strong>{{ $exc->severity }}</strong>
                                        • Status: <strong>{{ $exc->status }}</strong>
                                    </div>
                                    <div class="timeline-title">{{ str_replace('_', ' ', $exc->exception_type) }}</div>
                                    <div class="timeline-desc">{{ $exc->description }}</div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <!-- Right Column: Interactive Map + Chronological Timeline -->
            <div class="stack-col">
                <!-- Card 3: Peta Rute & Titik Pelacakan -->
                <div class="glass-card">
                    <div class="card-header">
                        <div class="card-title-wrap">
                            <div class="card-icon">
                                <svg viewBox="0 0 24 24"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"/><line x1="8" y1="2" x2="8" y2="18"/><line x1="16" y1="6" x2="16" y2="22"/></svg>
                            </div>
                            <h2 class="card-title">Peta Rute & Titik Pelacakan</h2>
                        </div>
                        <div class="map-legend">
                            <span><i class="legend-dot" style="background:#1D7A68;"></i>Origin</span>
                            <span><i class="legend-dot" style="background:#2B6CB0;"></i>Transit</span>
                            <span><i class="legend-dot" style="background:#C53030;"></i>Destination</span>
                        </div>
                    </div>

                    <div id="shipment-map"></div>
                </div>

                <!-- Card 4: Timeline Perjalanan -->
                <div class="glass-card">
                    <div class="card-header">
                        <div class="card-title-wrap">
                            <div class="card-icon">
                                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            </div>
                            <h2 class="card-title">Timeline Perjalanan</h2>
                        </div>
                    </div>

                    @if($shipment->trackingEvents && $shipment->trackingEvents->count() > 0)
                        <ul class="timeline">
                            @foreach($shipment->trackingEvents as $event)
                                <li class="timeline-item">
                                    <div class="timeline-meta">
                                        <span>{{ \Carbon\Carbon::parse($event->event_time)->format('d-m-Y H:i') }}</span>
                                        @if($event->location)
                                            <span>•</span>
                                            <span style="display:inline-flex; align-items:center; gap:3px; font-weight:700; color:var(--ocean-blue);">
                                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                                {{ $event->location->name }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="timeline-title">{{ str_replace('_', ' ', $event->event_type) }}</div>
                                    <div class="timeline-desc">{{ $event->description ?? 'Status pengiriman diperbarui.' }}</div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="empty-note">Belum ada riwayat tracking event untuk pengiriman ini.</p>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <!-- Leaflet.js Script -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const map = L.map('shipment-map').setView([10.0, 60.0], 3);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        function resolveCoords(loc) {
            if (!loc) return null;
            if (loc.latitude && loc.longitude) {
                return [parseFloat(loc.latitude), parseFloat(loc.longitude)];
            }
            const name = (loc.name || '').toLowerCase();
            if (name.includes('jakarta') || name.includes('priok')) return [-6.1025, 106.8833];
            if (name.includes('singapore')) return [1.2644, 103.8222];
            if (name.includes('rotterdam')) return [51.9496, 4.1453];
            if (name.includes('tokyo')) return [35.6192, 139.7798];
            if (name.includes('surabaya')) return [-7.2047, 112.7344];
            if (name.includes('shanghai')) return [31.2304, 121.4737];
            return null;
        }

        const points = [];
        const originObj = @json($shipment->origin);
        const destObj = @json($shipment->destination);
        const events = @json($shipment->trackingEvents);

        // 1. Marker Origin (Teal)
        const originCoords = resolveCoords(originObj);
        if (originCoords) {
            points.push(originCoords);
            L.circleMarker(originCoords, {
                radius: 9,
                fillColor: '#1D7A68',
                color: '#ffffff',
                weight: 2.5,
                fillOpacity: 1
            }).addTo(map).bindPopup(`<strong>Origin:</strong><br>${originObj.name}`);
        }

        // 2. Marker Tracking Events (Ocean Blue)
        let latestMarker = null;
        if (Array.isArray(events)) {
            events.forEach((ev, idx) => {
                let evCoords = null;
                if (ev.latitude && ev.longitude) {
                    evCoords = [parseFloat(ev.latitude), parseFloat(ev.longitude)];
                } else if (ev.location) {
                    evCoords = resolveCoords(ev.location);
                }

                if (evCoords) {
                    points.push(evCoords);
                    const isLast = idx === events.length - 1;
                    const marker = L.circleMarker(evCoords, {
                        radius: isLast ? 10 : 7,
                        fillColor: '#2B6CB0',
                        color: '#ffffff',
                        weight: 2.5,
                        fillOpacity: 1
                    }).addTo(map).bindPopup(`
                        <strong>${isLast ? 'Posisi Terkini' : 'Checkpoint'}: ${ev.event_type.replace('_', ' ')}</strong><br>
                        ${ev.location ? ev.location.name + '<br>' : ''}
                        <small>${ev.description ?? ''}</small>
                    `);

                    if (isLast) latestMarker = marker;
                }
            });
        }

        // 3. Marker Destination (Coral Red)
        const destCoords = resolveCoords(destObj);
        if (destCoords) {
            points.push(destCoords);
            L.circleMarker(destCoords, {
                radius: 9,
                fillColor: '#C53030',
                color: '#ffffff',
                weight: 2.5,
                fillOpacity: 1
            }).addTo(map).bindPopup(`<strong>Destination:</strong><br>${destObj.name}`);
        }

        // 4. Garis Rute Penghubung & Auto-Fit Zoom
        if (points.length > 1) {
            const polyline = L.polyline(points, {
                color: '#2B6CB0',
                weight: 3,
                opacity: 0.85,
                dashArray: '8, 8'
            }).addTo(map);

            map.fitBounds(polyline.getBounds(), { padding: [50, 50], maxZoom: 6 });
        } else if (points.length === 1) {
            map.setView(points[0], 5);
        }

        if (latestMarker) {
            latestMarker.openPopup();
        }

        setTimeout(() => map.invalidateSize(), 200);
    });
    </script>

</body>
</html>