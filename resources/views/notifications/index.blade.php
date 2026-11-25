<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Operasional — CargoTrace Maritime Visibility</title>

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

        .hero-right {
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 2;
        }

        .live-pill {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: rgba(29, 122, 104, 0.28);
            border: 1px solid rgba(110, 231, 183, 0.35);
            color: #A7F3D0;
            padding: 8px 14px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 700;
        }

        .pulse-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #34D399;
            box-shadow: 0 0 0 3px rgba(52, 211, 153, 0.25);
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

        /* ================= 2-COLUMN WORKSPACE ================= */
        .notif-layout {
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

        /* Toolbar: Filter Pills + Search */
        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 18px;
            padding-bottom: 14px;
            border-bottom: 1px solid rgba(30, 58, 95, 0.08);
        }

        .filter-group {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 7px;
        }

        .filter-btn {
            padding: 7px 13px;
            border-radius: 999px;
            border: 1px solid rgba(30, 58, 95, 0.14);
            background: rgba(255, 255, 255, 0.78);
            color: var(--text-muted);
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.18s ease;
        }

        .filter-btn:hover {
            background: #ffffff;
            color: var(--navy-primary);
        }

        .filter-btn.active {
            background: linear-gradient(135deg, var(--navy-primary), var(--ocean-blue));
            color: #ffffff;
            border-color: transparent;
            box-shadow: 0 4px 12px rgba(43, 108, 176, 0.24);
        }

        .search-wrap {
            position: relative;
            min-width: 210px;
        }

        .search-wrap svg {
            position: absolute;
            left: 11px;
            top: 50%;
            transform: translateY(-50%);
            width: 14px;
            height: 14px;
            stroke: #7B93A8;
            stroke-width: 2;
            fill: none;
        }

        .search-input {
            width: 100%;
            padding: 8px 12px 8px 32px;
            border-radius: 10px;
            border: 1px solid rgba(30, 58, 95, 0.15);
            background: rgba(255, 255, 255, 0.9);
            font-size: 12.5px;
            color: var(--text-dark);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--ocean-blue);
            background: #ffffff;
        }

        /* Notification Feed Cards (Color-Coded by Severity) */
        .notif-list {
            display: flex;
            flex-direction: column;
            gap: 13px;
        }

        .notif-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            padding: 16px 18px;
            border-radius: 14px;
            border: 1px solid rgba(30, 58, 95, 0.09);
            border-left: 4px solid var(--ocean-blue);
            background: rgba(255, 255, 255, 0.85);
            transition: all 0.2s ease;
        }

        .notif-card:hover {
            background: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(30, 58, 95, 0.08);
        }

        /* Alert / Delay Card Variant */
        .notif-card.type-alert {
            border-left-color: var(--coral-err);
            background: linear-gradient(135deg, rgba(254, 242, 242, 0.88), rgba(255, 255, 255, 0.92));
        }

        /* Delivered / Success Card Variant */
        .notif-card.type-success {
            border-left-color: var(--teal-pos);
            background: linear-gradient(135deg, rgba(240, 253, 250, 0.88), rgba(255, 255, 255, 0.92));
        }

        .notif-card.unread {
            box-shadow: 0 6px 18px rgba(43, 108, 176, 0.12);
        }

        .notif-left {
            display: flex;
            align-items: flex-start;
            gap: 14px;
        }

        .notif-badge-icon {
            width: 38px;
            height: 38px;
            border-radius: 11px;
            background: rgba(43, 108, 176, 0.12);
            color: var(--ocean-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .notif-card.type-alert .notif-badge-icon {
            background: var(--coral-bg);
            color: var(--coral-err);
        }

        .notif-card.type-success .notif-badge-icon {
            background: var(--teal-bg);
            color: var(--teal-pos);
        }

        .notif-badge-icon svg {
            width: 18px;
            height: 18px;
            stroke: currentColor;
            stroke-width: 2.1;
            fill: none;
        }

        .notif-title-row {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 4px;
        }

        .notif-title {
            font-weight: 800;
            font-size: 14.5px;
            color: var(--navy-deep);
        }

        .cat-pill {
            padding: 2px 9px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .cat-pill.alert {
            background: var(--coral-bg);
            color: var(--coral-err);
        }

        .cat-pill.success {
            background: var(--teal-bg);
            color: var(--teal-pos);
        }

        .cat-pill.info {
            background: rgba(43, 108, 176, 0.12);
            color: var(--ocean-blue);
        }

        .new-dot {
            padding: 2px 8px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            background: var(--navy-primary);
            color: #ffffff;
        }

        .notif-body {
            font-size: 13.5px;
            color: var(--text-dark);
            line-height: 1.45;
        }

        .notif-meta {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 7px;
        }

        .shipment-link {
            color: var(--ocean-blue);
            text-decoration: none;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 9px;
            border-radius: 7px;
            background: rgba(43, 108, 176, 0.08);
            transition: all 0.16s ease;
        }

        .shipment-link:hover {
            background: var(--ocean-blue);
            color: #ffffff;
        }

        .btn-read {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(135deg, var(--navy-primary), var(--ocean-blue));
            color: #ffffff;
            border: none;
            padding: 8px 14px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            white-space: nowrap;
            box-shadow: 0 4px 12px rgba(43, 108, 176, 0.22);
            transition: all 0.18s ease;
        }

        .btn-read:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(43, 108, 176, 0.30);
        }

        .badge-read {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(29, 122, 104, 0.22);
            color: var(--teal-pos);
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 11.5px;
            font-weight: 800;
            white-space: nowrap;
        }

        .empty-state {
            text-align: center;
            padding: 46px 20px;
            color: var(--text-muted);
            background: rgba(255, 255, 255, 0.65);
            border-radius: 14px;
            border: 1px dashed rgba(30, 58, 95, 0.18);
        }

        .pagination {
            margin-top: 20px;
        }

        /* ================= RIGHT KPI & ANALYTICS PANEL ================= */
        .summary-stack {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid rgba(30, 58, 95, 0.08);
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
            font-size: 15px;
            font-weight: 800;
            color: var(--navy-deep);
        }

        .kpi-mini-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-bottom: 16px;
        }

        .kpi-mini {
            padding: 12px 10px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.85);
            border: 1px solid rgba(30, 58, 95, 0.08);
            text-align: center;
        }

        .kpi-mini-num {
            font-size: 20px;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 4px;
        }

        .kpi-mini-lbl {
            font-size: 10.5px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
        }

        .progress-wrap {
            background: rgba(255, 255, 255, 0.78);
            border: 1px solid rgba(30, 58, 95, 0.08);
            border-radius: 12px;
            padding: 13px 14px;
        }

        .progress-head {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            font-weight: 700;
            color: var(--navy-primary);
            margin-bottom: 8px;
        }

        .progress-track {
            width: 100%;
            height: 8px;
            border-radius: 999px;
            background: rgba(30, 58, 95, 0.10);
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--ocean-blue), var(--teal-pos));
            transition: width 0.3s ease;
        }

        .legend-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 11px;
            background: rgba(255, 255, 255, 0.75);
            border: 1px solid rgba(30, 58, 95, 0.08);
            font-size: 12.5px;
        }

        .legend-bar {
            width: 4px;
            height: 26px;
            border-radius: 4px;
            flex-shrink: 0;
        }

        .legend-name {
            font-weight: 800;
            color: var(--navy-deep);
            font-size: 12.5px;
        }

        .legend-sub {
            font-size: 11.5px;
            color: var(--text-muted);
        }

        @media (max-width: 1120px) {
            .notif-layout { grid-template-columns: 1fr; }
        }

        @media (max-width: 860px) {
            body { flex-direction: column; }
            .sidebar { width: 100%; height: auto; position: static; }
            .notif-card { flex-direction: column; align-items: flex-start; }
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
            <a href="{{ route('notifications.index') }}" class="nav-link active">
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
        <!-- Maritime Hero Banner -->
        <div class="hero-banner">
            <div>
                <div class="hero-badge">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                    </svg>
                    Operational Alert Center
                </div>
                <h1 class="hero-title">Notifikasi Operasional</h1>
                <p class="hero-desc">Pemberitahuan keterlambatan pelayaran, pembaruan status manifest, dan kendala pelabuhan</p>
            </div>

            <div class="hero-right">
                <div class="live-pill">
                    <span class="pulse-dot"></span>
                    Alert Monitoring Active
                </div>
                <a href="{{ route('dashboard') }}" class="btn-hero-light">
                    ← Kembali ke Dashboard
                </a>
            </div>
        </div>

        @php
            $totalCount  = $notifications->count();
            $unreadCount = $notifications->whereNull('read_at')->count();
            $readCount   = $notifications->whereNotNull('read_at')->count();
            $readPercent = $totalCount > 0 ? round(($readCount / $totalCount) * 100) : 100;
        @endphp

        <!-- 2-Column Workspace -->
        <div class="notif-layout">
            <!-- Left: Notification Feed with Interactive Filters -->
            <div class="glass-card">
                <div class="toolbar">
                    <div class="filter-group" id="filterGroup">
                        <button type="button" class="filter-btn active" data-filter="all">Semua ({{ $totalCount }})</button>
                        <button type="button" class="filter-btn" data-filter="unread">Belum Dibaca ({{ $unreadCount }})</button>
                        <button type="button" class="filter-btn" data-filter="alert">Peringatan Kendala</button>
                        <button type="button" class="filter-btn" data-filter="success">Pembaruan Status</button>
                    </div>

                    <div class="search-wrap">
                        <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" id="notifSearch" class="search-input" placeholder="Cari nomor SHP atau pesan...">
                    </div>
                </div>

                @if($notifications->count() > 0)
                    <div class="notif-list" id="notifList">
                        @foreach($notifications as $notif)
                            @php
                                $titleText = $notif->title ?? str_replace('_', ' ', $notif->type ?? 'Notifikasi Pengiriman');
                                $bodyText  = $notif->message ?? $notif->body ?? '-';
                                $combined  = strtolower($titleText . ' ' . $bodyText . ' ' . ($notif->type ?? ''));

                                $category = 'info';
                                if (str_contains($combined, 'terlambat') || str_contains($combined, 'delay') || str_contains($combined, 'kendala') || str_contains($combined, 'congestion') || str_contains($combined, 'exception')) {
                                    $category = 'alert';
                                } elseif (str_contains($combined, 'delivered') || str_contains($combined, 'tiba') || str_contains($combined, 'diperbarui')) {
                                    $category = 'success';
                                }

                                $isUnread = is_null($notif->read_at);
                            @endphp

                            <div class="notif-card type-{{ $category }} {{ $isUnread ? 'unread' : '' }}"
                                 data-category="{{ $category }}"
                                 data-unread="{{ $isUnread ? '1' : '0' }}"
                                 data-search="{{ strtolower($titleText . ' ' . $bodyText) }}">

                                <div class="notif-left">
                                    <div class="notif-badge-icon">
                                        @if($category === 'alert')
                                            <svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                                        @elseif($category === 'success')
                                            <svg viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="9 12 11 14 15 10"/></svg>
                                        @else
                                            <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                                        @endif
                                    </div>

                                    <div>
                                        <div class="notif-title-row">
                                            <div class="notif-title">{{ $titleText }}</div>

                                            @if($category === 'alert')
                                                <span class="cat-pill alert">Delay / Kendala</span>
                                            @elseif($category === 'success')
                                                <span class="cat-pill success">Status Update</span>
                                            @else
                                                <span class="cat-pill info">Info Manifest</span>
                                            @endif

                                            @if($isUnread)
                                                <span class="new-dot">Baru</span>
                                            @endif
                                        </div>

                                        <div class="notif-body">{{ $bodyText }}</div>

                                        <div class="notif-meta">
                                            <span>{{ $notif->created_at ? $notif->created_at->format('d-m-Y H:i') : '' }}</span>
                                            @if($notif->shipment_id)
                                                <span>•</span>
                                                <a href="{{ route('shipments.show', $notif->shipment_id) }}" class="shipment-link">
                                                    Lihat Shipment →
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    @if($isUnread)
                                        <form action="{{ route('notifications.read', $notif->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn-read">
                                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                                    <polyline points="20 6 9 17 4 12"/>
                                                </svg>
                                                Tandai Dibaca
                                            </button>
                                        </form>
                                    @else
                                        <span class="badge-read">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                                <polyline points="20 6 9 17 4 12"/>
                                            </svg>
                                            Dibaca
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div id="noFilterMatch" class="empty-state" style="display:none; margin-top:12px;">
                        <p style="font-size: 14px; font-weight: 800; color: var(--navy-deep); margin-bottom: 4px;">Tidak ada notifikasi yang cocok</p>
                        <p style="font-size: 12.5px;">Coba ubah filter kategori atau kata kunci pencarian Anda.</p>
                    </div>

                    <div class="pagination">
                        {{ $notifications->links() }}
                    </div>
                @else
                    <div class="empty-state">
                        <p style="font-size: 15px; font-weight: 800; color: var(--navy-deep); margin-bottom: 4px;">Belum ada notifikasi</p>
                        <p style="font-size: 13px;">Semua aktivitas pengiriman Anda berjalan normal tanpa peringatan baru.</p>
                    </div>
                @endif
            </div>

            <!-- Right: Colorful KPI & Category Legend -->
            <div class="summary-stack">
                <div class="glass-card">
                    <div class="card-header">
                        <div class="card-icon">
                            <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                        </div>
                        <h2 class="card-title">Ringkasan Halaman Ini</h2>
                    </div>

                    <div class="kpi-mini-grid">
                        <div class="kpi-mini">
                            <div class="kpi-mini-num" style="color: var(--navy-deep);">{{ $totalCount }}</div>
                            <div class="kpi-mini-lbl">Total</div>
                        </div>
                        <div class="kpi-mini">
                            <div class="kpi-mini-num" style="color: var(--ocean-blue);">{{ $unreadCount }}</div>
                            <div class="kpi-mini-lbl">Baru</div>
                        </div>
                        <div class="kpi-mini">
                            <div class="kpi-mini-num" style="color: var(--teal-pos);">{{ $readCount }}</div>
                            <div class="kpi-mini-lbl">Dibaca</div>
                        </div>
                    </div>

                    <div class="progress-wrap">
                        <div class="progress-head">
                            <span>Tingkat Respons Keterbacaan</span>
                            <span>{{ $readPercent }}%</span>
                        </div>
                        <div class="progress-track">
                            <div class="progress-fill" style="width: {{ $readPercent }}%;"></div>
                        </div>
                    </div>
                </div>

                <div class="glass-card">
                    <div class="card-header">
                        <div class="card-icon">
                            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                        </div>
                        <h2 class="card-title">Klasifikasi Peringatan</h2>
                    </div>

                    <div class="legend-list">
                        <div class="legend-item">
                            <span class="legend-bar" style="background: var(--coral-err);"></span>
                            <div>
                                <div class="legend-name">Peringatan Kendala & Delay</div>
                                <div class="legend-sub">Kepadatan pelabuhan, cuaca buruk, atau keterlambatan ETA</div>
                            </div>
                        </div>

                        <div class="legend-item">
                            <span class="legend-bar" style="background: var(--teal-pos);"></span>
                            <div>
                                <div class="legend-name">Pembaruan Status Manifest</div>
                                <div class="legend-sub">Kargo tiba di pelabuhan tujuan (Delivered) atau checkpoint</div>
                            </div>
                        </div>

                        <div class="legend-item">
                            <span class="legend-bar" style="background: var(--ocean-blue);"></span>
                            <div>
                                <div class="legend-name">Informasi Sistem & Audit</div>
                                <div class="legend-sub">Pemberitahuan registrasi atau perubahan jadwal pengiriman</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Client-Side Filter & Search Script -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const filterBtns = document.querySelectorAll('.filter-btn');
        const searchInput = document.getElementById('notifSearch');
        const cards = document.querySelectorAll('#notifList .notif-card');
        const emptyMatch = document.getElementById('noFilterMatch');

        let activeFilter = 'all';

        function applyFilters() {
            const query = (searchInput?.value || '').toLowerCase().trim();
            let visibleCount = 0;

            cards.forEach(card => {
                const cat = card.dataset.category;
                const isUnread = card.dataset.unread === '1';
                const text = card.dataset.search || '';

                const matchTab =
                    activeFilter === 'all' ||
                    (activeFilter === 'unread' && isUnread) ||
                    (activeFilter === cat);

                const matchSearch = !query || text.includes(query);

                if (matchTab && matchSearch) {
                    card.style.display = 'flex';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (emptyMatch) {
                emptyMatch.style.display = (cards.length > 0 && visibleCount === 0) ? 'block' : 'none';
            }
        }

        filterBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                activeFilter = this.dataset.filter;
                applyFilters();
            });
        });

        if (searchInput) {
            searchInput.addEventListener('input', applyFilters);
        }
    });
    </script>

</body>
</html>