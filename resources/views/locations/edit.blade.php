<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Location — CargoTrace Maritime Visibility</title>

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

        /* ================= WORKSPACE GRID ================= */
        .workspace-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 20px;
            align-items: stretch;
            margin-bottom: 20px;
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

        .card-head {
            display: flex;
            align-items: center;
            gap: 11px;
            padding-bottom: 14px;
            margin-bottom: 18px;
            border-bottom: 1px solid rgba(30, 58, 95, 0.08);
        }

        .card-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: rgba(43, 108, 176, 0.11);
            color: var(--ocean-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .card-icon svg {
            width: 18px;
            height: 18px;
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
            margin-top: 2px;
        }

        .error-box {
            background: var(--coral-bg);
            color: var(--coral-err);
            border: 1px solid rgba(197, 48, 48, 0.22);
            padding: 13px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        .error-box ul {
            margin-left: 18px;
        }

        .form-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            font-size: 12.5px;
            font-weight: 800;
            color: var(--navy-primary);
            margin-bottom: 7px;
        }

        .form-control {
            width: 100%;
            padding: 11px 14px;
            border: 1px solid rgba(30, 58, 95, 0.16);
            border-radius: 11px;
            background: rgba(255, 255, 255, 0.94);
            font-size: 13.5px;
            color: var(--text-dark);
            transition: all 0.18s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--ocean-blue);
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(43, 108, 176, 0.13);
        }

        .button-group {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 8px;
            padding-top: 16px;
            border-top: 1px solid rgba(30, 58, 95, 0.08);
        }

        .btn-submit {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, var(--navy-primary), var(--ocean-blue));
            color: #ffffff;
            border: none;
            padding: 11.5px 22px;
            border-radius: 12px;
            font-size: 13.5px;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 6px 16px rgba(30, 58, 95, 0.22);
            transition: all 0.2s ease;
        }

        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(30, 58, 95, 0.28);
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.9);
            color: var(--text-muted);
            border: 1px solid rgba(30, 58, 95, 0.16);
            text-decoration: none;
            padding: 11px 18px;
            border-radius: 12px;
            font-size: 13.5px;
            font-weight: 700;
            transition: all 0.18s ease;
        }

        .btn-back:hover {
            background: #ffffff;
            color: var(--navy-deep);
        }

        /* ================= RIGHT PREVIEW & METADATA ================= */
        .side-stack {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .preview-box {
            background: linear-gradient(145deg, #132A46, #1E4976);
            color: #ffffff;
            border-radius: 16px;
            padding: 20px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(19, 42, 70, 0.14);
        }

        .preview-top-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .preview-tag {
            display: inline-block;
            font-size: 10.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            padding: 4px 10px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.15);
            color: #BAE6FD;
        }

        .map-ext-link {
            font-size: 11.5px;
            font-weight: 700;
            color: #93C5FD;
            text-decoration: none;
        }

        .map-ext-link:hover {
            color: #ffffff;
            text-decoration: underline;
        }

        .preview-name {
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 4px;
        }

        .preview-loc {
            font-size: 13px;
            color: #CBD5E1;
            margin-bottom: 14px;
        }

        .preview-coords {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .coord-chip {
            background: rgba(255, 255, 255, 0.10);
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 10px;
            padding: 9px 12px;
        }

        .coord-chip span {
            display: block;
            font-size: 10px;
            text-transform: uppercase;
            color: #93C5FD;
            font-weight: 700;
        }

        .coord-chip strong {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: 13px;
            color: #ffffff;
        }

        .meta-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 12px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.85);
            border: 1px solid rgba(30, 58, 95, 0.08);
            font-size: 12.5px;
            margin-bottom: 8px;
        }

        .meta-row span {
            color: var(--text-muted);
            font-weight: 600;
        }

        .meta-row strong {
            color: var(--navy-deep);
            font-weight: 800;
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

        .coord-guide-box {
            margin-top: 12px;
            padding: 9px 12px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.85);
            border: 1px solid rgba(30, 58, 95, 0.08);
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: 11.5px;
            color: var(--navy-primary);
            font-weight: 700;
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

        @media (max-width: 1024px) {
            .workspace-grid, .bottom-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 860px) {
            body { flex-direction: column; }
            .sidebar { width: 100%; height: auto; position: static; }
            .form-grid-2 { grid-template-columns: 1fr; }
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
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                    Pembaruan Master Lokasi
                </div>
                <h1 class="hero-title">Edit Location</h1>
                <p class="hero-desc">Perbarui nama terminal pelabuhan, kota, negara, atau titik koordinat GPS untuk {{ $location->name }}</p>
            </div>

            <a href="{{ route('locations.index') }}" class="btn-hero-light">
                ← Kembali ke Daftar Locations
            </a>
        </div>

        <div class="workspace-grid">
            <!-- Left Form Card -->
            <div class="glass-card">
                <div class="card-head">
                    <div class="card-icon">
                        <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    </div>
                    <div>
                        <h2 class="card-title">Detail Pelabuhan / Lokasi Transit</h2>
                        <div class="card-sub">Perubahan akan langsung tersinkronisasi pada manifest shipment aktif</div>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="error-box">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('locations.update', $location->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label class="form-label">Nama Location</label>
                        <input type="text"
                               id="inputName"
                               name="name"
                               class="form-control"
                               value="{{ old('name', $location->name) }}"
                               required>
                    </div>

                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label">Kota</label>
                            <input type="text"
                                   id="inputCity"
                                   name="city"
                                   class="form-control"
                                   value="{{ old('city', $location->city) }}"
                                   required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Negara</label>
                            <input type="text"
                                   id="inputCountry"
                                   name="country"
                                   class="form-control"
                                   value="{{ old('country', $location->country) }}"
                                   required>
                        </div>
                    </div>

                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label">Latitude</label>
                            <input type="number"
                                   step="any"
                                   id="inputLat"
                                   name="latitude"
                                   class="form-control"
                                   value="{{ old('latitude', $location->latitude) }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Longitude</label>
                            <input type="number"
                                   step="any"
                                   id="inputLng"
                                   name="longitude"
                                   class="form-control"
                                   value="{{ old('longitude', $location->longitude) }}">
                        </div>
                    </div>

                    <div class="button-group">
                        <button type="submit" class="btn-submit">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                            Simpan Perubahan
                        </button>

                        <a href="{{ route('locations.index') }}" class="btn-back">
                            Kembali
                        </a>
                    </div>
                </form>
            </div>

            <!-- Right Live Preview & Metadata -->
            <div class="side-stack">
                <div class="preview-box">
                    <div class="preview-top-row">
                        <span class="preview-tag">Live Location Preview</span>
                        <a href="https://www.google.com/maps?q={{ $location->latitude }},{{ $location->longitude }}"
                           id="mapsExtLink"
                           target="_blank"
                           rel="noopener"
                           class="map-ext-link"
                           style="{{ (!is_null($location->latitude) && !is_null($location->longitude)) ? '' : 'display:none;' }}">
                            Buka di Maps ↗
                        </a>
                    </div>
                    <div class="preview-name" id="prevName">{{ $location->name }}</div>
                    <div class="preview-loc" id="prevPlace">{{ $location->city }}, {{ $location->country }}</div>
                    <div class="preview-coords">
                        <div class="coord-chip">
                            <span>Latitude</span>
                            <strong id="prevLat">{{ $location->latitude ?? '-' }}</strong>
                        </div>
                        <div class="coord-chip">
                            <span>Longitude</span>
                            <strong id="prevLng">{{ $location->longitude ?? '-' }}</strong>
                        </div>
                    </div>
                </div>

                <div class="glass-card" style="padding: 20px 22px; flex: 1;">
                    <div class="card-head" style="margin-bottom: 14px; padding-bottom: 12px;">
                        <div class="card-icon">
                            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                        </div>
                        <div>
                            <h3 class="card-title" style="font-size: 14.5px;">Metadata Titik Lokasi</h3>
                            <div class="card-sub">Informasi registrasi pada database master</div>
                        </div>
                    </div>

                    <div class="meta-row">
                        <span>ID Lokasi</span>
                        <strong>#{{ $location->id }}</strong>
                    </div>
                    <div class="meta-row">
                        <span>Kategori Terminal</span>
                        <strong>{{ str_contains(strtolower($location->name ?? ''), 'port') ? 'Maritime Seaport' : 'Logistics Warehouse' }}</strong>
                    </div>
                    <div class="meta-row" style="margin-bottom: 0;">
                        <span>Status GPS</span>
                        <strong style="color: {{ (!is_null($location->latitude) && !is_null($location->longitude)) ? 'var(--teal-pos)' : 'var(--amber-warn)' }};">
                            {{ (!is_null($location->latitude) && !is_null($location->longitude)) ? 'Terpetakan' : 'Belum Lengkap' }}
                        </strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom 3-Column Operational Cards -->
        <div class="bottom-grid">
            <div class="info-card">
                <div>
                    <div class="info-head">
                        <div class="info-icon">
                            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                        </div>
                        <div class="info-title">Format Koordinat Desimal</div>
                    </div>
                    <div class="info-body">
                        Gunakan format derajat desimal (DD) dengan tanda minus (<code>-</code>) untuk wilayah lintang selatan agar pin peta akurat.
                    </div>
                </div>
                <div class="coord-guide-box">
                    Lat: -6.1025000 &nbsp;|&nbsp; Lng: 106.8833000
                </div>
            </div>

            <div class="info-card">
                <div>
                    <div class="info-head">
                        <div class="info-icon">
                            <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                        </div>
                        <div class="info-title">Sinkronisasi Rute Shipment</div>
                    </div>
                    <div class="info-body">
                        Data lokasi ini terhubung sebagai titik <strong>Origin</strong> dan <strong>Destination</strong> pada seluruh manifest pengiriman dan riwayat <em>Tracking Events</em>.
                    </div>
                </div>
                <div style="margin-top: 12px; font-size: 11.5px; font-weight: 700; color: var(--teal-pos);">
                    ● Terhubung dengan modul Shipments &amp; Tracking
                </div>
            </div>

            <div class="info-card">
                <div>
                    <div class="info-head">
                        <div class="info-icon">
                            <svg viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                        </div>
                        <div class="info-title">Navigasi Cepat</div>
                    </div>
                    <div class="quick-links">
                        <a href="{{ route('locations.create') }}" class="q-link">
                            <span>+ Tambah Lokasi Baru</span>
                            <span>→</span>
                        </a>
                        <a href="{{ route('shipments.index') }}" class="q-link">
                            <span>Lihat Daftar Shipments</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Footer -->
        <footer class="page-footer">
            <div><strong>CargoTrace</strong> — Maritime Supply Visibility &amp; Global Port Network</div>
            <div>Sedang menyunting titik lokasi #{{ $location->id }} ({{ $location->city }})</div>
        </footer>
    </main>

    <script>
    const inputName    = document.getElementById('inputName');
    const inputCity    = document.getElementById('inputCity');
    const inputCountry = document.getElementById('inputCountry');
    const inputLat     = document.getElementById('inputLat');
    const inputLng     = document.getElementById('inputLng');
    const mapsExtLink  = document.getElementById('mapsExtLink');

    function syncPreview() {
        document.getElementById('prevName').textContent  = inputName.value.trim() || 'Nama Lokasi';
        const city    = inputCity.value.trim() || 'Kota';
        const country = inputCountry.value.trim() || 'Negara';
        const lat     = inputLat.value.trim();
        const lng     = inputLng.value.trim();

        document.getElementById('prevPlace').textContent = `${city}, ${country}`;
        document.getElementById('prevLat').textContent   = lat || '-';
        document.getElementById('prevLng').textContent   = lng || '-';

        if (mapsExtLink) {
            if (lat && lng) {
                mapsExtLink.style.display = '';
                mapsExtLink.href = `https://www.google.com/maps?q=${encodeURIComponent(lat)},${encodeURIComponent(lng)}`;
            } else {
                mapsExtLink.style.display = 'none';
            }
        }
    }

    [inputName, inputCity, inputCountry, inputLat, inputLng].forEach(el => {
        if (el) el.addEventListener('input', syncPreview);
    });
    </script>

</body>
</html>