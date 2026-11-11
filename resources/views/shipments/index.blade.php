
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
            padding: 30px;
        }

        .container {
            max-width: 1400px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }

        h2 {
            color: #1e293b;
        }

        .btn {
            display: inline-block;
            padding: 9px 14px;
            border: none;
            border-radius: 5px;
            color: white;
            text-decoration: none;
            font-size: 13px;
            cursor: pointer;
        }

        .btn-add {
            background: #2563eb;
        }

        .btn-edit {
            background: #f59e0b;
        }

        .btn-delete {
            background: #dc2626;
        }

        .btn-dashboard {
            background: #475569;
        }

        .alert {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            min-width: 1200px;
        }

        th, td {
            border: 1px solid #e2e8f0;
            padding: 12px;
            text-align: left;
            font-size: 13px;
        }

        th {
            background: #2563eb;
            color: white;
        }

        tr:nth-child(even) {
            background: #f8fafc;
        }

        .aksi {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .status {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
        }

        .created {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .in-transit {
            background: #fef3c7;
            color: #92400e;
        }

        .delivered {
            background: #dcfce7;
            color: #166534;
        }

        .cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .pagination {
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .container {
                padding: 15px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <h2>Shipment Management</h2>

        <div>
            <a href="{{ route('shipments.create') }}" class="btn btn-add">
                + Add Shipment
            </a>

            <a href="{{ route('dashboard') }}" class="btn btn-dashboard">
                Dashboard
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert">
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
                    <th>Expected Departure</th>
                    <th>Expected Arrival</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($shipments as $shipment)
                    <tr>
                        <td>
                            {{ $loop->iteration + ($shipments->currentPage() - 1) * $shipments->perPage() }}
                        </td>

                        <td>{{ $shipment->shipment_number }}</td>
                        <td>{{ $shipment->customer_name }}</td>
                        <td>{{ $shipment->carrier_name }}</td>
                        <td>{{ $shipment->origin_name }}</td>
                        <td>{{ $shipment->destination_name }}</td>
                        <td>{{ $shipment->cargo_type }}</td>
                        <td>{{ $shipment->weight ?? '-' }}</td>

                        <td>
                            {{ $shipment->expected_departure ? \Carbon\Carbon::parse($shipment->expected_departure)->format('d-m-Y H:i') : '-' }}
                        </td>

                        <td>
                            {{ $shipment->expected_arrival ? \Carbon\Carbon::parse($shipment->expected_arrival)->format('d-m-Y H:i') : '-' }}
                        </td>

                        <td>
                            @php
                                $statusClass = match(strtoupper($shipment->current_status)) {
                                    'CREATED' => 'created',
                                    'IN_TRANSIT' => 'in-transit',
                                    'DELIVERED' => 'delivered',
                                    'CANCELLED' => 'cancelled',
                                    default => 'created',
                                };
                            @endphp

                            <span class="status {{ $statusClass }}">
                                {{ str_replace('_', ' ', $shipment->current_status) }}
                            </span>
                        </td>

                        <td>
                            <div class="aksi">

                                <a href="{{ route('shipments.edit', $shipment->id) }}"
                                   class="btn btn-edit">
                                    Edit
                                </a>

                                <form action="{{ route('shipments.destroy', $shipment->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus shipment ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-delete">
                                        Delete
                                    </button>

                                </form>

                            </div>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="12" style="text-align:center;">
                            Belum ada data shipment.
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

</body>
</html>
