
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipments - CargoTrace</title>

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
            padding: 30px;
        }

        .container {
            max-width: 1400px;
            margin: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            gap: 15px;
        }

        .header h1 {
            font-size: 28px;
        }

        .header p {
            color: #64748b;
            margin-top: 8px;
        }

        .btn {
            display: inline-block;
            padding: 12px 18px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background: #1d4ed8;
        }

        .btn-back {
            background: #64748b;
        }

        .section {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,.04);
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 14px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1000px;
        }

        th {
            background: #f8fafc;
            text-align: left;
            padding: 15px;
            font-size: 13px;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 13px;
        }

        .status {
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            display: inline-block;
        }

        .created {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .booked {
            background: #ede9fe;
            color: #6d28d9;
        }

        .picked_up {
            background: #fef3c7;
            color: #92400e;
        }

        .in_transit {
            background: #ffedd5;
            color: #c2410c;
        }

        .delivered {
            background: #dcfce7;
            color: #166534;
        }

        .empty {
            text-align: center;
            padding: 35px;
            color: #64748b;
        }

        .pagination {
            margin-top: 20px;
        }

        @media(max-width: 600px) {
            body {
                padding: 15px;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <div>
            <h1>📦 Shipment Management</h1>
            <p>Kelola seluruh data pengiriman CargoTrace.</p>
        </div>

        <div>
            <a href="{{ route('dashboard') }}" class="btn btn-back">
                ← Dashboard
            </a>

            <a href="{{ route('shipments.create') }}" class="btn">
                + Tambah Shipment
            </a>
        </div>
    </div>

    <div class="section">

        @if(session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-wrapper">

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Shipment Number</th>
                        <th>Customer</th>
                        <th>Carrier</th>
                        <th>Origin</th>
                        <th>Destination</th>
                        <th>Cargo Type</th>
                        <th>Weight (kg)</th>
                        <th>Status</th>
                        <th>Expected Arrival</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($shipments as $shipment)

                        <tr>
                            <td>
                                {{ $shipments->firstItem() + $loop->index }}
                            </td>

                            <td>
                                <strong>
                                    {{ $shipment->shipment_number }}
                                </strong>
                            </td>

                            <td>
                                {{ $shipment->customer->name ?? '-' }}
                            </td>

                            <td>
                                {{ $shipment->carrier->name ?? '-' }}
                            </td>

                            <td>
                                {{ $shipment->origin->name ?? '-' }}
                            </td>

                            <td>
                                {{ $shipment->destination->name ?? '-' }}
                            </td>

                            <td>
                                {{ $shipment->cargo_type }}
                            </td>

                            <td>
                                {{ $shipment->weight ?? '-' }}
                            </td>

                            <td>
                                <span class="status {{ strtolower($shipment->current_status) }}">
                                    {{ str_replace('_', ' ', $shipment->current_status) }}
                                </span>
                            </td>

                            <td>
                                {{ $shipment->expected_arrival
                                    ? \Carbon\Carbon::parse($shipment->expected_arrival)->format('d-m-Y H:i')
                                    : '-' }}
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="10" class="empty">
                                Belum ada data shipment.
                                Silakan tambahkan data pengiriman.
                            </td>
                        </tr>

                    @endforelse

                </tbody>
            </table>

        </div>

        <div class="pagination">
            {{ $shipments->links() }}
        </div>

    </div>

</div>

</body>
</html>
