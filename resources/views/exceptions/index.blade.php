<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipment Exceptions — CargoTrace Maritime Visibility</title>

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
            padding: 11px 18px;
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

        /* ================= KPI STRIP ================= */
        .kpi-strip {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 20px;
        }

        .kpi-card {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            padding: 16px 20px;
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

        .kpi-card.k-open::before   { background: var(--coral-err); }
        .kpi-card.k-high::before   { background: var(--orange-high); }
        .kpi-card.k-done::before   { background: var(--teal-pos); }

        .kpi-lbl {
            font-size: 11px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.4px;
            margin-bottom: 4px;
        }

        .kpi-val {
            font-size: 23px;
            font-weight: 800;
            color: var(--navy-deep);
            line-height: 1.1;
        }

        .kpi-sub {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 3px;
            font-weight: 600;
        }

        .kpi-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .kpi-icon svg {
            width: 20px;
            height: 20px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
        }

        /* ================= 2-COLUMN WORKSPACE ================= */
        .exc-workspace {
            display: grid;
            grid-template-columns: 2.25fr 1fr;
            gap: 22px;
            align-items: start;
        }

        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: 18px;
            padding: 22px 24px;
            box-shadow: 0 8px 28px rgba(30, 58, 95, 0.06);
        }

        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 16px;
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
            background: rgba(255, 255, 255, 0.85);
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
            min-width: 215px;
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
            background: rgba(255, 255, 255, 0.92);
            font-size: 12.5px;
            color: var(--text-dark);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--ocean-blue);
            background: #ffffff;
        }

        .alert-success {
            background: var(--teal-bg);
            color: var(--teal-pos);
            border: 1px solid rgba(29, 122, 104, 0.22);
            padding: 12px 16px;
            border-radius: 11px;
            margin-bottom: 16px;
            font-size: 13px;
            font-weight: 700;
        }

        /* Rich Incident Cards inside Feed (Instead of sparse flat rows) */
        .exc-feed {
            display: flex;
            flex-direction: column;
            gap: 13px;
        }

        .exc-item {
            background: rgba(255, 255, 255, 0.88);
            border: 1px solid rgba(30, 58, 95, 0.09);
            border-left: 4px solid var(--coral-err);
            border-radius: 14px;
            padding: 16px 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            transition: all 0.2s ease;
        }

        .exc-item:hover {
            background: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(30, 58, 95, 0.08);
        }

        .exc-item.is-resolved {
            border-left-color: var(--teal-pos);
            background: linear-gradient(135deg, rgba(240, 253, 250, 0.82), rgba(255, 255, 255, 0.92));
        }

        .exc-left {
            display: flex;
            align-items: flex-start;
            gap: 14px;
        }

        .exc-icon-box {
            width: 40px;
            height: 40px;
            border-radius: 11px;
            background: var(--coral-bg);
            color: var(--coral-err);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .exc-item.is-resolved .exc-icon-box {
            background: var(--teal-bg);
            color: var(--teal-pos);
        }

        .exc-icon-box svg {
            width: 19px;
            height: 19px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
        }

        .exc-head-row {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 5px;
        }

        .exc-title {
            font-size: 14.5px;
            font-weight: 800;
            color: var(--navy-deep);
        }

        .shp-chip {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 9px;
            border-radius: 7px;
            font-size: 11.5px;
            font-weight: 800;
            background: rgba(43, 108, 176, 0.10);
            color: var(--ocean-blue);
            text-decoration: none;
            transition: all 0.16s ease;
        }

        .shp-chip:hover {
            background: var(--ocean-blue);
            color: #ffffff;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 9px;
            border-radius: 999px;
            font-size: 10.5px;
            font-weight: 800;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }

        .open     { background: var(--coral-bg); color: var(--coral-err); }
        .resolved { background: var(--teal-bg); color: var(--teal-pos); }
        .low      { background: rgba(43, 108, 176, 0.13); color: var(--ocean-blue); }
        .medium   { background: var(--amber-bg); color: var(--amber-warn); }
        .high     { background: var(--orange-bg); color: var(--orange-high); }
        .critical { background: var(--coral-bg); color: var(--coral-err); }

        .exc-desc {
            font-size: 13.5px;
            color: var(--text-dark);
            line-height: 1.45;
            margin-bottom: 7px;
        }

        .exc-meta {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            font-size: 12px;
            color: var(--text-muted);
            font-weight: 600;
        }

        .resolve-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(135deg, #15803D, var(--teal-pos));
            color: #ffffff;
            border: none;
            padding: 9px 15px;
            border-radius: 10px;
            font-size: 12.5px;
            font-weight: 700;
            cursor: pointer;
            white-space: nowrap;
            box-shadow: 0 4px 12px rgba(29, 122, 104, 0.24);
            transition: all 0.18s ease;
        }

        .resolve-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(29, 122, 104, 0.32);
        }

        .done-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 7px 13px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 800;
            background: #ffffff;
            border: 1px solid rgba(29, 122, 104, 0.24);
            color: var(--teal-pos);
            white-space: nowrap;
        }

        .empty-state {
            text-align: center;
            padding: 44px 20px;
            color: var(--text-muted);
            background: rgba(255, 255, 255, 0.65);
            border-radius: 14px;
            border: 1px dashed rgba(30, 58, 95, 0.18);
        }

        .pagination {
            margin-top: 18px;
        }

        /* ================= RIGHT ANALYTICS & SLA PANEL ================= */
        .side-stack {
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

        .rate-box {
            background: linear-gradient(135deg, rgba(240, 253, 250, 0.9), rgba(255, 255, 255, 0.92));
            border: 1px solid rgba(29, 122, 104, 0.20);
            border-radius: 13px;
            padding: 14px 16px;
            margin-bottom: 16px;
        }

        .rate-top {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 8px;
        }

        .rate-lbl {
            font-size: 12px;
            font-weight: 700;
            color: var(--navy-primary);
        }

        .rate-val {
            font-size: 22px;
            font-weight: 800;
            color: var(--teal-pos);
        }

        .bar-track {
            width: 100%;
            height: 8px;
            border-radius: 999px;
            background: rgba(30, 58, 95, 0.10);
            overflow: hidden;
        }

        .bar-fill {
            height: 100%;
            border-radius: 999px;
            transition: width 0.35s ease;
        }

        .sev-breakdown {
            display: flex;
            flex-direction: column;
            gap: 11px;
        }

        .sev-row {
            background: rgba(255, 255, 255, 0.78);
            border: 1px solid rgba(30, 58, 95, 0.08);
            border-radius: 11px;
            padding: 10px 12px;
        }

        .sev-row-head {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .sla-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .sla-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 11px;
            background: rgba(255, 255, 255, 0.75);
            border: 1px solid rgba(30, 58, 95, 0.08);
        }

        .sla-dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            margin-top: 4px;
            flex-shrink: 0;
        }

        .sla-title {
            font-size: 12.5px;
            font-weight: 800;
            color: var(--navy-deep);
        }

        .sla-sub {
            font-size: 11.5px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        @media (max-width: 1120px) {
            .exc-workspace { grid-template-columns: 1fr; }
            .kpi-strip { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 860px) {
            body { flex-direction: column; }
            .sidebar { width: 100%; height: auto; position: static; }
            .kpi-strip { grid-template-columns: 1fr; }
            .exc-item { flex-direction: column; align-items: flex-start; }
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
        <!-- Maritime Hero Banner -->
        <div class="hero-banner">
            <div>
                <div class="hero-badge">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                    </svg>
                    Incident & Exception Control Room
                </div>
                <h1 class="hero-title">Shipment Exceptions</h1>
                <p class="hero-desc">Kelola kendala pelayaran, kepadatan pelabuhan (port congestion), kerusakan kargo, dan resolusi insiden</p>
            </div>

            <div class="hero-actions">
                <a href="{{ route('dashboard') }}" class="btn-hero-light">
                    ← Dashboard
                </a>

                <a href="{{ route('exceptions.create') }}" class="btn-hero-cta">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Tambah Exception
                </a>
            </div>
        </div>

        @php
            $pageCount   = $exceptions->count();
            $totalExc    = method_exists($exceptions, 'total') ? $exceptions->total() : $pageCount;
            $openExc     = $exceptions->where('status', '!=', 'RESOLVED')->count();
            $resolvedExc = $exceptions->where('status', 'RESOLVED')->count();
            $highCritExc = $exceptions->whereIn('severity', ['HIGH', 'CRITICAL'])->count();

            $critCount   = $exceptions->where('severity', 'CRITICAL')->count();
            $highCount   = $exceptions->where('severity', 'HIGH')->count();
            $medCount    = $exceptions->where('severity', 'MEDIUM')->count();
            $lowCount    = $exceptions->where('severity', 'LOW')->count();

            $resolveRate = $pageCount > 0 ? round(($resolvedExc / $pageCount) * 100) : 100;
        @endphp

        <!-- KPI Summary Strip -->
        <div class="kpi-strip">
            <div class="kpi-card">
                <div>
                    <div class="kpi-lbl">Total Exceptions</div>
                    <div class="kpi-val">{{ $totalExc }}</div>
                    <div class="kpi-sub">Semua laporan insiden</div>
                </div>
                <div class="kpi-icon" style="background: rgba(43, 108, 176, 0.12); color: var(--ocean-blue);">
                    <svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                </div>
            </div>

            <div class="kpi-card k-open">
                <div>
                    <div class="kpi-lbl">Open / Perlu Tindakan</div>
                    <div class="kpi-val" style="color: var(--coral-err);">{{ $openExc }}</div>
                    <div class="kpi-sub">Menunggu penanganan</div>
                </div>
                <div class="kpi-icon" style="background: var(--coral-bg); color: var(--coral-err);">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                </div>
            </div>

            <div class="kpi-card k-high">
                <div>
                    <div class="kpi-lbl">High & Critical</div>
                    <div class="kpi-val" style="color: var(--orange-high);">{{ $highCritExc }}</div>
                    <div class="kpi-sub">Prioritas eskalasi</div>
                </div>
                <div class="kpi-icon" style="background: var(--orange-bg); color: var(--orange-high);">
                    <svg viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                </div>
            </div>

            <div class="kpi-card k-done">
                <div>
                    <div class="kpi-lbl">Resolved / Selesai</div>
                    <div class="kpi-val" style="color: var(--teal-pos);">{{ $resolvedExc }}</div>
                    <div class="kpi-sub">{{ $resolveRate }}% tingkat penyelesaian</div>
                </div>
                <div class="kpi-icon" style="background: var(--teal-bg); color: var(--teal-pos);">
                    <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
            </div>
        </div>

        <!-- 2-Column Workspace -->
        <div class="exc-workspace">
            <!-- Left: Rich Incident Feed Cards -->
            <div class="glass-card">
                <div class="toolbar">
                    <div class="filter-group" id="excFilterGroup">
                        <button type="button" class="filter-btn active" data-filter="all">Semua ({{ $pageCount }})</button>
                        <button type="button" class="filter-btn" data-filter="open">Open ({{ $openExc }})</button>
                        <button type="button" class="filter-btn" data-filter="resolved">Resolved ({{ $resolvedExc }})</button>
                        <button type="button" class="filter-btn" data-filter="highcrit">High / Critical ({{ $highCritExc }})</button>
                    </div>

                    <div class="search-wrap">
                        <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" id="excSearch" class="search-input" placeholder="Cari nomor SHP atau kendala...">
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($exceptions->count() > 0)
                    <div class="exc-feed" id="excFeed">
                        @foreach($exceptions as $exception)
                            @php
                                $isResolved = strtoupper($exception->status ?? '') === 'RESOLVED';
                                $rowStatus  = $isResolved ? 'resolved' : 'open';
                                $sevUpper   = strtoupper($exception->severity ?? 'LOW');
                                $isHighCrit = in_array($sevUpper, ['HIGH', 'CRITICAL']);
                                $shpNum     = $exception->shipment->shipment_number ?? '-';
                            @endphp

                            <div class="exc-item {{ $isResolved ? 'is-resolved' : '' }}"
                                 data-status="{{ $rowStatus }}"
                                 data-highcrit="{{ $isHighCrit ? '1' : '0' }}"
                                 data-search="{{ strtolower($shpNum . ' ' . $exception->exception_type . ' ' . $exception->description) }}">

                                <div class="exc-left">
                                    <div class="exc-icon-box">
                                        @if($isResolved)
                                            <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                        @else
                                            <svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                                        @endif
                                    </div>

                                    <div>
                                        <div class="exc-head-row">
                                            <span class="exc-title">{{ str_replace('_', ' ', $exception->exception_type) }}</span>

                                            @if($exception->shipment)
                                                <a href="{{ route('shipments.show', $exception->shipment->id) }}" class="shp-chip">
                                                    {{ $shpNum }}
                                                </a>
                                            @endif

                                            <span class="badge {{ strtolower($exception->severity) }}">
                                                ● {{ $exception->severity }}
                                            </span>

                                            <span class="badge {{ $isResolved ? 'resolved' : 'open' }}">
                                                {{ $exception->status }}
                                            </span>
                                        </div>

                                        <div class="exc-desc">
                                            {{ $exception->description }}
                                        </div>

                                        <div class="exc-meta">
                                            <span>Incident #{{ (method_exists($exceptions, 'firstItem') && $exceptions->firstItem() ? $exceptions->firstItem() : 1) + $loop->index }}</span>
                                            <span>•</span>
                                            <span>Terdeteksi: {{ $exception->detected_at?->format('d-m-Y H:i') ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    @if(!$isResolved)
                                        <form action="{{ route('exceptions.resolve', $exception) }}" method="POST">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit" class="resolve-btn">
                                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                                    <polyline points="20 6 9 17 4 12"/>
                                                </svg>
                                                Resolve
                                            </button>
                                        </form>
                                    @else
                                        <span class="done-pill">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                                <polyline points="20 6 9 17 4 12"/>
                                            </svg>
                                            Selesai
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div id="excNoMatch" class="empty-state" style="display:none; margin-top:12px;">
                        <p style="font-size: 14px; font-weight: 800; color: var(--navy-deep); margin-bottom: 4px;">Tidak ada exception yang cocok</p>
                        <p style="font-size: 12.5px;">Coba ubah filter status atau kata kunci pencarian nomor shipment.</p>
                    </div>
                @else
                    <div class="empty-state">
                        <p style="font-size: 15px; font-weight: 800; color: var(--navy-deep); margin-bottom: 4px;">Belum ada data Exceptions</p>
                        <p style="font-size: 13px;">Seluruh pelayaran kargo berjalan lancar tanpa catatan kendala.</p>
                    </div>
                @endif

                @if(method_exists($exceptions, 'links'))
                    <div class="pagination">
                        {{ $exceptions->links() }}
                    </div>
                @endif
            </div>

            <!-- Right: Severity Breakdown & SLA Resolution Panel -->
            <div class="side-stack">
                <div class="glass-card">
                    <div class="card-header">
                        <div class="card-icon">
                            <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                        </div>
                        <h2 class="card-title">Distribusi Tingkat Keparahan</h2>
                    </div>

                    <div class="rate-box">
                        <div class="rate-top">
                            <span class="rate-lbl">Rasio Penyelesaian Insiden</span>
                            <span class="rate-val">{{ $resolveRate }}%</span>
                        </div>
                        <div class="bar-track">
                            <div class="bar-fill" style="width: {{ $resolveRate }}%; background: linear-gradient(90deg, var(--ocean-blue), var(--teal-pos));"></div>
                        </div>
                    </div>

                    <div class="sev-breakdown">
                        <div class="sev-row">
                            <div class="sev-row-head">
                                <span style="color: var(--coral-err);">CRITICAL</span>
                                <span>{{ $critCount }} insiden</span>
                            </div>
                            <div class="bar-track">
                                <div class="bar-fill" style="width: {{ $pageCount > 0 ? round(($critCount / $pageCount) * 100) : 0 }}%; background: var(--coral-err);"></div>
                            </div>
                        </div>

                        <div class="sev-row">
                            <div class="sev-row-head">
                                <span style="color: var(--orange-high);">HIGH</span>
                                <span>{{ $highCount }} insiden</span>
                            </div>
                            <div class="bar-track">
                                <div class="bar-fill" style="width: {{ $pageCount > 0 ? round(($highCount / $pageCount) * 100) : 0 }}%; background: var(--orange-high);"></div>
                            </div>
                        </div>

                        <div class="sev-row">
                            <div class="sev-row-head">
                                <span style="color: var(--amber-warn);">MEDIUM</span>
                                <span>{{ $medCount }} insiden</span>
                            </div>
                            <div class="bar-track">
                                <div class="bar-fill" style="width: {{ $pageCount > 0 ? round(($medCount / $pageCount) * 100) : 0 }}%; background: var(--amber-warn);"></div>
                            </div>
                        </div>

                        <div class="sev-row">
                            <div class="sev-row-head">
                                <span style="color: var(--ocean-blue);">LOW</span>
                                <span>{{ $lowCount }} insiden</span>
                            </div>
                            <div class="bar-track">
                                <div class="bar-fill" style="width: {{ $pageCount > 0 ? round(($lowCount / $pageCount) * 100) : 0 }}%; background: var(--ocean-blue);"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="glass-card">
                    <div class="card-header">
                        <div class="card-icon">
                            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                        </div>
                        <h2 class="card-title">Panduan Eskalasi SLA</h2>
                    </div>

                    <div class="sla-list">
                        <div class="sla-item">
                            <span class="sla-dot" style="background: var(--coral-err);"></span>
                            <div>
                                <div class="sla-title">Critical / High (&lt; 4 Jam)</div>
                                <div class="sla-sub">Kepadatan pelabuhan berat atau kerusakan kontainer wajib segera dikonfirmasi ke operator pelabuhan.</div>
                            </div>
                        </div>

                        <div class="sla-item">
                            <span class="sla-dot" style="background: var(--amber-warn);"></span>
                            <div>
                                <div class="sla-title">Medium (&lt; 12 Jam)</div>
                                <div class="sla-sub">Keterlambatan jadwal feeder atau pemeriksaan dokumen bea cukai perlu pembaruan ETA.</div>
                            </div>
                        </div>

                        <div class="sla-item">
                            <span class="sla-dot" style="background: var(--teal-pos);"></span>
                            <div>
                                <div class="sla-title">Penutupan Insiden (Resolve)</div>
                                <div class="sla-sub">Klik tombol <strong>Resolve</strong> setelah kendala terselesaikan agar status shipment kembali normal.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Client-Side Filter & Quick Search Script -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const filterBtns = document.querySelectorAll('#excFilterGroup .filter-btn');
        const searchInput = document.getElementById('excSearch');
        const items = document.querySelectorAll('#excFeed .exc-item');
        const noMatch = document.getElementById('excNoMatch');

        let activeFilter = 'all';

        function applyFilters() {
            const query = (searchInput?.value || '').toLowerCase().trim();
            let visibleCount = 0;

            items.forEach(item => {
                const status = item.dataset.status;
                const isHighCrit = item.dataset.highcrit === '1';
                const text = item.dataset.search || '';

                const matchTab =
                    activeFilter === 'all' ||
                    (activeFilter === 'open' && status === 'open') ||
                    (activeFilter === 'resolved' && status === 'resolved') ||
                    (activeFilter === 'highcrit' && isHighCrit);

                const matchSearch = !query || text.includes(query);

                if (matchTab && matchSearch) {
                    item.style.display = 'flex';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            if (noMatch) {
                noMatch.style.display = (items.length > 0 && visibleCount === 0) ? 'block' : 'none';
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