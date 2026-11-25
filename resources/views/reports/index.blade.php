<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipment Reports — CargoTrace Maritime Visibility</title>

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
            --indigo-soft: #4338CA;
            --indigo-bg: #E0E7FF;
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
            padding: 10px 15px;
            background: rgba(255, 255, 255, 0.14);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.26);
            text-decoration: none;
            border-radius: 11px;
            font-size: 13px;
            font-weight: 700;
            backdrop-filter: blur(8px);
            transition: all 0.2s ease;
        }

        .btn-hero-light:hover {
            background: rgba(255, 255, 255, 0.24);
        }

        .btn-export-pdf {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 10px 16px;
            background: linear-gradient(135deg, #DC2626, #B91C1C);
            color: #ffffff;
            text-decoration: none;
            border-radius: 11px;
            font-size: 13px;
            font-weight: 700;
            box-shadow: 0 5px 15px rgba(220, 38, 38, 0.28);
            transition: all 0.2s ease;
        }

        .btn-export-pdf:hover {
            transform: translateY(-1px);
            box-shadow: 0 7px 19px rgba(220, 38, 38, 0.36);
        }

        .btn-export-excel {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 10px 16px;
            background: linear-gradient(135deg, #16A34A, var(--teal-pos));
            color: #ffffff;
            text-decoration: none;
            border-radius: 11px;
            font-size: 13px;
            font-weight: 700;
            box-shadow: 0 5px 15px rgba(22, 163, 74, 0.28);
            transition: all 0.2s ease;
        }

        .btn-export-excel:hover {
            transform: translateY(-1px);
            box-shadow: 0 7px 19px rgba(22, 163, 74, 0.36);
        }

        /* ================= 5-CARD KPI STRIP ================= */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }

        .kpi-card {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            padding: 16px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 6px 20px rgba(30, 58, 95, 0.05);
            position: relative;
            overflow: hidden;
        }

        .kpi-card::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: var(--ocean-blue);
        }

        .kpi-card.k-created::before   { background: var(--cerulean); }
        .kpi-card.k-transit::before   { background: var(--amber-warn); }
        .kpi-card.k-delivered::before { background: var(--teal-pos); }
        .kpi-card.k-delayed::before   { background: var(--coral-err); }

        .kpi-lbl {
            font-size: 11px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.4px;
            margin-bottom: 5px;
        }

        .kpi-val {
            font-size: 24px;
            font-weight: 800;
            color: var(--navy-deep);
            line-height: 1.1;
        }

        .kpi-icon {
            width: 38px;
            height: 38px;
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .kpi-icon svg {
            width: 18px;
            height: 18px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
        }

        /* ================= GLASS CONTENT CARD ================= */
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: 18px;
            padding: 24px 26px;
            box-shadow: 0 8px 28px rgba(30, 58, 95, 0.06);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 16px;
        }

        .section-title-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-icon {
            width: 33px;
            height: 33px;
            border-radius: 9px;
            background: rgba(43, 108, 176, 0.11);
            color: var(--ocean-blue);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .section-icon svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
        }

        .section-title {
            font-size: 15.5px;
            font-weight: 800;
            color: var(--navy-deep);
        }

        .cargo-summary-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 13px;
            border-radius: 999px;
            background: rgba(43, 108, 176, 0.10);
            border: 1px solid rgba(43, 108, 176, 0.18);
            font-size: 12px;
            font-weight: 700;
            color: var(--navy-primary);
        }

        /* Filter Bar */
        .filter-box {
            background: rgba(255, 255, 255, 0.72);
            border: 1px solid rgba(30, 58, 95, 0.08);
            border-radius: 14px;
            padding: 16px 18px;
            margin-bottom: 24px;
        }

        .filter-form {
            display: grid;
            grid-template-columns: 1.3fr 1fr 1fr auto;
            gap: 14px;
            align-items: end;
        }

        .f-group label {
            display: block;
            font-size: 11.5px;
            font-weight: 700;
            color: var(--navy-primary);
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .f-group input,
        .f-group select {
            width: 100%;
            padding: 10px 13px;
            border: 1px solid rgba(30, 58, 95, 0.16);
            border-radius: 10px;
            font-size: 13px;
            color: var(--text-dark);
            background: var(--glass-strong);
            transition: all 0.18s ease;
        }

        .f-group input:focus,
        .f-group select:focus {
            outline: none;
            border-color: var(--ocean-blue);
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(43, 108, 176, 0.14);
        }

        .f-actions {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .btn-filter {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 18px;
            background: linear-gradient(135deg, var(--navy-primary), var(--ocean-blue));
            color: #ffffff;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(43, 108, 176, 0.24);
            transition: all 0.18s ease;
        }

        .btn-filter:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(43, 108, 176, 0.32);
        }

        .btn-reset {
            display: inline-flex;
            align-items: center;
            padding: 10px 15px;
            background: rgba(255, 255, 255, 0.92);
            color: var(--text-muted);
            border: 1px solid rgba(30, 58, 95, 0.15);
            border-radius: 10px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            transition: all 0.18s ease;
        }

        .btn-reset:hover {
            background: #ffffff;
            color: var(--navy-primary);
            border-color: var(--navy-primary);
        }

        /* Table */
        .table-wrap {
            overflow-x: auto;
            border-radius: 12px;
            border: 1px solid rgba(30, 58, 95, 0.08);
            background: rgba(255, 255, 255, 0.74);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: rgba(235, 244, 252, 0.94);
            color: var(--navy-primary);
            font-size: 11.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 13px 15px;
            text-align: left;
            border-bottom: 1px solid rgba(30, 58, 95, 0.10);
            white-space: nowrap;
        }

        td {
            padding: 14px 15px;
            border-bottom: 1px solid rgba(30, 58, 95, 0.06);
            text-align: left;
            font-size: 13.5px;
            color: var(--text-dark);
            vertical-align: middle;
        }

        tbody tr:hover {
            background: rgba(255, 255, 255, 0.96);
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .shp-link {
            font-weight: 800;
            color: var(--navy-deep);
            text-decoration: none;
            white-space: nowrap;
        }

        .shp-link:hover {
            color: var(--ocean-blue);
            text-decoration: underline;
        }

        .weight-val {
            font-weight: 700;
            color: var(--navy-primary);
            white-space: nowrap;
        }

        .time-cell {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text-muted);
            white-space: nowrap;
        }

        /* Status Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 11px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.3px;
            white-space: nowrap;
            background: rgba(82, 109, 130, 0.12);
            color: var(--text-muted);
        }

        .created {
            background: rgba(43, 108, 176, 0.13);
            color: var(--ocean-blue);
        }

        .at_port {
            background: var(--indigo-bg);
            color: var(--indigo-soft);
        }

        .in_transit {
            background: var(--amber-bg);
            color: var(--amber-warn);
        }

        .delivered {
            background: var(--teal-bg);
            color: var(--teal-pos);
        }

        .delayed {
            background: var(--coral-bg);
            color: var(--coral-err);
        }

        .pagination {
            margin-top: 20px;
        }

        @media (max-width: 1180px) {
            .kpi-grid { grid-template-columns: repeat(3, 1fr); }
            .filter-form { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 860px) {
            body { flex-direction: column; }
            .sidebar { width: 100%; height: auto; position: static; }
            .kpi-grid { grid-template-columns: 1fr; }
            .filter-form { grid-template-columns: 1fr; }
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
                <a href="{{ route('exceptions.index') }}" class="nav-link">
                    <svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    Exceptions
                </a>
                <a href="{{ route('reports.index') }}" class="nav-link active">
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
        <!-- Maritime Hero Banner -->
        <div class="hero-banner">
            <div>
                <div class="hero-badge">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>
                    </svg>
                    Maritime Manifest & Analytics Report
                </div>
                <h1 class="hero-title">Shipment Reports</h1>
                <p class="hero-desc">Laporan dan rekapitulasi pengiriman barang, tonase kargo, serta ekspor dokumen PDF dan Excel</p>
            </div>

            <div class="hero-actions">
                <a href="{{ route('dashboard') }}" class="btn-hero-light">
                    ← Dashboard
                </a>

                <a href="{{ route('reports.exportPdf', request()->query()) }}" class="btn-export-pdf">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><polyline points="9 15 12 18 15 15"/>
                    </svg>
                    Export PDF
                </a>

                <a href="{{ route('reports.exportExcel', request()->query()) }}" class="btn-export-excel">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                        <rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="3" y1="15" x2="21" y2="15"/><line x1="9" y1="9" x2="9" y2="21"/>
                    </svg>
                    Export Excel
                </a>
            </div>
        </div>

        <!-- 5-Card KPI Strip -->
        <div class="kpi-grid">
            <div class="kpi-card">
                <div>
                    <div class="kpi-lbl">Total Shipments</div>
                    <div class="kpi-val">{{ $totalShipments }}</div>
                </div>
                <div class="kpi-icon" style="background: rgba(43, 108, 176, 0.12); color: var(--ocean-blue);">
                    <svg viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                </div>
            </div>

            <div class="kpi-card k-created">
                <div>
                    <div class="kpi-lbl">Created</div>
                    <div class="kpi-val" style="color: var(--ocean-blue);">{{ $created }}</div>
                </div>
                <div class="kpi-icon" style="background: rgba(74, 144, 226, 0.14); color: var(--cerulean);">
                    <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                </div>
            </div>

            <div class="kpi-card k-transit">
                <div>
                    <div class="kpi-lbl">In Transit</div>
                    <div class="kpi-val" style="color: var(--amber-warn);">{{ $inTransit }}</div>
                </div>
                <div class="kpi-icon" style="background: var(--amber-bg); color: var(--amber-warn);">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="5" r="3"/><line x1="12" y1="22" x2="12" y2="8"/><path d="M5 12H2a10 10 0 0 0 20 0h-3"/></svg>
                </div>
            </div>

            <div class="kpi-card k-delivered">
                <div>
                    <div class="kpi-lbl">Delivered</div>
                    <div class="kpi-val" style="color: var(--teal-pos);">{{ $delivered }}</div>
                </div>
                <div class="kpi-icon" style="background: var(--teal-bg); color: var(--teal-pos);">
                    <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
            </div>

            <div class="kpi-card k-delayed">
                <div>
                    <div class="kpi-lbl">Delayed</div>
                    <div class="kpi-val" style="color: var(--coral-err);">{{ $delayed }}</div>
                </div>
                <div class="kpi-icon" style="background: var(--coral-bg); color: var(--coral-err);">
                    <svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                </div>
            </div>
        </div>

        <!-- Filter & Data Table Glass Card -->
        <div class="glass-card">
            <div class="section-header">
                <div class="section-title-wrap">
                    <div class="section-icon">
                        <svg viewBox="0 0 24 24"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                    </div>
                    <h2 class="section-title">Filter Laporan & Rekapitulasi Pengiriman</h2>
                </div>

                <div class="cargo-summary-pill">
                    Total Berat Halaman Ini: {{ number_format($shipments->sum('weight'), 2) }} kg
                </div>
            </div>

            <div class="filter-box">
                <form action="{{ route('reports.index') }}" method="GET" class="filter-form">
                    <div class="f-group">
                        <label>Status Pengiriman</label>
                        <select name="status">
                            <option value="">Semua Status</option>
                            @foreach([
                                'CREATED',
                                'AT_PORT',
                                'IN_TRANSIT',
                                'DELIVERED',
                                'DELAYED'
                            ] as $status)
                                <option value="{{ $status }}"
                                    {{ request('status') == $status ? 'selected' : '' }}>
                                    {{ str_replace('_', ' ', $status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="f-group">
                        <label>Dari Tanggal</label>
                        <input type="date"
                               name="start_date"
                               value="{{ request('start_date') }}">
                    </div>

                    <div class="f-group">
                        <label>Sampai Tanggal</label>
                        <input type="date"
                               name="end_date"
                               value="{{ request('end_date') }}">
                    </div>

                    <div class="f-actions">
                        <button type="submit" class="btn-filter">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
                            </svg>
                            Filter
                        </button>

                        <a href="{{ route('reports.index') }}" class="btn-reset">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <div class="section-header" style="margin-bottom: 12px;">
                <div class="section-title-wrap">
                    <div class="section-icon">
                        <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
                    </div>
                    <h2 class="section-title">Data Pengiriman</h2>
                </div>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Shipment Number</th>
                            <th>Cargo Type</th>
                            <th>Weight (kg)</th>
                            <th>Status</th>
                            <th>Expected Arrival</th>
                            <th>Tanggal Dibuat</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($shipments as $shipment)
                            <tr>
                                <td style="font-weight:700; color:var(--text-muted);">
                                    {{ (method_exists($shipments, 'firstItem') && $shipments->firstItem() ? $shipments->firstItem() : 1) + $loop->index }}
                                </td>

                                <td>
                                    <a href="{{ route('shipments.show', $shipment->id) }}" class="shp-link">
                                        {{ $shipment->shipment_number }}
                                    </a>
                                </td>

                                <td>
                                    {{ $shipment->cargo_type }}
                                </td>

                                <td class="weight-val">
                                    {{ $shipment->weight ?? '-' }}
                                </td>

                                <td>
                                    <span class="badge {{ strtolower($shipment->current_status) }}">
                                        ● {{ str_replace('_', ' ', $shipment->current_status) }}
                                    </span>
                                </td>

                                <td class="time-cell">
                                    {{ $shipment->expected_arrival
                                        ? \Carbon\Carbon::parse($shipment->expected_arrival)->format('d-m-Y H:i')
                                        : '-' }}
                                </td>

                                <td class="time-cell">
                                    {{ $shipment->created_at?->format('d-m-Y') ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align:center; padding:36px; color:var(--text-muted);">
                                    Belum ada data pengiriman.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($shipments, 'links'))
                <div class="pagination">
                    {{ $shipments->links() }}
                </div>
            @endif
        </div>
    </main>

</body>
</html>