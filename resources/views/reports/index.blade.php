<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - CargoTrace</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            padding: 30px;
            color: #1e293b;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .subtitle {
            color: #64748b;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 5px #00000008;
        }

        .card p {
            color: #64748b;
            font-size: 13px;
        }

        .card h2 {
            font-size: 28px;
            margin: 10px 0;
        }

        .content {
            background: white;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        input, select {
            padding: 10px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            margin-right: 8px;
        }

        button {
            background: #2563eb;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 7px;
            cursor: pointer;
        }

        .reset {
            color: #2563eb;
            text-decoration: none;
            margin-left: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 13px;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
        }

        th {
            background: #f8fafc;
        }

        .badge {
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: bold;
        }

        .created {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .in_transit {
            background: #fef3c7;
            color: #92400e;
        }

        .delivered {
            background: #dcfce7;
            color: #166534;
        }

        .delayed {
            background: #fee2e2;
            color: #b91c1c;
        }

        .back {
            display: inline-block;
            margin-top: 20px;
            color: #2563eb;
            text-decoration: none;
        }

        @media(max-width: 900px) {
            .cards {
                grid-template-columns: repeat(2, 1fr);
            }

            .content {
                overflow-x: auto;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <div>


<div class="header">
    <div>
        <h1>📊 Shipment Reports</h1>
        <p class="subtitle">
            Laporan dan rekapitulasi pengiriman CargoTrace.
        </p>
    </div>

    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
        <a href="{{ route('reports.exportPdf', request()->query()) }}"
           style="display: inline-block;
                  padding: 10px 20px;
                  background: #dc2626;
                  color: white;
                  text-decoration: none;
                  border-radius: 7px;">
            📄 Export PDF
        </a>

        <a href="{{ route('reports.exportExcel', request()->query()) }}"
           style="display: inline-block;
                  padding: 10px 20px;
                  background: #16a34a;
                  color: white;
                  text-decoration: none;
                  border-radius: 7px;">
            📊 Export Excel
        </a>
    </div>
</div>


    <div class="cards">

        <div class="card">
            <p>📦 Total Shipments</p>
            <h2>{{ $totalShipments }}</h2>
        </div>

        <div class="card">
            <p>📝 Created</p>
            <h2>{{ $created }}</h2>
        </div>

        <div class="card">
            <p>🚚 In Transit</p>
            <h2>{{ $inTransit }}</h2>
        </div>

        <div class="card">
            <p>✅ Delivered</p>
            <h2>{{ $delivered }}</h2>
        </div>

        <div class="card">
            <p>⚠️ Delayed</p>
            <h2>{{ $delayed }}</h2>
        </div>

    </div>

    <div class="content">

        <h3>Filter Laporan</h3>

        <form action="{{ route('reports.index') }}" method="GET">

            <select name="status">
                <option value="">Semua Status</option>

                @foreach([
                    'CREATED',
                    'IN_TRANSIT',
                    'DELIVERED',
                    'DELAYED'
                ] as $status)
                    <option value="{{ $status }}"
                        {{ request('status') == $status ? 'selected' : '' }}
                        {{ $status }}
                    </option>
                @endforeach
            </select>

            <input
                type="date"
                name="start_date"
                value="{{ request('start_date') }}"
            >

            <input
                type="date"
                name="end_date"
                value="{{ request('end_date') }}"
            >

            <button type="submit">Filter</button>

            <a href="{{ route('reports.index') }}" class="reset">
                Reset
            </a>

        </form>

        <h3 style="margin-top:30px">Data Pengiriman</h3>

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
                        <td>
                            {{ $shipments->firstItem() + $loop->index }}
                        </td>

                        <td>
                            {{ $shipment->shipment_number }}
                        </td>

                        <td>
                            {{ $shipment->cargo_type }}
                        </td>

                        <td>
                            {{ $shipment->weight ?? '-' }}
                        </td>

                        <td>
                            <span class="badge {{ strtolower($shipment->current_status) }}">
                                {{ $shipment->current_status }}
                            </span>
                        </td>

                        <td>
                            {{ $shipment->expected_arrival
                                ? \Carbon\Carbon::parse($shipment->expected_arrival)->format('d-m-Y H:i')
                                : '-' }}
                        </td>

                        <td>
                            {{ $shipment->created_at?->format('d-m-Y') ?? '-' }}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="7" style="text-align:center;padding:30px">
                            Belum ada data pengiriman.
                        </td>
                    </tr>

                @endforelse

            </tbody>
        </table>

        <div style="margin-top:20px">
            {{ $shipments->links() }}
        </div>

    </div>

    <a href="{{ route('dashboard') }}" class="back">
        ← Kembali ke Dashboard
    </a>

</div>

</body>
</html>