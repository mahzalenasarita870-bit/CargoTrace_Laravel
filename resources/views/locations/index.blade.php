<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location Management — CargoTrace Maritime Visibility</title>

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

        .kpi-card.k-gps::before { background: var(--teal-pos); }
        .kpi-card.k-country::before { background: var(--cerulean); }

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
            min-width: 280px;
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

        .search-input {
            width: 100%;
            padding: 9.5px 14px 9.5px 36px;
            border-radius: 11px;
            border: 1px solid rgba(30, 58, 95, 0.15);
            background: rgba(255, 255, 255, 0.94);
            font-size: 13px;
            color: var(--text-dark);
            transition: all 0.18s ease;
        }

        .search-input:focus {
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

        .loc-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .loc-avatar {
            width: 38px;
            height: 38px;
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .loc-avatar.port {
            background: linear-gradient(135deg, var(--navy-primary), var(--ocean-blue));
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(43, 108, 176, 0.22);
        }

        .loc-avatar.hub {
            background: rgba(29, 122, 104, 0.13);
            color: var(--teal-pos);
            border: 1px solid rgba(29, 122, 104, 0.22);
        }

        .loc-avatar svg {
            width: 17px;
            height: 17px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
        }

        .loc-name {
            font-weight: 800;
            font-size: 14px;
            color: var(--navy-deep);
        }

        .loc-sub {
            font-size: 11.5px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .country-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 11px;
            border-radius: 999px;
            font-size: 11.5px;
            font-weight: 700;
            background: rgba(43, 108, 176, 0.10);
            color: var(--ocean-blue);
            border: 1px solid rgba(43, 108, 176, 0.20);
        }

        .coord-pill {
            display: inline-block;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: 12px;
            font-weight: 700;
            padding: 4px 9px;
            border-radius: 7px;
            background: rgba(30, 58, 95, 0.06);
            color: var(--navy-primary);
            border: 1px solid rgba(30, 58, 95, 0.10);
        }

        .muted-dash {
            color: #94A3B8;
            font-weight: 600;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .btn-edit {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: var(--amber-bg);
            color: var(--amber-warn);
            border: 1px solid rgba(183, 121, 31, 0.24);
            padding: 7px 14px;
            border-radius: 9px;
            font-size: 12.5px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.18s ease;
        }

        .btn-edit:hover {
            background: #F59E0B;
            color: #ffffff;
            border-color: #F59E0B;
        }

        .btn-delete {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: var(--coral-bg);
            color: var(--coral-err);
            border: 1px solid rgba(197, 48, 48, 0.22);
            padding: 7px 14px;
            border-radius: 9px;
            font-size: 12.5px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.18s ease;
        }

        .btn-delete:hover {
            background: var(--coral-err);
            color: #ffffff;
            border-color: var(--coral-err);
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
            margin-bottom: 12px;
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

        .progress-wrap {
            margin-top: 12px;
            background: rgba(255, 255, 255, 0.85);
            border: 1px solid rgba(30, 58, 95, 0.08);
            border-radius: 10px;
            padding: 10px 12px;
        }

        .progress-top {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            font-weight: 700;
            color: var(--navy-primary);
            margin-bottom: 6px;
        }

        .progress-track {
            width: 100%;
            height: 7px;
            border-radius: 999px;
            background: rgba(30, 58, 95, 0.10);
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--ocean-blue), var(--teal-pos));
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
                <a href="{{ route('locations.index') }}" class="nav-link active">
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
                        <polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"/><line x1="8" y1="2" x2="8" y2="18"/><line x1="16" y1="6" x2="16" y2="22"/>
                    </svg>
                    Global Ports & Logistics Hubs
                </div>
                <h1 class="hero-title">Location Management</h1>
                <p class="hero-desc">Kelola pelabuhan utama, gudang transit, dan titik koordinat GPS pada jaringan rute CargoTrace</p>
            </div>

            <div class="hero-actions">
                <a href="{{ route('dashboard') }}" class="btn-hero-light">
                    ← Dashboard
                </a>

                <a href="{{ route('locations.create') }}" class="btn-hero-cta">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    + Add Location
                </a>
            </div>
        </div>

        @php
            $pageCount      = $locations->count();
            $totalLocations = method_exists($locations, 'total') ? $locations->total() : $pageCount;
            $withCoords     = $locations->filter(fn($l) => !is_null($l->latitude) && !is_null($l->longitude))->count();
            $countryCount   = $locations->pluck('country')->filter()->unique()->count();
            $geoRate        = $pageCount > 0 ? round(($withCoords / $pageCount) * 100) : 100;
        @endphp

        <!-- KPI Summary Strip -->
        <div class="kpi-strip">
            <div class="kpi-card">
                <div>
                    <div class="kpi-lbl">Total Locations</div>
                    <div class="kpi-val">{{ $totalLocations }}</div>
                    <div class="kpi-sub">Pelabuhan & gudang logistik terdaftar</div>
                </div>
                <div class="kpi-icon" style="background: rgba(43, 108, 176, 0.12); color: var(--ocean-blue);">
                    <svg viewBox="0 0 24 24"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"/><line x1="8" y1="2" x2="8" y2="18"/><line x1="16" y1="6" x2="16" y2="22"/></svg>
                </div>
            </div>

            <div class="kpi-card k-country">
                <div>
                    <div class="kpi-lbl">Cakupan Negara</div>
                    <div class="kpi-val" style="color: var(--ocean-blue);">{{ $countryCount }}</div>
                    <div class="kpi-sub">Negara pada halaman aktif</div>
                </div>
                <div class="kpi-icon" style="background: rgba(74, 144, 226, 0.14); color: var(--cerulean);">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                </div>
            </div>

            <div class="kpi-card k-gps">
                <div>
                    <div class="kpi-lbl">Koordinat GPS Terpetakan</div>
                    <div class="kpi-val" style="color: var(--teal-pos);">{{ $withCoords }}</div>
                    <div class="kpi-sub">Memiliki Latitude & Longitude aktif</div>
                </div>
                <div class="kpi-icon" style="background: var(--teal-bg); color: var(--teal-pos);">
                    <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                </div>
            </div>
        </div>

        <!-- Full-Width Glass Table Card -->
        <div class="glass-card">
            <div class="toolbar">
                <div class="card-title-wrap">
                    <div class="card-icon">
                        <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    </div>
                    <div>
                        <h2 class="card-title">Daftar Pelabuhan &amp; Gudang Logistik (Locations)</h2>
                        <div class="card-sub">Titik asal, transit, dan tujuan pengiriman untuk pemetaan tracking rute</div>
                    </div>
                </div>

                <div class="toolbar-right">
                    <div class="search-wrap">
                        <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" id="locationSearch" class="search-input" placeholder="Cari pelabuhan, kota, atau negara...">
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

            <div class="table-wrap">
                <table id="locationTable">
                    <thead>
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th>Location Name</th>
                            <th>City</th>
                            <th>Country</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th style="width: 185px;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($locations as $location)
                            @php
                                $isPort = str_contains(strtolower($location->name ?? ''), 'port');
                            @endphp
                            <tr data-search="{{ strtolower(($location->name ?? '') . ' ' . ($location->city ?? '') . ' ' . ($location->country ?? '')) }}">
                                <td style="font-weight:700; color:var(--text-muted);">
                                    {{ $loop->iteration + ($locations->currentPage() - 1) * $locations->perPage() }}
                                </td>

                                <td>
                                    <div class="loc-cell">
                                        <div class="loc-avatar {{ $isPort ? 'port' : 'hub' }}">
                                            @if($isPort)
                                                <svg viewBox="0 0 24 24"><circle cx="12" cy="5" r="3"/><line x1="12" y1="22" x2="12" y2="8"/><path d="M5 12H2a10 10 0 0 0 20 0h-3"/></svg>
                                            @else
                                                <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="loc-name">{{ $location->name }}</div>
                                            <div class="loc-sub">{{ $isPort ? 'Maritime Seaport Terminal' : 'Inland Logistics Warehouse' }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td style="font-weight: 700; color: var(--navy-primary);">
                                    {{ $location->city }}
                                </td>

                                <td>
                                    <span class="country-badge">{{ $location->country }}</span>
                                </td>

                                <td>
                                    @if(!is_null($location->latitude))
                                        <span class="coord-pill">{{ $location->latitude }}</span>
                                    @else
                                        <span class="muted-dash">-</span>
                                    @endif
                                </td>

                                <td>
                                    @if(!is_null($location->longitude))
                                        <span class="coord-pill">{{ $location->longitude }}</span>
                                    @else
                                        <span class="muted-dash">-</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('locations.edit', $location->id) }}"
                                           class="btn-edit">
                                            Edit
                                        </a>

                                        <form action="{{ route('locations.destroy', $location->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus location ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn-delete">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="empty">
                                    Belum ada data location.
                                </td>
                            </tr>
                        @endforelse

                        <tr id="locationNoMatch" style="display: none;">
                            <td colspan="7" class="empty">
                                <div style="font-weight: 800; color: var(--navy-deep); margin-bottom: 4px;">
                                    Tidak ada lokasi yang cocok dengan pencarian "<span id="searchKeywordLabel"></span>"
                                </div>
                                <div style="font-size: 12px;">Coba periksa nama pelabuhan, kota, negara, atau reset filter pencarian.</div>
                                <button type="button" onclick="resetLocationSearch()" class="btn-reset-search">
                                    ↺ Reset Pencarian
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="table-footer">
                <div id="footerCounter">Menampilkan {{ $locations->count() }} dari {{ $totalLocations }} titik lokasi terdaftar</div>
                <div class="pagination-wrap">
                    {{ $locations->links() }}
                </div>
            </div>
        </div>

        <!-- Bottom 3-Column Operational Cards -->
        <div class="bottom-grid">
            <div class="info-card">
                <div>
                    <div class="info-head">
                        <div class="info-icon">
                            <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        </div>
                        <div class="info-title">Akurasi Geolocation GPS</div>
                    </div>
                    <div class="info-body">
                        Koordinat Latitude &amp; Longitude digunakan untuk memvisualisasikan posisi rute pelabuhan dan gudang transit pada peta dashboard.
                    </div>
                </div>
                <div class="progress-wrap">
                    <div class="progress-top">
                        <span>Rasio Titik Koordinat Lengkap</span>
                        <span style="color: var(--teal-pos);">{{ $geoRate }}%</span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" style="width: {{ $geoRate }}%;"></div>
                    </div>
                </div>
            </div>

            <div class="info-card">
                <div>
                    <div class="info-head">
                        <div class="info-icon">
                            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                        </div>
                        <div class="info-title">Standar Penamaan Terminal</div>
                    </div>
                    <div class="info-body">
                        Gunakan awalan <strong>Port of ...</strong> untuk pelabuhan laut utama dan <strong>... Warehouse</strong> untuk gudang distribusi darat agar klasifikasi rute terbaca otomatis.
                    </div>
                </div>
                <div style="margin-top: 12px; font-size: 11.5px; font-weight: 700; color: var(--ocean-blue);">
                    ● Terintegrasi langsung dengan Origin &amp; Destination Shipment
                </div>
            </div>

            <div class="info-card">
                <div>
                    <div class="info-head">
                        <div class="info-icon">
                            <svg viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                        </div>
                        <div class="info-title">Akses Cepat Operasional</div>
                    </div>
                    <div class="quick-links">
                        <a href="{{ route('shipments.create') }}" class="q-link">
                            <span>+ Buat Shipment Baru</span>
                            <span>→</span>
                        </a>
                        <a href="{{ route('tracking.index') }}" class="q-link">
                            <span>Update Tracking Events</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Footer -->
        <footer class="page-footer">
            <div><strong>CargoTrace</strong> — Maritime Supply Visibility &amp; Global Port Network</div>
            <div>Total Titik Aktif: {{ $totalLocations }} Lokasi</div>
        </footer>
    </main>

    <!-- Client-Side Quick Search Script -->
    <script>
    const searchInput   = document.getElementById('locationSearch');
    const rows          = document.querySelectorAll('#locationTable tbody tr[data-search]');
    const noMatchRow    = document.getElementById('locationNoMatch');
    const keywordLabel  = document.getElementById('searchKeywordLabel');
    const footerCounter = document.getElementById('footerCounter');
    const totalAll      = {{ $totalLocations }};

    function filterLocations() {
        const query = (searchInput?.value || '').toLowerCase().trim();
        let visibleCount = 0;

        rows.forEach(row => {
            const text = row.dataset.search || '';
            const isMatch = !query || text.includes(query);
            row.style.display = isMatch ? '' : 'none';
            if (isMatch) visibleCount++;
        });

        if (noMatchRow) {
            noMatchRow.style.display = (rows.length > 0 && visibleCount === 0) ? '' : 'none';
            if (keywordLabel) keywordLabel.textContent = searchInput.value;
        }

        if (footerCounter) {
            footerCounter.textContent = `Menampilkan ${visibleCount} dari ${totalAll} titik lokasi terdaftar`;
        }
    }

    function resetLocationSearch() {
        if (searchInput) {
            searchInput.value = '';
            filterLocations();
            searchInput.focus();
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        if (searchInput) {
            searchInput.addEventListener('input', filterLocations);
        }
    });
    </script>

</body>
</html>