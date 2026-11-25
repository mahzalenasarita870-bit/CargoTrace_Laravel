<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Carrier — CargoTrace Maritime Visibility</title>

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

        /* ================= 2-COLUMN WORKSPACE ================= */
        .content-layout {
            display: grid;
            grid-template-columns: 1.85fr 1.05fr;
            gap: 22px;
            align-items: start;
        }

        .left-stack, .side-stack {
            display: flex;
            flex-direction: column;
            gap: 20px;
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

        .error-alert {
            background: var(--coral-bg);
            color: var(--coral-err);
            border: 1px solid rgba(197, 48, 48, 0.24);
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .error-alert ul {
            margin-left: 20px;
            margin-top: 6px;
        }

        /* Quick Preset Bar inside Form */
        .preset-bar {
            background: linear-gradient(135deg, rgba(235, 244, 252, 0.9), rgba(255, 255, 255, 0.92));
            border: 1px solid rgba(43, 108, 176, 0.16);
            border-radius: 13px;
            padding: 13px 16px;
            margin-bottom: 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }

        .preset-lbl {
            font-size: 12px;
            font-weight: 800;
            color: var(--navy-primary);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .preset-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
        }

        .preset-chip {
            padding: 5px 11px;
            border-radius: 999px;
            border: 1px solid rgba(43, 108, 176, 0.24);
            background: #ffffff;
            color: var(--ocean-blue);
            font-size: 11.5px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.16s ease;
        }

        .preset-chip:hover {
            background: var(--ocean-blue);
            color: #ffffff;
            transform: translateY(-1px);
        }

        .section-block {
            margin-bottom: 22px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(30, 58, 95, 0.08);
        }

        .section-block:last-of-type {
            border-bottom: none;
            margin-bottom: 6px;
            padding-bottom: 0;
        }

        .section-head {
            display: flex;
            align-items: center;
            gap: 11px;
            margin-bottom: 15px;
        }

        .section-icon {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: rgba(43, 108, 176, 0.11);
            color: var(--ocean-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
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
            font-weight: 800;
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

        .input-wrap {
            position: relative;
        }

        .input-wrap svg {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            stroke: #7B93A8;
            stroke-width: 2;
            fill: none;
            pointer-events: none;
        }

        .input-wrap input {
            padding-left: 38px;
        }

        input {
            width: 100%;
            padding: 11px 14px;
            border: 1px solid rgba(30, 58, 95, 0.16);
            border-radius: 10px;
            font-size: 13.5px;
            color: var(--text-dark);
            background: var(--glass-strong);
            transition: all 0.18s ease;
        }

        input::placeholder {
            color: #94A3B8;
        }

        input:focus {
            outline: none;
            border-color: var(--ocean-blue);
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(43, 108, 176, 0.14);
        }

        .field-hint {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 5px;
        }

        .form-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 20px;
            padding-top: 18px;
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

        /* ================= BOTTOM LEFT READINESS CARD ================= */
        .readiness-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .readiness-box {
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(30, 58, 95, 0.08);
            border-radius: 12px;
            padding: 13px 14px;
        }

        .readiness-title {
            font-size: 12px;
            font-weight: 800;
            color: var(--navy-deep);
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .readiness-desc {
            font-size: 11.5px;
            color: var(--text-muted);
            line-height: 1.45;
        }

        /* ================= RIGHT PREVIEW & SCAC PANEL ================= */
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

        .preview-card {
            background: linear-gradient(135deg, #132A46 0%, #1E4976 60%, #2B6CB0 100%);
            border-radius: 16px;
            padding: 20px 22px;
            color: #ffffff;
            box-shadow: 0 10px 24px rgba(19, 42, 70, 0.22);
            position: relative;
            overflow: hidden;
        }

        .preview-card::after {
            content: '';
            position: absolute;
            right: -30px;
            bottom: -40px;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(127, 179, 213, 0.28) 0%, transparent 70%);
            pointer-events: none;
        }

        .preview-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .preview-avatar {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.28);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 15px;
            color: #BAE6FD;
        }

        .preview-code {
            padding: 5px 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.25);
            font-size: 11.5px;
            font-weight: 800;
            letter-spacing: 0.7px;
        }

        .preview-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #93C5FD;
            font-weight: 700;
            margin-bottom: 3px;
        }

        .preview-name {
            font-size: 17px;
            font-weight: 800;
            margin-bottom: 12px;
        }

        .preview-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.15);
            margin-bottom: 11px;
        }

        .preview-meta {
            display: flex;
            flex-direction: column;
            gap: 5px;
            font-size: 12px;
            color: #E2E8F0;
        }

        .scac-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .scac-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 13px;
            border-radius: 11px;
            background: rgba(255, 255, 255, 0.82);
            border: 1px solid rgba(30, 58, 95, 0.09);
            font-size: 12.5px;
            cursor: pointer;
            transition: all 0.16s ease;
        }

        .scac-item:hover {
            background: #ffffff;
            border-color: var(--ocean-blue);
            transform: translateX(2px);
        }

        .scac-name {
            font-weight: 700;
            color: var(--navy-deep);
        }

        .scac-sub {
            font-size: 11px;
            color: var(--text-muted);
        }

        .scac-tag {
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 800;
            background: rgba(43, 108, 176, 0.12);
            color: var(--ocean-blue);
        }

        @media (max-width: 1100px) {
            .content-layout { grid-template-columns: 1fr; }
            .readiness-grid { grid-template-columns: 1fr; }
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
                <a href="{{ route('carriers.index') }}" class="nav-link active">
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
                    Master Fleet Registration
                </div>
                <h1 class="hero-title">Tambah Carrier Baru</h1>
                <p class="hero-desc">Daftarkan perusahaan pelayaran, lini logistik, kode identitas SCAC, dan kontak operasional</p>
            </div>

            <a href="{{ route('carriers.index') }}" class="btn-hero-light">
                ← Kembali ke Daftar Carriers
            </a>
        </div>

        <!-- 2-Column Workspace -->
        <div class="content-layout">
            <!-- Left Stack: Form + Readiness Info -->
            <div class="left-stack">
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

                    <!-- Quick Fill Preset Bar -->
                    <div class="preset-bar">
                        <span class="preset-lbl">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
                            </svg>
                            Isi Cepat Mitra Pelayaran:
                        </span>
                        <div class="preset-chips">
                            <button type="button" class="preset-chip" onclick="fillCarrierPreset('Meratus Line', 'MRT', '031-3291888', 'ops@meratusline.com')">+ Meratus Line</button>
                            <button type="button" class="preset-chip" onclick="fillCarrierPreset('Samudera Indonesia', 'SML', '021-25676999', 'dispatch@samudera.id')">+ Samudera ID</button>
                            <button type="button" class="preset-chip" onclick="fillCarrierPreset('SPIL (Salam Pacific)', 'SPIL', '031-3533529', 'cargo@spil.co.id')">+ SPIL</button>
                        </div>
                    </div>

                    <form action="{{ route('carriers.store') }}" method="POST">
                        @csrf

                        <!-- Bagian 1: Identitas Perusahaan Pelayaran -->
                        <div class="section-block">
                            <div class="section-head">
                                <div class="section-icon">
                                    <svg viewBox="0 0 24 24"><circle cx="12" cy="5" r="3"/><line x1="12" y1="22" x2="12" y2="8"/><path d="M5 12H2a10 10 0 0 0 20 0h-3"/></svg>
                                </div>
                                <div>
                                    <div class="section-title">Identitas Perusahaan Pengiriman</div>
                                    <div class="section-sub">Nama resmi carrier dan kode singkatan identifikasi manifest</div>
                                </div>
                            </div>

                            <div class="form-grid">
                                <div class="form-group">
                                    <label>Nama Carrier <span class="required-star">*</span></label>
                                    <div class="input-wrap">
                                        <svg viewBox="0 0 24 24"><path d="M2 21c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1 .6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"/><path d="M19.38 20A11.6 11.6 0 0 0 21 14l-9-4-9 4c0 2.9.94 5.34 2.81 7.76"/></svg>
                                        <input type="text"
                                               id="carrierNameInput"
                                               name="name"
                                               value="{{ old('name') }}"
                                               placeholder="Contoh: Meratus Line / MSC"
                                               required>
                                    </div>
                                    <div class="field-hint">Nama resmi perusahaan pelayaran atau ekspedisi</div>
                                </div>

                                <div class="form-group">
                                    <label>Kode Carrier <span class="required-star">*</span></label>
                                    <div class="input-wrap">
                                        <svg viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                                        <input type="text"
                                               id="carrierCodeInput"
                                               name="code"
                                               value="{{ old('code') }}"
                                               placeholder="Contoh: MRT / MSC"
                                               style="text-transform: uppercase;"
                                               required>
                                    </div>
                                    <div class="field-hint">Kode unik 3–4 karakter (SCAC / kode internal)</div>
                                </div>
                            </div>
                        </div>

                        <!-- Bagian 2: Kontak Operasional -->
                        <div class="section-block">
                            <div class="section-head">
                                <div class="section-icon">
                                    <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                </div>
                                <div>
                                    <div class="section-title">Informasi Kontak & Koordinasi</div>
                                    <div class="section-sub">Nomor telepon dispatch dan email korespondensi manifest</div>
                                </div>
                            </div>

                            <div class="form-grid">
                                <div class="form-group">
                                    <label>Nomor Telepon</label>
                                    <div class="input-wrap">
                                        <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                        <input type="text"
                                               id="carrierPhoneInput"
                                               name="phone"
                                               value="{{ old('phone') }}"
                                               placeholder="Contoh: 081234567890">
                                    </div>
                                    <div class="field-hint">Nomor hotline kantor cabang / operasional pelabuhan</div>
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <div class="input-wrap">
                                        <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                        <input type="email"
                                               id="carrierEmailInput"
                                               name="email"
                                               value="{{ old('email') }}"
                                               placeholder="Contoh: ops@carrier.com">
                                    </div>
                                    <div class="field-hint">Email resmi pengiriman Bill of Lading & notifikasi</div>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <a href="{{ route('carriers.index') }}" class="btn-back">
                                ← Kembali
                            </a>

                            <button type="submit" class="btn-save">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                                Simpan Data
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Bottom Left Card: Operational Integration Info -->
                <div class="glass-card" style="padding: 20px 24px;">
                    <div class="guide-title" style="margin-bottom: 12px;">
                        <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        Integrasi Data Carrier ke Sistem CargoTrace
                    </div>
                    <div class="readiness-grid">
                        <div class="readiness-box">
                            <div class="readiness-title">1. Pilihan di Shipment</div>
                            <div class="readiness-desc">Carrier baru langsung muncul pada dropdown pemilihan armada saat membuat shipment baru.</div>
                        </div>
                        <div class="readiness-box">
                            <div class="readiness-title">2. Pelacakan Manifest</div>
                            <div class="readiness-desc">Kode SCAC digunakan sebagai identitas kapal/operator di laporan PDF dan Excel.</div>
                        </div>
                        <div class="readiness-box">
                            <div class="readiness-title">3. Eskalasi Insiden</div>
                            <div class="readiness-desc">Nomor telepon dan email memudahkan koordinasi saat terjadi Port Congestion.</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Stack: Live Carrier Preview & SCAC Reference -->
            <div class="side-stack">
                <div class="glass-card">
                    <div class="guide-title">
                        <svg viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                        Pratinjau Kartu Carrier
                    </div>

                    <div class="preview-card">
                        <div class="preview-top">
                            <div class="preview-avatar" id="prevAvatar">CR</div>
                            <span class="preview-code" id="prevCode">CODE</span>
                        </div>
                        <div class="preview-label">Verified Maritime Carrier</div>
                        <div class="preview-name" id="prevName">Nama Perusahaan Carrier</div>
                        <div class="preview-divider"></div>
                        <div class="preview-meta">
                            <div>Telp: <strong id="prevPhone">-</strong></div>
                            <div>Email: <strong id="prevEmail">-</strong></div>
                        </div>
                    </div>
                </div>

                <div class="glass-card">
                    <div class="guide-title">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                        Referensi Kode SCAC Maritim
                    </div>
                    <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 10px;">
                        Klik salah satu lini pelayaran global di bawah jika ingin menyalin nama dan kodenya ke form:
                    </p>
                    <div class="scac-list">
                        <div class="scac-item" onclick="fillCarrierPreset('Mediterranean Shipping Company', 'MSC', '021-57900500', 'id-info@msc.com')">
                            <div>
                                <div class="scac-name">Mediterranean Shipping (MSC)</div>
                                <div class="scac-sub">Global Container Line</div>
                            </div>
                            <span class="scac-tag">MSC</span>
                        </div>
                        <div class="scac-item" onclick="fillCarrierPreset('Evergreen Marine Corp', 'EGL', '021-52920888', 'jkt@evergreen-marine.com')">
                            <div>
                                <div class="scac-name">Evergreen Marine</div>
                                <div class="scac-sub">Asia-Pacific Line</div>
                            </div>
                            <span class="scac-tag">EGL</span>
                        </div>
                        <div class="scac-item" onclick="fillCarrierPreset('Hapag-Lloyd AG', 'HLCU', '021-29349100', 'indonesia@hlag.com')">
                            <div>
                                <div class="scac-name">Hapag-Lloyd</div>
                                <div class="scac-sub">European Shipping Line</div>
                            </div>
                            <span class="scac-tag">HLCU</span>
                        </div>
                        <div class="scac-item" onclick="fillCarrierPreset('Ocean Network Express', 'ONE', '021-80663300', 'id.cs@one-line.com')">
                            <div>
                                <div class="scac-name">Ocean Network Express</div>
                                <div class="scac-sub">Japan Consortium Line</div>
                            </div>
                            <span class="scac-tag">ONE</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Live Preview & Quick Preset Script -->
    <script>
    const nameIn  = document.getElementById('carrierNameInput');
    const codeIn  = document.getElementById('carrierCodeInput');
    const phoneIn = document.getElementById('carrierPhoneInput');
    const emailIn = document.getElementById('carrierEmailInput');

    const prevAvatar = document.getElementById('prevAvatar');
    const prevCode   = document.getElementById('prevCode');
    const prevName   = document.getElementById('prevName');
    const prevPhone  = document.getElementById('prevPhone');
    const prevEmail  = document.getElementById('prevEmail');

    function updatePreview() {
        const nameVal  = (nameIn.value || '').trim();
        const codeVal  = (codeIn.value || '').trim().toUpperCase();
        const phoneVal = (phoneIn.value || '').trim();
        const emailVal = (emailIn.value || '').trim();

        prevName.textContent   = nameVal || 'Nama Perusahaan Carrier';
        prevCode.textContent   = codeVal || 'CODE';
        prevAvatar.textContent = (codeVal || nameVal || 'CR').substring(0, 3).toUpperCase();
        prevPhone.textContent  = phoneVal || '-';
        prevEmail.textContent  = emailVal || '-';
    }

    function fillCarrierPreset(name, code, phone, email) {
        nameIn.value  = name;
        codeIn.value  = code;
        phoneIn.value = phone;
        emailIn.value = email;
        updatePreview();
    }

    document.addEventListener('DOMContentLoaded', function () {
        [nameIn, codeIn, phoneIn, emailIn].forEach(el => {
            if (el) el.addEventListener('input', updatePreview);
        });
        updatePreview();
    });
    </script>

</body>
</html>