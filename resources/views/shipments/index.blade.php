<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipment Management — CargoTrace Maritime Visibility</title>

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

        .hero-title {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.5px;
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

        /* ================= 4 MINI KPI CARDS ================= */
        .summary-strip {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: var(--glass-bg);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            padding: 16px 20px;
            box-shadow: 0 6px 20px rgba(30, 58, 95, 0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: transform 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            background: var(--glass-strong);
        }

        .stat-info span {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 4px;
        }

        .stat-info strong {
            font-size: 24px;
            font-weight: 800;
            color: var(--navy-deep);
            letter-spacing: -0.5px;
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(43, 108, 176, 0.10);
            color: var(--ocean-blue);
        }

        .stat-icon svg {
            width: 21px;
            height: 21px;
            stroke: currentColor;
            stroke-width: 1.9;
            fill: none;
        }

        .stat-card.amber .stat-icon { background: var(--amber-bg); color: var(--amber-warn); }
        .stat-card.teal .stat-icon { background: var(--teal-bg); color: var(--teal-pos); }
        .stat-card.navy .stat-icon { background: rgba(19, 42, 70, 0.09); color: var(--navy-deep); }

        /* Alert Flash */
        .alert-success {
            background: var(--teal-bg);
            color: var(--teal-pos);
            border: 1px solid rgba(29, 122, 104, 0.25);
            padding: 12px 18px;
            border-radius: 12px;
            font-size: 13.5px;
            font-weight: 600;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Glass Panel */
        .glass-panel {
            background: var(--glass-bg);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid var(--glass-border);
            border-radius: 18px;
            padding: 22px 24px;
            box-shadow: 0 8px 24px rgba(30, 58, 95, 0.06);
        }

        .table-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 18px;
            padding-bottom: 16px;
            border-bottom: 1px solid rgba(30, 58, 95, 0.08);
        }

        .toolbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .search-box {
            display: flex;
            align-items: center;
            gap: 9px;
            background: #ffffff;
            border: 1px solid rgba(30, 58, 95, 0.14);
            padding: 8px 14px;
            border-radius: 11px;
            box-shadow: 0 2px 8px rgba(30, 58, 95, 0.04);
        }

        .search-box svg {
            width: 15px;
            height: 15px;
            stroke: var(--text-muted);
            stroke-width: 2;
            fill: none;
            flex-shrink: 0;
        }

        .search-box input {
            border: none;
            background: transparent;
            outline: none;
            font-size: 13px;
            color: var(--text-dark);
            width: 230px;
        }

        .filter-pills {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .filter-btn {
            border: 1px solid rgba(30, 58, 95, 0.12);
            background: rgba(255, 255, 255, 0.85);
            color: var(--text-muted);
            padding: 7px 14px;
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

        /* Table */
        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        th, td {
            padding: 14px 12px;
            text-align: left;
            border-bottom: 1px solid rgba(30, 58, 95, 0.08);
            vertical-align: middle;
        }

        th {
            background: rgba(226, 238, 248, 0.92);
            color: var(--navy-primary);
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        th:first-child { border-top-left-radius: 10px; }
        th:last-child { border-top-right-radius: 10px; }

        tbody tr {
            transition: background 0.15s ease;
        }

        tbody tr:hover {
            background: rgba(255, 255, 255, 0.92);
        }

        .shp-pill {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: rgba(43, 108, 176, 0.09);
            border: 1px solid rgba(43, 108, 176, 0.20);
            padding: 5px 10px;
            border-radius: 8px;
            font-weight: 800;
            color: var(--ocean-blue);
            text-decoration: none;
            white-space: nowrap;
            transition: all 0.15s ease;
        }

        .shp-pill svg {
            width: 14px;
            height: 14px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
        }

        .shp-pill:hover {
            background: var(--ocean-blue);
            color: #ffffff;
        }

        .carrier-sub {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 3px;
        }

        .carrier-sub svg {
            width: 13px;
            height: 13px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
        }

        .route-card {
            display: flex;
            flex-direction: column;
            gap: 3px;
            font-size: 12.5px;
        }

        .route-point {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .dot-origin {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--teal-pos);
            flex-shrink: 0;
        }

        .dot-dest {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--cerulean);
            flex-shrink: 0;
        }

        .route-origin {
            font-weight: 700;
            color: var(--navy-deep);
        }

        .route-dest {
            color: var(--text-muted);
            font-weight: 500;
        }

        .cargo-tag {
            display: inline-block;
            background: rgba(241, 245, 249, 0.95);
            border: 1px solid rgba(30, 58, 95, 0.10);
            padding: 4px 9px;
            border-radius: 7px;
            font-size: 12px;
            font-weight: 600;
            color: var(--navy-primary);
        }

        .date-cell {
            font-size: 12px;
            color: var(--text-muted);
            white-space: nowrap;
            line-height: 1.5;
        }

        /* Status + Mini Progress Bar */
        .status-wrap {
            display: flex;
            flex-direction: column;
            gap: 6px;
            min-width: 115px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 10.5px;
            font-weight: 800;
            letter-spacing: 0.3px;
            white-space: nowrap;
            width: fit-content;
        }

        .badge-CREATED { background: rgba(100, 116, 139, 0.14); color: #334155; }
        .badge-IN_TRANSIT { background: var(--amber-bg); color: var(--amber-warn); }
        .badge-AT_PORT { background: rgba(74, 144, 226, 0.16); color: var(--ocean-blue); }
        .badge-CUSTOMS_HOLD { background: var(--coral-bg); color: var(--coral-err); }
        .badge-DELIVERED { background: var(--teal-bg); color: var(--teal-pos); }
        .badge-DELAYED { background: var(--coral-bg); color: var(--coral-err); }
        .badge-CANCELLED { background: rgba(148, 163, 184, 0.20); color: #475569; }

        .mini-progress {
            width: 100%;
            height: 5px;
            background: rgba(30, 58, 95, 0.10);
            border-radius: 999px;
            overflow: hidden;
        }

        .mini-progress-fill {
            height: 100%;
            border-radius: 999px;
            background: var(--cerulean);
        }

        .fill-CREATED { width: 20%; background: #64748B; }
        .fill-IN_TRANSIT { width: 65%; background: #D97706; }
        .fill-AT_PORT { width: 80%; background: #2B6CB0; }
        .fill-DELIVERED { width: 100%; background: #1D7A68; }
        .fill-DELAYED { width: 55%; background: #C53030; }

        /* Action Buttons */
        .action-group {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: nowrap;
        }

        .btn-act {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            padding: 6px 11px;
            border-radius: 8px;
            font-size: 11.5px;
            font-weight: 700;
            text-decoration: none;
            border: 1px solid transparent;
            cursor: pointer;
            transition: all 0.18s ease;
            white-space: nowrap;
        }

        .btn-act svg {
            width: 13px;
            height: 13px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
        }

        .btn-act-detail {
            background: rgba(43, 108, 176, 0.12);
            color: var(--ocean-blue);
            border-color: rgba(43, 108, 176, 0.22);
        }
        .btn-act-detail:hover {
            background: var(--ocean-blue);
            color: #ffffff;
        }

        .btn-act-edit {
            background: var(--amber-bg);
            color: var(--amber-warn);
            border-color: rgba(183, 121, 31, 0.24);
        }
        .btn-act-edit:hover {
            background: #D97706;
            color: #ffffff;
        }

        .btn-act-delete {
            background: var(--coral-bg);
            color: var(--coral-err);
            border-color: rgba(197, 48, 48, 0.22);
        }
        .btn-act-delete:hover {
            background: var(--coral-err);
            color: #ffffff;
        }

        .pagination-wrap {
            margin-top: 18px;
        }

        @media (max-width: 1100px) {
            .summary-strip { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 860px) {
            body { flex-direction: column; }
            .sidebar { width: 100%; height: auto; position: static; }
            .summary-strip { grid-template-columns: 1fr; }
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
                        <circle cx="12" cy="5" r="3"/><line x1="12" y1="22" x2="12" y2="8"/><path d="M5 12H2a10 10 0 0 0 20 0h-3"/>
                    </svg>
                    Maritime Freight Operations
                </div>
                <h1 class="hero-title">Shipment Management</h1>
                <p class="hero-desc">Pemantauan manifest kargo, koridor rute pelabuhan, dan status jadwal pelayaran terkini</p>
            </div>

            <div class="hero-actions">
                <a href="{{ route('dashboard') }}" class="btn-hero-light">
                    ← Kembali ke Dashboard
                </a>

                @if(!auth()->user()->isCustomer())
                    <a href="{{ route('shipments.create') }}" class="btn-hero-cta">
                        <span>+</span> Add Shipment
                    </a>
                @endif
            </div>
        </div>

        <!-- 4 Mini KPI Summary Cards -->
        @php
            $pageTotal = $shipments->total();
            $pageTransit = $shipments->where('current_status', 'IN_TRANSIT')->count();
            $pageDelivered = $shipments->where('current_status', 'DELIVERED')->count();
            $pageWeight = $shipments->sum('weight');
        @endphp
        <div class="summary-strip">
            <div class="stat-card">
                <div class="stat-info">
                    <span>Total Manifest</span>
                    <strong>{{ $pageTotal }} Shipments</strong>
                </div>
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
                </div>
            </div>

            <div class="stat-card amber">
                <div class="stat-info">
                    <span>Sedang Berlayar</span>
                    <strong>{{ $pageTransit }} In Transit</strong>
                </div>
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/></svg>
                </div>
            </div>

            <div class="stat-card teal">
                <div class="stat-info">
                    <span>Tiba di Tujuan</span>
                    <strong>{{ $pageDelivered }} Delivered</strong>
                </div>
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </div>
            </div>

            <div class="stat-card navy">
                <div class="stat-info">
                    <span>Total Muatan Kargo</span>
                    <strong>{{ number_format((float) $pageWeight, 0) }} kg</strong>
                </div>
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24"><line x1="12" y1="20" x2="12" y2="10"/><line x1="18" y1="20" x2="18" y2="4"/><line x1="6" y1="20" x2="6" y2="16"/></svg>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert-success">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="20 6 9 17 4 12"/></svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Glass Table Panel -->
        <div class="glass-panel">
            <div class="table-toolbar">
                <div class="toolbar-left">
                    <div class="search-box">
                        <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" id="shipmentSearch" placeholder="Cari No. Shipment, Customer, Rute...">
                    </div>
                </div>

                <div class="filter-pills">
                    <button type="button" class="filter-btn active" data-filter="ALL">Semua ({{ $shipments->count() }})</button>
                    <button type="button" class="filter-btn" data-filter="CREATED">Created</button>
                    <button type="button" class="filter-btn" data-filter="IN_TRANSIT">In Transit</button>
                    <button type="button" class="filter-btn" data-filter="AT_PORT">At Port</button>
                    <button type="button" class="filter-btn" data-filter="DELIVERED">Delivered</button>
                </div>
            </div>

            <div class="table-responsive">
                <table id="shipmentManagementTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Shipment Number</th>
                            <th>Customer & Carrier</th>
                            <th>Koridor Rute (Origin → Dest)</th>
                            <th>Cargo & Berat</th>
                            <th>Jadwal (ETD / ETA)</th>
                            <th>Status & Progres</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($shipments as $index => $shipment)
                            <tr data-status="{{ $shipment->current_status }}">
                                <td><strong>{{ $shipments->firstItem() + $index }}</strong></td>
                                <td>
                                    <a href="{{ route('shipments.show', $shipment->id) }}" class="shp-pill">
                                        <svg viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                                        {{ $shipment->shipment_number }}
                                    </a>
                                </td>
                                <td>
                                    <div style="font-weight: 700; color: var(--navy-deep);">{{ $shipment->customer->name ?? '-' }}</div>
                                    <div class="carrier-sub">
                                        <svg viewBox="0 0 24 24"><circle cx="12" cy="5" r="3"/><line x1="12" y1="22" x2="12" y2="8"/><path d="M5 12H2a10 10 0 0 0 20 0h-3"/></svg>
                                        {{ $shipment->carrier->name ?? '-' }}
                                    </div>
                                </td>
                                <td>
                                    <div class="route-card">
                                        <div class="route-point">
                                            <span class="dot-origin"></span>
                                            <span class="route-origin">{{ $shipment->origin->name ?? $shipment->originLocation->name ?? '-' }}</span>
                                        </div>
                                        <div class="route-point">
                                            <span class="dot-dest"></span>
                                            <span class="route-dest">{{ $shipment->destination->name ?? $shipment->destinationLocation->name ?? '-' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="cargo-tag">{{ $shipment->cargo_type }}</span>
                                    <div style="font-size: 12px; font-weight: 700; color: var(--navy-primary); margin-top: 4px;">
                                        {{ number_format((float) $shipment->weight, 2) }} kg
                                    </div>
                                </td>
                                <td class="date-cell">
                                    <div><strong>ETD:</strong> {{ $shipment->expected_departure ? \Carbon\Carbon::parse($shipment->expected_departure)->format('d-m-Y H:i') : '-' }}</div>
                                    <div><strong>ETA:</strong> {{ $shipment->expected_arrival ? \Carbon\Carbon::parse($shipment->expected_arrival)->format('d-m-Y H:i') : '-' }}</div>
                                </td>
                                <td>
                                    <div class="status-wrap">
                                        <span class="badge badge-{{ $shipment->current_status }}">
                                            ● {{ str_replace('_', ' ', $shipment->current_status) }}
                                        </span>
                                        <div class="mini-progress">
                                            <div class="mini-progress-fill fill-{{ $shipment->current_status }}"></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="action-group">
                                        <a href="{{ route('shipments.show', $shipment->id) }}" class="btn-act btn-act-detail">
                                            <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                            Detail
                                        </a>

                                        @if(!auth()->user()->isCustomer())
                                            <a href="{{ route('shipments.edit', $shipment->id) }}" class="btn-act btn-act-edit">
                                                <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                                Edit
                                            </a>
                                            <form action="{{ route('shipments.destroy', $shipment->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus shipment ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-act btn-act-delete">
                                                    <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="text-align:center; padding: 30px; color: var(--text-muted);">
                                    Belum ada data shipment terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrap">
                {{ $shipments->links() }}
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('shipmentSearch');
            const filterBtns = document.querySelectorAll('.seg-btn, .filter-btn');
            const rows = document.querySelectorAll('#shipmentManagementTable tbody tr[data-status]');
            let currentFilter = 'ALL';

            function filterShipments() {
                const q = (searchInput?.value || '').toLowerCase();
                rows.forEach(row => {
                    const text = row.innerText.toLowerCase();
                    const status = row.getAttribute('data-status');
                    const matchText = text.includes(q);
                    const matchStatus = (currentFilter === 'ALL') || (status === currentFilter);
                    row.style.display = (matchText && matchStatus) ? '' : 'none';
                });
            }

            if (searchInput) searchInput.addEventListener('input', filterShipments);

            filterBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    filterBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    currentFilter = this.getAttribute('data-filter');
                    filterShipments();
                });
            });
        });
    </script>
</body>
</html>