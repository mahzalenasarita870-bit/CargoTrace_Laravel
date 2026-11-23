<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - CargoTrace</title>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: #0f172a;
            color: #f8fafc;
            display: flex;
            flex-direction: column;
            padding: 24px 16px;
            flex-shrink: 0;
        }

        .brand {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 6px;
            color: #38bdf8;
        }

        .role-badge {
            display: inline-block;
            background: #1e293b;
            color: #94a3b8;
            font-size: 11px;
            padding: 4px 10px;
            border-radius: 12px;
            text-transform: uppercase;
            margin-bottom: 24px;
            width: fit-content;
        }

        .nav-link {
            display: block;
            color: #cbd5e1;
            text-decoration: none;
            padding: 11px 14px;
            border-radius: 8px;
            margin-bottom: 6px;
            font-size: 14px;
            transition: background 0.2s;
        }

        .nav-link:hover, .nav-link.active {
            background: #1e293b;
            color: #ffffff;
            font-weight: bold;
        }

        .logout-form {
            margin-top: auto;
        }

        .btn-logout {
            width: 100%;
            padding: 10px;
            background: #dc2626;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
        }

        /* Main Content */
        .main {
            flex: 1;
            padding: 30px;
            overflow-x: auto;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .topbar h1 {
            font-size: 26px;
            color: #0f172a;
        }

        .topbar p {
            color: #64748b;
            font-size: 14px;
            margin-top: 4px;
        }

        /* KPI Cards */
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px;
            margin-bottom: 26px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            border: 1px solid #e2e8f0;
        }

        .card .icon {
            font-size: 24px;
            margin-bottom: 8px;
        }

        .card p {
            color: #64748b;
            font-size: 13px;
            margin-bottom: 6px;
        }

        .card h2 {
            font-size: 28px;
            color: #0f172a;
        }

        .card small {
            display: block;
            margin-top: 6px;
            font-size: 12px;
            color: #64748b;
        }

        .card.danger h2 { color: #dc2626; }
        .card.warning h2 { color: #d97706; }
        .card.success h2 { color: #16a34a; }
        .card.info h2 { color: #2563eb; }

        /* Charts Section */
        .charts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
            gap: 20px;
            margin-bottom: 26px;
        }

        .panel {
            background: white;
            padding: 22px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            border: 1px solid #e2e8f0;
        }

        .panel h3 {
            font-size: 16px;
            margin-bottom: 16px;
            color: #0f172a;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        th, td {
            padding: 12px 14px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        th {
            background: #f8fafc;
            color: #475569;
            font-size: 12px;
            text-transform: uppercase;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 14px;
            font-size: 11px;
            font-weight: bold;
        }

        .badge-blue { background: #dbeafe; color: #1d4ed8; }
        .badge-red { background: #fee2e2; color: #b91c1c; }
        .badge-green { background: #dcfce7; color: #15803d; }

        .btn-detail {
            display: inline-block;
            padding: 6px 12px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 12px;
        }

        @media (max-width: 768px) {
            body { flex-direction: column; }
            .sidebar { width: 100%; }
        }
    </style>
</head>
<body>

    <!-- Sidebar Navigation -->
    <aside class="sidebar">
        <div class="brand">🚢 CargoTrace</div>
        <span class="role-badge">{{ auth()->user()->role ?? 'user' }}</span>

        <a href="{{ route('dashboard') }}" class="nav-link active">📊 Dashboard</a>
        <a href="{{ route('shipments.index') }}" class="nav-link">📦 Shipments</a>
        <a href="{{ route('notifications.index') }}" class="nav-link">🔔 Notifications</a>

        @if(auth()->user()->hasRole(['admin', 'operator']))
            <a href="{{ route('tracking.index') }}" class="nav-link">📍 Tracking Events</a>
            <a href="{{ route('exceptions.index') }}" class="nav-link">🚨 Exceptions</a>
            <a href="{{ route('reports.index') }}" class="nav-link">📑 Reports</a>
        @endif

        @if(auth()->user()->isAdmin())
            <a href="{{ route('carriers.index') }}" class="nav-link">🚢 Carriers</a>
            <a href="{{ route('locations.index') }}" class="nav-link">🗺️ Locations</a>
            <a href="{{ route('users.index') }}" class="nav-link">👥 Users</a>
            <a href="{{ route('audit-logs.index') }}" class="nav-link">🛡️ Audit Logs</a>
        @endif

        <form action="{{ route('logout') }}" method="POST" class="logout-form">
            @csrf
            <button type="submit" class="btn-logout">Logout</button>
        </form>
    </aside>

    <!-- Main Dashboard Area -->
    <main class="main">
        <div class="topbar">
            <div>
                <h1>Operational Overview</h1>
                <p>Selamat datang, <strong>{{ auth()->user()->name }}</strong>. Ringkasan visibilitas pengiriman terkini.</p>
            </div>
            @if(auth()->user()->hasRole(['admin', 'operator']))
                <a href="{{ route('shipments.create') }}" class="btn-detail" style="padding: 10px 16px; font-size: 14px;">
                    + Buat Shipment Baru
                </a>
            @endif
        </div>

        <!-- KPI Summary Cards -->
        <div class="cards">
            <div class="card">
                <div class="icon">📦</div>
                <p>Total Shipments</p>
                <h2>{{ $totalShipments }}</h2>
                <small>Seluruh pengiriman terdaftar</small>
            </div>

            <div class="card info">
                <div class="icon">🚢</div>
                <p>In Transit</p>
                <h2>{{ $inTransit }}</h2>
                <small>Sedang dalam perjalanan</small>
            </div>

            <div class="card success">
                <div class="icon">✅</div>
                <p>Delivered</p>
                <h2>{{ $delivered }}</h2>
                <small>Tiba di tujuan</small>
            </div>

            <div class="card danger">
                <div class="icon">⚠️</div>
                <p>Delayed Shipments</p>
                <h2>{{ $delayed }}</h2>
                <small>Delay Rate: <strong>{{ $delayRate }}%</strong></small>
            </div>

            <div class="card warning">
                <div class="icon">🚨</div>
                <p>Open Exceptions</p>
                <h2>{{ $openExceptions }}</h2>
                <small>Exception Rate: <strong>{{ $exceptionRate }}%</strong></small>
            </div>
        </div>

        <!-- Analytics Charts -->
        <div class="charts-grid">
            <div class="panel">
                <h3>📈 Distribusi Shipment berdasarkan Status</h3>
                <canvas id="statusChart" height="180"></canvas>
            </div>

            <div class="panel">
                <h3>🚢 Distribusi Shipment berdasarkan Carrier</h3>
                <canvas id="carrierChart" height="180"></canvas>
            </div>
        </div>

        <!-- Recent Shipments Table -->
        <div class="panel">
            <h3>🕒 Pengiriman Terbaru</h3>
            @if($recentShipments->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Shipment No.</th>
                            <th>Customer</th>
                            <th>Carrier</th>
                            <th>Rute (Origin → Dest)</th>
                            <th>Status</th>
                            <th>ETA / Delay</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentShipments as $item)
                            <tr>
                                <td><strong>{{ $item->shipment_number }}</strong></td>
                                <td>{{ $item->customer->name ?? '-' }}</td>
                                <td>{{ $item->carrier->name ?? '-' }}</td>
                                <td>{{ $item->origin->city ?? '-' }} → {{ $item->destination->city ?? '-' }}</td>
                                <td>
                                    <span class="badge badge-blue">
                                        {{ str_replace('_', ' ', $item->current_status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($item->is_delayed)
                                        <span class="badge badge-red">Delayed ({{ $item->delay_hours }}h)</span>
                                    @else
                                        <span class="badge badge-green">On Schedule</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('shipments.show', $item->id) }}" class="btn-detail">Detail & Peta</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="color: #64748b; font-size: 14px;">Belum ada data pengiriman.</p>
            @endif
        </div>
    </main>

    <!-- Chart.js Initialization -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusLabels = @json(array_keys($byStatus));
            const statusCounts = @json(array_values($byStatus));

            const statusCtx = document.getElementById('statusChart').getContext('2d');
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: statusLabels.length ? statusLabels : ['No Data'],
                    datasets: [{
                        data: statusCounts.length ? statusCounts : [1],
                        backgroundColor: ['#3b82f6', '#0ea5e9', '#f59e0b', '#10b981', '#6366f1', '#ef4444'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });

            const carrierLabels = @json(array_keys($byCarrier));
            const carrierCounts = @json(array_values($byCarrier));

            const carrierCtx = document.getElementById('carrierChart').getContext('2d');
            new Chart(carrierCtx, {
                type: 'bar',
                data: {
                    labels: carrierLabels.length ? carrierLabels : ['No Data'],
                    datasets: [{
                        label: 'Jumlah Shipments',
                        data: carrierCounts.length ? carrierCounts : [0],
                        backgroundColor: '#2563eb',
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0 }
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        });
    </script>

</body>
</html>