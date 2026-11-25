<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Management — CargoTrace Maritime Visibility</title>

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
            --glass-bg: rgba(255, 255, 255, 0.85);
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
            --indigo-badge: #4338CA;
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
            display: flex;
            flex-direction: column;
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

        /* ================= KPI STRIP ================= */
        .kpi-strip {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
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

        .kpi-card.k-staff::before { background: var(--indigo-badge); }
        .kpi-card.k-cust::before  { background: var(--teal-pos); }

        .kpi-lbl {
            font-size: 11px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.4px;
            margin-bottom: 4px;
        }

        .kpi-val {
            font-size: 24px;
            font-weight: 800;
            color: var(--navy-deep);
            line-height: 1.1;
        }

        .kpi-sub {
            font-size: 11.5px;
            color: var(--text-muted);
            margin-top: 3px;
            font-weight: 600;
        }

        .kpi-icon {
            width: 44px;
            height: 44px;
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

        /* ================= FULL-WIDTH GLASS TABLE CARD ================= */
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: 18px;
            padding: 24px 26px;
            box-shadow: 0 8px 28px rgba(30, 58, 95, 0.06);
            margin-bottom: 20px;
        }

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
            font-size: 16px;
            font-weight: 800;
            color: var(--navy-deep);
        }

        .card-sub {
            font-size: 12px;
            color: var(--text-muted);
        }

        .toolbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .search-wrap {
            position: relative;
            min-width: 260px;
        }

        .search-wrap svg {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 15px;
            height: 15px;
            stroke: #7B93A8;
            stroke-width: 2;
            fill: none;
        }

        .search-input, .filter-select {
            padding: 9.5px 14px;
            border-radius: 11px;
            border: 1px solid rgba(30, 58, 95, 0.15);
            background: rgba(255, 255, 255, 0.94);
            font-size: 13px;
            color: var(--text-dark);
            transition: all 0.18s ease;
        }

        .search-input {
            width: 100%;
            padding-left: 36px;
        }

        .search-input:focus, .filter-select:focus {
            outline: none;
            border-color: var(--ocean-blue);
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(43, 108, 176, 0.12);
        }

        .alert-success {
            background: var(--teal-bg);
            color: var(--teal-pos);
            border: 1px solid rgba(29, 122, 104, 0.22);
            padding: 12px 16px;
            border-radius: 11px;
            margin-bottom: 18px;
            font-size: 13.5px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-error {
            background: var(--coral-bg);
            color: var(--coral-err);
            border: 1px solid rgba(197, 48, 48, 0.22);
            padding: 12px 16px;
            border-radius: 11px;
            margin-bottom: 18px;
            font-size: 13.5px;
            font-weight: 700;
        }

        /* Table */
        .table-wrap {
            overflow-x: auto;
            border-radius: 14px;
            border: 1px solid rgba(30, 58, 95, 0.09);
            background: rgba(255, 255, 255, 0.82);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: linear-gradient(180deg, rgba(235, 244, 252, 0.98), rgba(226, 239, 250, 0.94));
            color: var(--navy-primary);
            font-size: 11.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 14px 18px;
            text-align: left;
            border-bottom: 1px solid rgba(30, 58, 95, 0.10);
            white-space: nowrap;
        }

        td {
            padding: 15px 18px;
            border-bottom: 1px solid rgba(30, 58, 95, 0.06);
            text-align: left;
            font-size: 13.5px;
            color: var(--text-dark);
            vertical-align: middle;
        }

        tbody tr {
            transition: background 0.15s ease;
        }

        tbody tr:hover {
            background: rgba(255, 255, 255, 0.98);
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .user-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 11px;
            background: linear-gradient(135deg, var(--navy-primary), var(--ocean-blue));
            color: #ffffff;
            font-size: 13px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 10px rgba(43, 108, 176, 0.20);
        }

        .user-name {
            font-weight: 800;
            font-size: 14px;
            color: var(--navy-deep);
        }

        .user-sub {
            font-size: 11.5px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .email-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .email-pill svg {
            width: 14px;
            height: 14px;
            stroke: var(--ocean-blue);
            stroke-width: 2;
            fill: none;
            flex-shrink: 0;
        }

        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 11px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .role-badge.admin    { background: var(--indigo-bg); color: var(--indigo-badge); }
        .role-badge.operator { background: var(--amber-bg); color: var(--amber-warn); }
        .role-badge.customer { background: var(--teal-bg); color: var(--teal-pos); }

        .role-form {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .role-select {
            padding: 7.5px 12px;
            border-radius: 9px;
            border: 1px solid rgba(30, 58, 95, 0.18);
            background: #ffffff;
            font-size: 12.5px;
            font-weight: 700;
            color: var(--navy-primary);
            cursor: pointer;
        }

        .role-select:focus {
            outline: none;
            border-color: var(--ocean-blue);
            box-shadow: 0 0 0 3px rgba(43, 108, 176, 0.12);
        }

        .btn-save-role {
            background: linear-gradient(135deg, var(--navy-primary), var(--ocean-blue));
            color: #ffffff;
            border: none;
            padding: 8px 14px;
            border-radius: 9px;
            font-size: 12.5px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(30, 58, 95, 0.18);
            transition: all 0.16s ease;
        }

        .btn-save-role:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 14px rgba(30, 58, 95, 0.25);
        }

        .active-admin-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 9px;
            background: rgba(30, 58, 95, 0.06);
            color: var(--text-muted);
            font-size: 12px;
            font-weight: 700;
        }

        .btn-reset-search {
            margin-top: 8px;
            padding: 7px 15px;
            border-radius: 9px;
            border: 1px solid rgba(43, 108, 176, 0.24);
            background: #ffffff;
            color: var(--ocean-blue);
            font-size: 12.5px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.16s ease;
        }

        .btn-reset-search:hover {
            background: var(--ocean-blue);
            color: #ffffff;
        }

        .table-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 16px;
            padding-top: 14px;
            border-top: 1px solid rgba(30, 58, 95, 0.08);
            font-size: 12.5px;
            color: var(--text-muted);
            font-weight: 600;
        }

        .pagination-wrap nav svg {
            width: 16px;
            height: 16px;
        }

        /* ================= BOTTOM 3-COLUMN SUMMARY BAND ================= */
        .bottom-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            margin-bottom: 20px;
        }

        .info-card {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            padding: 20px 22px;
            box-shadow: 0 6px 22px rgba(30, 58, 95, 0.05);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .info-head {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .info-icon {
            width: 32px;
            height: 32px;
            border-radius: 9px;
            background: rgba(43, 108, 176, 0.11);
            color: var(--ocean-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .info-icon svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
        }

        .info-title {
            font-size: 14px;
            font-weight: 800;
            color: var(--navy-deep);
        }

        .info-body {
            font-size: 12.5px;
            color: var(--text-muted);
            line-height: 1.55;
        }

        .matrix-list {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-top: 8px;
            font-size: 12px;
        }

        .matrix-item {
            display: flex;
            justify-content: space-between;
            padding: 6px 10px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.85);
            border: 1px solid rgba(30, 58, 95, 0.07);
        }

        .quick-links {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-top: 4px;
        }

        .q-link {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 9px 12px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.86);
            border: 1px solid rgba(30, 58, 95, 0.09);
            text-decoration: none;
            font-size: 12.5px;
            font-weight: 700;
            color: var(--navy-primary);
            transition: all 0.16s ease;
        }

        .q-link:hover {
            background: #ffffff;
            border-color: var(--ocean-blue);
            color: var(--ocean-blue);
            transform: translateX(3px);
        }

        /* ================= SYSTEM FOOTER ================= */
        .page-footer {
            margin-top: auto;
            padding: 14px 20px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.65);
            border: 1px solid var(--glass-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            font-size: 12px;
            color: var(--text-muted);
            font-weight: 600;
        }

        .empty {
            text-align: center;
            padding: 36px;
            color: var(--text-muted);
        }

        @media (max-width: 1024px) {
            .kpi-strip, .bottom-grid { grid-template-columns: 1fr; }
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
            {{ auth()->user()->role ?? 'admin' }}
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
                <a href="{{ route('users.index') }}" class="nav-link active">
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
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    Access Control & User Directory
                </div>
                <h1 class="hero-title">Users Management</h1>
                <p class="hero-desc">Kelola akun pengguna, distribusi peran operasional, dan hak akses sistem CargoTrace</p>
            </div>

            <a href="{{ route('dashboard') }}" class="btn-hero-light">
                ← Kembali ke Dashboard
            </a>
        </div>

        @php
            $pageCount     = $users->count();
            $totalUsers    = method_exists($users, 'total') ? $users->total() : $pageCount;
            $staffCount    = $users->filter(fn($u) => in_array(strtolower($u->role ?? ''), ['admin', 'operator']))->count();
            $customerCount = $users->filter(fn($u) => strtolower($u->role ?? '') === 'customer')->count();
        @endphp

        <!-- KPI Summary Strip -->
        <div class="kpi-strip">
            <div class="kpi-card">
                <div>
                    <div class="kpi-lbl">Total Pengguna</div>
                    <div class="kpi-val">{{ $totalUsers }}</div>
                    <div class="kpi-sub">Seluruh akun terdaftar pada platform</div>
                </div>
                <div class="kpi-icon" style="background: rgba(43, 108, 176, 0.12); color: var(--ocean-blue);">
                    <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
            </div>

            <div class="kpi-card k-staff">
                <div>
                    <div class="kpi-lbl">Admin &amp; Operator</div>
                    <div class="kpi-val" style="color: var(--indigo-badge);">{{ $staffCount }}</div>
                    <div class="kpi-sub">Tim pengelola operasional logistik</div>
                </div>
                <div class="kpi-icon" style="background: var(--indigo-bg); color: var(--indigo-badge);">
                    <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
            </div>

            <div class="kpi-card k-cust">
                <div>
                    <div class="kpi-lbl">Akun Customer</div>
                    <div class="kpi-val" style="color: var(--teal-pos);">{{ $customerCount }}</div>
                    <div class="kpi-sub">Mitra pemilik kargo &amp; ekspedisi</div>
                </div>
                <div class="kpi-icon" style="background: var(--teal-bg); color: var(--teal-pos);">
                    <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                </div>
            </div>
        </div>

        <!-- Full-Width Glass Table Card -->
        <div class="glass-card">
            <div class="toolbar">
                <div class="card-title-wrap">
                    <div class="card-icon">
                        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    </div>
                    <div>
                        <h2 class="card-title">Daftar Akun Pengguna (Users)</h2>
                        <div class="card-sub">Atur perubahan role pengguna secara langsung dengan proteksi akun aktif</div>
                    </div>
                </div>

                <div class="toolbar-right">
                    <select id="roleFilter" class="filter-select">
                        <option value="">Semua Role</option>
                        <option value="admin">Admin</option>
                        <option value="operator">Operator</option>
                        <option value="customer">Customer</option>
                    </select>

                    <div class="search-wrap">
                        <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" id="userSearch" class="search-input" placeholder="Cari nama pengguna atau email...">
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert-success">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert-error">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert-error">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="table-wrap">
                <table id="userTable">
                    <thead>
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th>Nama Pengguna</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Tanggal Dibuat</th>
                            <th style="width: 240px;">Ubah Role</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($users as $user)
                            @php
                                $roleKey = strtolower($user->role ?? 'customer');
                            @endphp
                            <tr data-search="{{ strtolower(($user->name ?? '') . ' ' . ($user->email ?? '') . ' ' . $roleKey) }}"
                                data-role="{{ $roleKey }}">
                                <td style="font-weight:700; color:var(--text-muted);">
                                    {{ (method_exists($users, 'firstItem') && $users->firstItem() ? $users->firstItem() : 1) + $loop->index }}
                                </td>

                                <td>
                                    <div class="user-cell">
                                        <div class="user-avatar">
                                            {{ strtoupper(substr($user->name ?? 'U', 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="user-name">{{ $user->name }}</div>
                                            <div class="user-sub">User ID #{{ $user->id }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span class="email-pill">
                                        <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                        {{ $user->email }}
                                    </span>
                                </td>

                                <td>
                                    <span class="role-badge {{ $roleKey }}">
                                        ● {{ $user->role }}
                                    </span>
                                </td>

                                <td style="font-weight: 600; color: var(--text-muted);">
                                    {{ $user->created_at?->format('d-m-Y') ?? '-' }}
                                </td>

                                <td>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('users.updateRole', $user) }}"
                                              method="POST"
                                              class="role-form">
                                            @csrf
                                            @method('PATCH')

                                            <select name="role" class="role-select" required>
                                                @foreach(['admin' => 'ADMIN', 'operator' => 'OPERATOR', 'customer' => 'CUSTOMER'] as $val => $label)
                                                    <option value="{{ $val }}" {{ $roleKey === $val ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <button type="submit" class="btn-save-role">
                                                Simpan
                                            </button>
                                        </form>
                                    @else
                                        <span class="active-admin-pill">
                                            ● Akun Admin aktif
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty">
                                    Belum ada pengguna.
                                </td>
                            </tr>
                        @endforelse

                        <tr id="userNoMatch" style="display: none;">
                            <td colspan="6" class="empty">
                                <div style="font-weight: 800; color: var(--navy-deep); margin-bottom: 4px;">
                                    Tidak ada pengguna yang cocok dengan filter pencarian
                                </div>
                                <div style="font-size: 12px;">Ubah kata kunci pencarian atau pilih "Semua Role" untuk menampilkan kembali data.</div>
                                <button type="button" onclick="resetUserFilter()" class="btn-reset-search">
                                    ↺ Reset Filter
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="table-footer">
                <div id="footerCounter">Menampilkan {{ $users->count() }} dari {{ $totalUsers }} pengguna terdaftar</div>
                <div class="pagination-wrap">
                    {{ $users->links() }}
                </div>
            </div>
        </div>

        <!-- Bottom 3-Column Operational Cards -->
        <div class="bottom-grid">
            <div class="info-card">
                <div>
                    <div class="info-head">
                        <div class="info-icon">
                            <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        </div>
                        <div class="info-title">Matriks Hak Akses (RBAC)</div>
                    </div>
                    <div class="matrix-list">
                        <div class="matrix-item">
                            <strong>ADMIN</strong>
                            <span style="color: var(--text-muted);">Akses penuh master data &amp; user</span>
                        </div>
                        <div class="matrix-item">
                            <strong>OPERATOR</strong>
                            <span style="color: var(--text-muted);">Kelola shipment, tracking &amp; exception</span>
                        </div>
                        <div class="matrix-item">
                            <strong>CUSTOMER</strong>
                            <span style="color: var(--text-muted);">Pantau status kargo miliknya</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="info-card">
                <div>
                    <div class="info-head">
                        <div class="info-icon">
                            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                        </div>
                        <div class="info-title">Keamanan Sesi Administrator</div>
                    </div>
                    <div class="info-body">
                        Untuk mencegah terkuncinya akses sistem secara tidak sengaja, role akun Administrator yang sedang aktif login tidak dapat diturunkan dari halaman ini.
                    </div>
                </div>
                <div style="margin-top: 12px; font-size: 11.5px; font-weight: 700; color: var(--teal-pos);">
                    ● Proteksi Self-Lockout Aktif ({{ auth()->user()->email }})
                </div>
            </div>

            <div class="info-card">
                <div>
                    <div class="info-head">
                        <div class="info-icon">
                            <svg viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                        </div>
                        <div class="info-title">Akses Cepat Sistem</div>
                    </div>
                    <div class="quick-links">
                        <a href="{{ route('audit-logs.index') }}" class="q-link">
                            <span>Periksa Audit Logs Aktivitas</span>
                            <span>→</span>
                        </a>
                        <a href="{{ route('shipments.index') }}" class="q-link">
                            <span>Kelola Daftar Shipments</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Footer -->
        <footer class="page-footer">
            <div><strong>CargoTrace</strong> — Maritime Supply Visibility &amp; Access Governance</div>
            <div>Total Pengguna Terdaftar: {{ $totalUsers }} Akun</div>
        </footer>
    </main>

    <!-- Client-Side Search & Role Filter Script -->
    <script>
    const searchInput   = document.getElementById('userSearch');
    const roleFilter    = document.getElementById('roleFilter');
    const rows          = document.querySelectorAll('#userTable tbody tr[data-search]');
    const noMatchRow    = document.getElementById('userNoMatch');
    const footerCounter = document.getElementById('footerCounter');
    const totalAll      = {{ $totalUsers }};

    function filterUsers() {
        const query = (searchInput?.value || '').toLowerCase().trim();
        const role  = (roleFilter?.value || '').toLowerCase().trim();
        let visibleCount = 0;

        rows.forEach(row => {
            const text     = row.dataset.search || '';
            const rowRole  = row.dataset.role || '';
            const matchTxt = !query || text.includes(query);
            const matchRol = !role || rowRole === role;
            const isMatch  = matchTxt && matchRol;

            row.style.display = isMatch ? '' : 'none';
            if (isMatch) visibleCount++;
        });

        if (noMatchRow) {
            noMatchRow.style.display = (rows.length > 0 && visibleCount === 0) ? '' : 'none';
        }

        if (footerCounter) {
            footerCounter.textContent = `Menampilkan ${visibleCount} dari ${totalAll} pengguna terdaftar`;
        }
    }

    function resetUserFilter() {
        if (searchInput) searchInput.value = '';
        if (roleFilter) roleFilter.value = '';
        filterUsers();
    }

    document.addEventListener('DOMContentLoaded', function () {
        if (searchInput) searchInput.addEventListener('input', filterUsers);
        if (roleFilter)  roleFilter.addEventListener('change', filterUsers);
    });
    </script>

</body>
</html>