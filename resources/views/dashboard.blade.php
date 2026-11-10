<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - CargoTrace</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f1f5f9;
            color: #1e293b;
        }

        .sidebar {
            width: 240px;
            height: 100vh;
            position: fixed;
            background: #0f172a;
            color: white;
            padding: 25px 15px;
        }

        .logo {
            font-size: 23px;
            font-weight: bold;
            margin-bottom: 40px;
            padding-left: 10px;
        }

        .menu-title {
            color: #94a3b8;
            font-size: 12px;
            margin: 20px 10px;
        }

        .menu a {
            display: block;
            padding: 13px 15px;
            color: #cbd5e1;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 5px;
        }

        .menu a.active,
        .menu a:hover {
            background: #2563eb;
            color: white;
        }

        .main {
            margin-left: 240px;
            padding: 30px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            gap: 15px;
        }

        .header h1 {
            font-size: 27px;
        }

        .header p {
            color: #64748b;
            margin-top: 8px;
        }

        .user {
            background: white;
            padding: 12px 18px;
            border-radius: 10px;
            font-weight: bold;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            padding: 22px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,.04);
        }

        .card p {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .card h2 {
            font-size: 30px;
            color: #1e293b;
        }

        .card .icon {
            font-size: 25px;
            margin-bottom: 12px;
        }

        .section {
            background: white;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 25px;
        }

        .section h2 {
            font-size: 20px;
            margin-bottom: 20px;
        }

        .empty {
            padding: 35px;
            text-align: center;
            color: #64748b;
            background: #f8fafc;
            border-radius: 8px;
        }

        .logout {
            margin-top: 30px;
        }

        .logout button {
            width: 100%;
            padding: 12px;
            background: #dc2626;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        @media (max-width: 900px) {
            .cards {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .sidebar {
                width: 70px;
                padding: 15px 5px;
            }

            .logo {
                font-size: 12px;
                padding: 0;
            }

            .menu a {
                font-size: 11px;
                padding: 12px 5px;
                text-align: center;
            }

            .menu-title {
                display: none;
            }

            .main {
                margin-left: 70px;
                padding: 15px;
            }

            .cards {
                grid-template-columns: 1fr;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>

    <div class="sidebar">

        <div class="logo">🚚 CargoTrace</div>

        <div class="menu-title">MENU UTAMA</div>


<div class="menu">
    <a href="/dashboard" class="active">📊 Dashboard</a>

    <a href="{{ route('shipments.index') }}">📦 Shipments</a>

    <a href="{{ route('tracking.index') }}">📍 Tracking</a>

    <a href="#">🚛 Carriers</a>

    <a href="#">🌍 Locations</a>

    <a href="{{ route('exceptions.index') }}">
        ⚠️ Exceptions
    </a>

    <a href="{{ route('users.index') }}">
        👥 Users
    </a>

    <a href="{{ route('reports.index') }}">
        📈 Reports
    </a>
</div>
</div>

    <div class="main">

        <div class="header">
            <div>
                <h1>Dashboard</h1>
                <p>Global Shipment Visibility & Tracking Platform</p>
            </div>

            <div class="user">
                {{ Auth::user()->name }}
            </div>
        </div>

        <div class="cards">

            <div class="card">
                <div class="icon">📦</div>
                <p>Total Shipments</p>
                <h2>—</h2>
            </div>

            <div class="card">
                <div class="icon">🚢</div>
                <p>In Transit</p>
                <h2>—</h2>
            </div>

            <div class="card">
                <div class="icon">✅</div>
                <p>Delivered</p>
                <h2>—</h2>
            </div>

            <div class="card">
                <div class="icon">⚠️</div>
                <p>Delayed Shipments</p>
                <h2>—</h2>
            </div>

        </div>

        <div class="section">
            <h2>Recent Shipments</h2>

            <div class="empty">
                Data shipment akan ditampilkan di sini.
            </div>
        </div>

        <div class="section">
            <h2>Shipment Tracking Overview</h2>

            <div class="empty">
                Informasi tracking dan lokasi pengiriman akan ditampilkan di sini.
            </div>
        </div>

    </div>

</body>
</html>