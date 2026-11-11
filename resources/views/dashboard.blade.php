<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - CargoTrace</title>

    <style>
            .search-container {
        margin: 20px 0;
        display: flex;
        justify-content: flex-end;
    }

    .search-container input {
        width: 300px;
        padding: 10px 15px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        outline: none;
        font-size: 14px;
        background: #ffffff;
    }

    .search-container input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    @media (max-width: 600px) {
        .search-container input {
            width: 100%;
        }
    }
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
            overflow-y: auto;
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
            font-size: 30px;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.5px;
        }

        .header p {
            color: #64748b;
            margin-top: 8px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .user {
            background: white;
            padding: 12px 18px;
            border-radius: 10px;
            font-weight: bold;
        }

        .logout-button {
            padding: 12px 18px;
            background: #dc2626;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
        }

        .logout-button:hover {
            background: #b91c1c;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            padding: 24px;
            border-radius: 14px;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05);
            border: 1px solid #e2e8f0;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.10);
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
            padding: 28px;
            border-radius: 14px;
            margin-bottom: 25px;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.04);
            border: 1px solid #e2e8f0;
        }

        .section h2 {
            font-size: 20px;
            margin-bottom: 20px;
        }

        .section-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .section-heading h2 {
            margin-bottom: 0;
        }

        .view-all-btn {
            padding: 10px 16px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .view-all-btn:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.25);
        }

        .empty {
            padding: 35px;
            text-align: center;
            color: #64748b;
            background: #f8fafc;
            border-radius: 8px;
        }

        /* Recent Shipments Table */
        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        thead tr {
            background: #f1f5f9;
            text-align: left;
        }

        thead th {
            padding: 14px 12px;
            color: #475569;
            font-size: 13px;
            font-weight: bold;
            border-bottom: 2px solid #e2e8f0;
            white-space: nowrap;
        }

        tbody td {
            padding: 14px 12px;
            font-size: 13px;
            color: #334155;
            white-space: nowrap;
        }

        tbody tr {
            border-bottom: 1px solid #e2e8f0;
            transition: background 0.2s ease;
        }

        tbody tr:hover {
            background: #f8fafc;
        }

        @media (max-width: 1100px) {
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
                text-align: center;
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
                gap: 15px;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
            }

            .header h1 {
                font-size: 25px;
            }

            .header-actions {
                gap: 10px;
            }

            .section {
                padding: 18px;
            }
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <div class="logo">🚚 CargoTrace</div>

        <div class="menu-title">MENU UTAMA</div>

        <div class="menu">
            <a href="{{ route('dashboard') }}" class="active">📊 Dashboard</a>
            <a href="{{ route('shipments.index') }}">📦 Shipments</a>
            <a href="{{ route('tracking.index') }}">📍 Tracking</a>
            <a href="{{ route('carriers.index') }}">🚛 Carriers</a>
            <a href="{{ route('locations.index') }}">🌍 Locations</a>
            <a href="{{ route('exceptions.index') }}">⚠️ Exceptions</a>
            <a href="{{ route('users.index') }}">👥 Users</a>
            <a href="{{ route('reports.index') }}">📈 Reports</a>
        </div>
    </div>

    <div class="main">

        <div class="header">
            <div>
                <h1>Dashboard</h1>
                <p>Global Shipment Visibility & Tracking Platform</p>

                <p style="margin-top: 8px; color: #2563eb; font-weight: bold;">
                    📅 {{ now()->format('d F Y') }}
                </p>
            </div>

            <div class="header-actions">
                <div class="user">
                    👤 {{ Auth::user()->name }}
                </div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-button">
                        🚪 Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Statistik Pengiriman -->
        <div class="cards">

            <div class="card">
                <div class="icon">📦</div>
                <p>Total Shipments</p>
                <h2>{{ $totalShipments }}</h2>
            </div>

            <div class="card">
                <div class="icon">🚢</div>
                <p>In Transit</p>
                <h2>{{ $inTransit }}</h2>
            </div>

            <div class="card">
                <div class="icon">✅</div>
                <p>Delivered</p>
                <h2>{{ $delivered }}</h2>
            </div>

            <div class="card">
                <div class="icon">⚠️</div>
                <p>Delayed Shipments</p>
                <h2>{{ $delayed }}</h2>
            </div>

        </div>

        <!-- Recent Shipments -->
        <div class="section">

            <div class="section-heading">
                <h2>Recent Shipments</h2>
                <div class="search-container">
                <input
                    type="text"
                    id="shipmentSearch"
                    placeholder="Search shipment..."
                >
            </div>

                <a href="{{ route('shipments.index') }}" class="view-all-btn">
                    View All Shipments →
                </a>
            </div>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Shipment Number</th>
                            <th>Cargo Type</th>
                            <th>Customer</th>
                            <th>Carrier</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($recentShipments as $shipment)
                            <tr>
                                <td>{{ $shipment->shipment_number }}</td>
                                <td>{{ $shipment->cargo_type }}</td>
                                <td>{{ $shipment->customer->name ?? '-' }}</td>
                                <td>{{ $shipment->carrier->name ?? '-' }}</td>

                                <td>
                                    @php
                                        $status = strtoupper($shipment->current_status);

                                        $statusColors = [
                                            'CREATED' => '#64748b',
                                            'IN_TRANSIT' => '#2563eb',
                                            'DELIVERED' => '#16a34a',
                                            'DELAYED' => '#dc2626',
                                        ];

                                        $statusColor = $statusColors[$status] ?? '#64748b';
                                    @endphp

                                    <span style="
                                        background: {{ $statusColor }}20;
                                        color: {{ $statusColor }};
                                        padding: 6px 12px;
                                        border-radius: 20px;
                                        font-size: 12px;
                                        font-weight: bold;
                                        display: inline-block;
                                    ">
                                        {{ $status }}
                                    </span>
                                </td>

                                <td>{{ $shipment->created_at?->format('d-m-Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="padding: 20px; text-align: center; color: #64748b;">
                                    Belum ada data pengiriman.
                                </td>
                            </tr>
                        @endforelse
                                <tr id="noSearchResults" style="display: none;">
                        <td colspan="6" style="padding: 20px; text-align: center; color: #64748b;">
                            Shipment tidak ditemukan.
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Shipment Tracking Overview -->
        <div class="section">
            <h2>Shipment Tracking Overview</h2>

            <div style="width: 100%; max-width: 700px; margin: auto;">
                <canvas id="shipmentChart"></canvas>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('shipmentChart');

        new Chart(ctx, {
            type: 'doughnut',

            plugins: [{
                id: 'centerText',
                afterDraw(chart) {
                    const { ctx, chartArea } = chart;

                    if (!chartArea) return;

                    ctx.save();
                    ctx.font = 'bold 24px Arial';
                    ctx.fillStyle = '#0f172a';
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';

                    ctx.fillText(
                        '{{ $totalShipments }}',
                        (chartArea.left + chartArea.right) / 2,
                        (chartArea.top + chartArea.bottom) / 2
                    );

                    ctx.restore();
                }
            }],

            data: {
                labels: ['In Transit', 'Delivered', 'Delayed', 'Created'],

                datasets: [{
                    data: [
                        {{ $inTransit }},
                        {{ $delivered }},
                        {{ $delayed }},
                        {{ \App\Models\Shipment::where('current_status', 'CREATED')->count() }}
                    ],

                    backgroundColor: [
                        '#2563eb',
                        '#16a34a',
                        '#dc2626',
                        '#94a3b8'
                    ],

                    borderWidth: 0,
                    hoverOffset: 8
                }]
            },

            options: {
                responsive: true,
                maintainAspectRatio: true,
                cutout: '65%',

                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',

                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                }
            }
        });
    </script>
<script>
    const shipmentSearch = document.getElementById('shipmentSearch');
    const noSearchResults = document.getElementById('noSearchResults');

    if (shipmentSearch && noSearchResults) {
        shipmentSearch.addEventListener('input', function () {
            let searchValue = this.value.toLowerCase().trim();

            let tableRows = document.querySelectorAll(
                '.table-wrapper tbody tr:not(#noSearchResults)'
            );

            let found = 0;

            tableRows.forEach(function (row) {
                let rowText = row.textContent.toLowerCase();

                if (rowText.includes(searchValue)) {
                    row.style.display = '';
                    found++;
                } else {
                    row.style.display = 'none';
                }
            });

            if (found === 0 && searchValue !== '') {
                noSearchResults.style.display = '';
            } else {
                noSearchResults.style.display = 'none';
            }
        });
    }
</script>


</body>
</html>