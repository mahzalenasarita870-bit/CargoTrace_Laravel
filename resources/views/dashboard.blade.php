<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — CargoTrace Maritime Visibility</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Chart.js & Leaflet.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

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
            --glass-bg: rgba(255, 255, 255, 0.82);
            --glass-strong: rgba(255, 255, 255, 0.94);
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

        /* ================= SIDEBAR (FROSTED MARITIME GLASS) ================= */
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
            gap: 12px;
            flex-wrap: wrap;
            z-index: 2;
        }

        .search-box {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.24);
            backdrop-filter: blur(10px);
            padding: 9px 14px;
            border-radius: 12px;
        }

        .search-box svg {
            width: 15px;
            height: 15px;
            stroke: #CBD5E1;
            stroke-width: 2;
            fill: none;
            flex-shrink: 0;
        }

        .search-box input {
            border: none;
            background: transparent;
            outline: none;
            font-size: 13px;
            color: #ffffff;
            width: 185px;
        }

        .search-box input::placeholder {
            color: #CBD5E1;
        }

        .user-chip {
            display: flex;
            align-items: center;
            gap: 9px;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.24);
            padding: 5px 14px 5px 6px;
            border-radius: 999px;
            backdrop-filter: blur(8px);
        }

        .user-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #ffffff;
            color: var(--navy-deep);
            font-weight: 800;
            font-size: 11.5px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-name {
            font-size: 12.5px;
            font-weight: 700;
            color: #ffffff;
        }

        .btn-hero-cta {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            background: #ffffff;
            color: var(--navy-deep);
            text-decoration: none;
            border-radius: 12px;
            font-size: 13.5px;
            font-weight: 800;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.16);
            transition: all 0.2s ease;
        }

        .btn-hero-cta:hover {
            transform: translateY(-2px);
            background: #F0F9FF;
        }

        /* ================= 5 KPI SUMMARY CARDS ================= */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 16px;
            margin-bottom: 22px;
        }

        .kpi-card {
            background: var(--glass-bg);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            padding: 18px 20px;
            box-shadow: 0 8px 24px rgba(30, 58, 95, 0.06);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .kpi-card:hover {
            transform: translateY(-3px);
            background: var(--glass-strong);
            box-shadow: 0 12px 28px rgba(30, 58, 95, 0.10);
        }

        .kpi-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .kpi-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-muted);
        }

        .kpi-icon-box {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(43, 108, 176, 0.11);
            color: var(--ocean-blue);
        }

        .kpi-icon-box svg {
            width: 18px;
            height: 18px;
            stroke: currentColor;
            stroke-width: 1.9;
            fill: none;
        }

        .kpi-card.teal .kpi-icon-box { background: var(--teal-bg); color: var(--teal-pos); }
        .kpi-card.amber .kpi-icon-box { background: var(--amber-bg); color: var(--amber-warn); }
        .kpi-card.coral .kpi-icon-box { background: var(--coral-bg); color: var(--coral-err); }

        .kpi-value-row {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            gap: 8px;
            margin-bottom: 10px;
        }

        .kpi-value {
            font-size: 30px;
            font-weight: 800;
            letter-spacing: -0.8px;
            color: var(--navy-deep);
        }

        .kpi-card.teal .kpi-value { color: var(--teal-pos); }
        .kpi-card.amber .kpi-value { color: var(--amber-warn); }
        .kpi-card.coral .kpi-value { color: var(--coral-err); }

        .kpi-trend {
            font-size: 11px;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 999px;
            background: rgba(43, 108, 176, 0.10);
            color: var(--ocean-blue);
        }

        .kpi-card.teal .kpi-trend { background: var(--teal-bg); color: var(--teal-pos); }
        .kpi-card.amber .kpi-trend { background: var(--amber-bg); color: var(--amber-warn); }
        .kpi-card.coral .kpi-trend { background: var(--coral-bg); color: var(--coral-err); }

        .kpi-foot {
            font-size: 11.5px;
            color: #6B8299;
            padding-top: 8px;
            border-top: 1px solid rgba(30, 58, 95, 0.06);
        }

        /* ================= ANALYTICS 3-COLUMN GRID ================= */
        .analytics-grid {
            display: grid;
            grid-template-columns: 1.15fr 1fr 1.15fr;
            gap: 18px;
            margin-bottom: 22px;
        }

        .glass-panel {
            background: var(--glass-bg);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid var(--glass-border);
            border-radius: 18px;
            padding: 20px 22px;
            box-shadow: 0 8px 24px rgba(30, 58, 95, 0.06);
        }

        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 14px;
            gap: 10px;
        }

        .panel-title {
            font-size: 15.5px;
            font-weight: 700;
            color: var(--navy-deep);
        }

        .panel-subtitle {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .panel-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.85);
            color: var(--ocean-blue);
            border: 1px solid rgba(43, 108, 176, 0.16);
            white-space: nowrap;
        }

        .live-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--teal-pos);
        }

        .chart-wrap {
            position: relative;
            height: 225px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .donut-center-text {
            position: absolute;
            top: 44%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            pointer-events: none;
        }

        .donut-center-val {
            font-size: 24px;
            font-weight: 800;
            color: var(--navy-deep);
            line-height: 1.1;
        }

        .donut-center-lbl {
            font-size: 10.5px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        #dashboardMap {
            height: 225px;
            width: 100%;
            border-radius: 12px;
            border: 1px solid rgba(30, 58, 95, 0.12);
            z-index: 1;
        }

        #dashboardMap .leaflet-tile-pane {
            filter: saturate(0.85) hue-rotate(-8deg) brightness(1.02);
        }

        /* ================= RECENT SHIPMENTS TABLE ================= */
        .table-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 16px;
        }

        .filter-pills {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .filter-btn {
            border: 1px solid rgba(30, 58, 95, 0.12);
            background: rgba(255, 255, 255, 0.75);
            color: var(--text-muted);
            padding: 6px 13px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .filter-btn:hover, .filter-btn.active {
            background: var(--navy-primary);
            color: #ffffff;
            border-color: var(--navy-primary);
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13.5px;
        }

        th, td {
            padding: 13px 14px;
            text-align: left;
            border-bottom: 1px solid rgba(30, 58, 95, 0.08);
        }

        th {
            background: rgba(226, 238, 248, 0.92);
            color: var(--navy-primary);
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        th:first-child { border-top-left-radius: 10px; }
        th:last-child { border-top-right-radius: 10px; }

        tbody tr {
            transition: background 0.15s ease;
        }

        tbody tr:hover {
            background: rgba(255, 255, 255, 0.90);
        }

        .shp-code {
            font-weight: 800;
            color: var(--ocean-blue);
        }

        .route-cell {
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
            color: var(--navy-deep);
        }

        .route-arrow {
            color: var(--cerulean);
            font-weight: 800;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 11px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        .badge-ocean { background: rgba(74, 144, 226, 0.16); color: var(--ocean-blue); }
        .badge-teal { background: var(--teal-bg); color: var(--teal-pos); }
        .badge-amber { background: var(--amber-bg); color: var(--amber-warn); }
        .badge-coral { background: var(--coral-bg); color: var(--coral-err); }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 13px;
            background: rgba(43, 108, 176, 0.12);
            color: var(--ocean-blue);
            border: 1px solid rgba(43, 108, 176, 0.22);
            text-decoration: none;
            border-radius: 9px;
            font-size: 12px;
            font-weight: 700;
            transition: all 0.2s ease;
        }

        .btn-action svg {
            width: 13px;
            height: 13px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
        }

        .btn-action:hover {
            background: var(--ocean-blue);
            color: #ffffff;
        }

        .dashboard-footer {
            margin-top: 18px;
            text-align: center;
            font-size: 12px;
            color: var(--text-muted);
        }

        @media (max-width: 1280px) {
            .kpi-grid { grid-template-columns: repeat(3, 1fr); }
            .analytics-grid { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 860px) {
            body { flex-direction: column; }
            .sidebar { width: 100%; height: auto; position: static; }
            .kpi-grid { grid-template-columns: repeat(2, 1fr); }
            .analytics-grid { grid-template-columns: 1fr; }
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
            <a href="{{ route('dashboard') }}" class="nav-link active">
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

    <!-- Main Content Area -->
    <main class="main">
        <!-- Maritime Hero Header -->
        <div class="hero-banner">
            <div>
                <div class="hero-badge">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                        <circle cx="12" cy="5" r="3"/><line x1="12" y1="22" x2="12" y2="8"/><path d="M5 12H2a10 10 0 0 0 20 0h-3"/>
                    </svg>
                    Maritime Operations Center
                </div>
                <h1 class="hero-title">Maritime Traffic & Cargo Dashboard</h1>
                <p class="hero-desc">Selamat datang kembali, <strong>{{ auth()->user()->name }}</strong> • Pemantauan kargo & rute pelabuhan secara real-time</p>
            </div>

            <div class="hero-actions">
                <div class="search-box">
                    <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" id="quickSearchInput" placeholder="Cari No. Shipment / Rute...">
                </div>

                <div class="user-chip">
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
                    </div>
                    <span class="user-name">{{ auth()->user()->name }}</span>
                </div>

                @if(auth()->user()->hasRole(['admin', 'operator']))
                    <a href="{{ route('shipments.create') }}" class="btn-hero-cta">
                        <span>+</span> Buat Shipment
                    </a>
                @endif
            </div>
        </div>

        <!-- 5 KPI Summary Cards -->
        <div class="kpi-grid">
            <div class="kpi-card">
                <div class="kpi-top">
                    <span class="kpi-label">Total Shipments</span>
                    <div class="kpi-icon-box">
                        <svg viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
                    </div>
                </div>
                <div class="kpi-value-row">
                    <span class="kpi-value">{{ $totalShipments }}</span>
                    <span class="kpi-trend">Aktif</span>
                </div>
                <div class="kpi-foot">Seluruh kargo terdaftar di sistem</div>
            </div>

            <div class="kpi-card">
                <div class="kpi-top">
                    <span class="kpi-label">In Transit</span>
                    <div class="kpi-icon-box">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/></svg>
                    </div>
                </div>
                <div class="kpi-value-row">
                    <span class="kpi-value">{{ $inTransit }}</span>
                    <span class="kpi-trend">Berlayar</span>
                </div>
                <div class="kpi-foot">Sedang dalam rute pengiriman</div>
            </div>

            <div class="kpi-card teal">
                <div class="kpi-top">
                    <span class="kpi-label">Delivered</span>
                    <div class="kpi-icon-box">
                        <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    </div>
                </div>
                <div class="kpi-value-row">
                    <span class="kpi-value">{{ $delivered }}</span>
                    <span class="kpi-trend">Selesai</span>
                </div>
                <div class="kpi-foot">Telah tiba di pelabuhan tujuan</div>
            </div>

            <div class="kpi-card amber">
                <div class="kpi-top">
                    <span class="kpi-label">Delayed Shipments</span>
                    <div class="kpi-icon-box">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                </div>
                <div class="kpi-value-row">
                    <span class="kpi-value">{{ $delayed }}</span>
                    <span class="kpi-trend">{{ $delayRate }}%</span>
                </div>
                <div class="kpi-foot">Rasio keterlambatan jadwal</div>
            </div>

            <div class="kpi-card coral">
                <div class="kpi-top">
                    <span class="kpi-label">Open Exceptions</span>
                    <div class="kpi-icon-box">
                        <svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    </div>
                </div>
                <div class="kpi-value-row">
                    <span class="kpi-value">{{ $openExceptions }}</span>
                    <span class="kpi-trend">{{ $exceptionRate }}%</span>
                </div>
                <div class="kpi-foot">Kendala operasional perlu tindakan</div>
            </div>
        </div>

        <!-- 3-Column Analytics Row -->
        <div class="analytics-grid">
            <!-- Panel 1: Shipments by Status -->
            <div class="glass-panel">
                <div class="panel-header">
                    <div>
                        <div class="panel-title">Shipments by Status</div>
                        <div class="panel-subtitle">Distribusi status operasional terkini</div>
                    </div>
                    <span class="panel-pill">Total: {{ $totalShipments }}</span>
                </div>
                <div class="chart-wrap">
                    <canvas id="statusBarChart"></canvas>
                </div>
            </div>

            <!-- Panel 2: Carrier Share & Delay Overview -->
            <div class="glass-panel">
                <div class="panel-header">
                    <div>
                        <div class="panel-title">Shipments by Carrier</div>
                        <div class="panel-subtitle">Proporsi armada & tingkat delay</div>
                    </div>
                    <span class="panel-pill">Delay {{ $delayRate }}%</span>
                </div>
                <div class="chart-wrap">
                    <canvas id="carrierDonutChart"></canvas>
                    <div class="donut-center-text">
                        <div class="donut-center-val">{{ $delayRate }}%</div>
                        <div class="donut-center-lbl">Delay Rate</div>
                    </div>
                </div>
            </div>

            <!-- Panel 3: Live Shipment Map -->
            <div class="glass-panel">
                <div class="panel-header">
                    <div>
                        <div class="panel-title">Live Shipment Map</div>
                        <div class="panel-subtitle">Sebaran rute pelabuhan aktif</div>
                    </div>
                    <span class="panel-pill">
                        <span class="live-dot"></span> Live GPS
                    </span>
                </div>
                <div id="dashboardMap"></div>
            </div>
        </div>

        <!-- Recent Shipments Table -->
        <div class="glass-panel">
            <div class="table-toolbar">
                <div>
                    <div class="panel-title">Recent Shipments Overview</div>
                    <div class="panel-subtitle">Daftar pengiriman terbaru lengkap dengan pemantauan jadwal</div>
                </div>

                <div class="filter-pills">
                    <button type="button" class="filter-btn active" data-filter="ALL">Semua</button>
                    <button type="button" class="filter-btn" data-filter="IN_TRANSIT">In Transit</button>
                    <button type="button" class="filter-btn" data-filter="DELIVERED">Delivered</button>
                    <button type="button" class="filter-btn" data-filter="DELAYED">Delayed</button>
                </div>
            </div>

            @if($recentShipments->count() > 0)
                <div class="table-responsive">
                    <table id="shipmentsTable">
                        <thead>
                            <tr>
                                <th>Shipment No.</th>
                                <th>Customer</th>
                                <th>Carrier</th>
                                <th>Rute (Origin → Destination)</th>
                                <th>Status</th>
                                <th>Jadwal / ETA</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentShipments as $item)
                                <tr data-status="{{ $item->current_status }}" data-delayed="{{ $item->is_delayed ? '1' : '0' }}">
                                    <td><span class="shp-code">{{ $item->shipment_number }}</span></td>
                                    <td><strong>{{ $item->customer->name ?? '-' }}</strong></td>
                                    <td>{{ $item->carrier->name ?? '-' }}</td>
                                    <td>
                                        <div class="route-cell">
                                            <span>{{ $item->origin->city ?? '-' }}</span>
                                            <span class="route-arrow">→</span>
                                            <span>{{ $item->destination->city ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($item->current_status === 'DELIVERED')
                                            <span class="badge badge-teal">● DELIVERED</span>
                                        @elseif($item->current_status === 'DELAYED')
                                            <span class="badge badge-coral">● DELAYED</span>
                                        @else
                                            <span class="badge badge-ocean">● {{ str_replace('_', ' ', $item->current_status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->is_delayed)
                                            <span class="badge badge-coral">Delayed (+{{ $item->delay_hours }}h)</span>
                                        @else
                                            <span class="badge badge-teal">On Schedule</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('shipments.show', $item->id) }}" class="btn-action">
                                            <svg viewBox="0 0 24 24"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"/><line x1="8" y1="2" x2="8" y2="18"/><line x1="16" y1="6" x2="16" y2="22"/></svg>
                                            Detail & Peta
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p style="color: var(--text-muted); font-size: 13.5px; padding: 14px 0;">Belum ada data pengiriman yang tersedia.</p>
            @endif
        </div>

        <div class="dashboard-footer">
            CargoTrace Maritime Logistics Visibility Platform • Sinkronisasi Real-Time ({{ now()->format('d M Y, H:i') }} WIB)
        </div>
    </main>

    <!-- Scripts: Chart.js, Leaflet.js Mini Map, Instant Filter & Search -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const maritimePalette = ['#1E3A5F', '#2B6CB0', '#4A90E2', '#7FB3D5', '#2E7D6B', '#E6A23C'];

            // 1. Bar Chart: Shipments by Status
            const statusLabels = @json(array_keys($byStatus)).map(s => s.replace(/_/g, ' '));
            const statusCounts = @json(array_values($byStatus));

            new Chart(document.getElementById('statusBarChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: statusLabels.length ? statusLabels : ['No Data'],
                    datasets: [{
                        label: 'Jumlah Shipment',
                        data: statusCounts.length ? statusCounts : [0],
                        backgroundColor: ['#2B6CB0', '#4A90E2', '#2E7D6B', '#E6A23C', '#7FB3D5'],
                        borderRadius: 8,
                        barThickness: 28
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { color: '#526D82', font: { size: 11, weight: '600' } }
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(30, 58, 95, 0.07)' },
                            ticks: { precision: 0, color: '#526D82', font: { size: 11 } }
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });

            // 2. Doughnut Chart: Shipments by Carrier
            const carrierLabels = @json(array_keys($byCarrier));
            const carrierCounts = @json(array_values($byCarrier));

            new Chart(document.getElementById('carrierDonutChart').getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: carrierLabels.length ? carrierLabels : ['No Data'],
                    datasets: [{
                        data: carrierCounts.length ? carrierCounts : [1],
                        backgroundColor: maritimePalette,
                        borderColor: 'rgba(255, 255, 255, 0.9)',
                        borderWidth: 2,
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '68%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                pointStyle: 'circle',
                                padding: 14,
                                color: '#1E3A5F',
                                font: { size: 11, weight: '600' }
                            }
                        }
                    }
                }
            });

            // 3. Mini Interactive Maritime Map (Leaflet.js + OpenStreetMap)
            const map = L.map('dashboardMap', { zoomControl: false }).setView([1.5, 106.5], 4);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            const routes = [
                { from: [-6.1066, 106.8800], to: [1.2644, 103.8220], label: 'Jakarta → Singapore' },
                { from: [-6.1066, 106.8800], to: [5.5483, 95.3238], label: 'Jakarta → Banda Aceh' },
                { from: [-7.2000, 112.7300], to: [1.2644, 103.8220], label: 'Surabaya → Singapore' }
            ];

            routes.forEach(r => {
                L.circleMarker(r.from, { radius: 5, color: '#1D7A68', fillColor: '#1D7A68', fillOpacity: 0.9 }).addTo(map);
                L.circleMarker(r.to, { radius: 5, color: '#2B6CB0', fillColor: '#4A90E2', fillOpacity: 0.9 }).addTo(map).bindPopup(r.label);
                L.polyline([r.from, r.to], { color: '#2B6CB0', weight: 2, dashArray: '5, 6', opacity: 0.75 }).addTo(map);
            });

            // 4. Instant Search & Filter Pills for Recent Shipments Table
            const searchInput = document.getElementById('quickSearchInput');
            const filterBtns = document.querySelectorAll('.filter-btn');
            const rows = document.querySelectorAll('#shipmentsTable tbody tr');
            let currentFilter = 'ALL';

            function applyTableFilters() {
                const query = (searchInput?.value || '').toLowerCase();
                rows.forEach(row => {
                    const text = row.innerText.toLowerCase();
                    const status = row.getAttribute('data-status');
                    const isDelayed = row.getAttribute('data-delayed') === '1';

                    const matchesSearch = text.includes(query);
                    let matchesStatus = true;

                    if (currentFilter === 'DELAYED') {
                        matchesStatus = isDelayed || status === 'DELAYED';
                    } else if (currentFilter !== 'ALL') {
                        matchesStatus = status === currentFilter;
                    }

                    row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
                });
            }

            if (searchInput) {
                searchInput.addEventListener('input', applyTableFilters);
            }

            filterBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    filterBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    currentFilter = this.getAttribute('data-filter');
                    applyTableFilters();
                });
            });
        });
    </script>
</body>
</html>