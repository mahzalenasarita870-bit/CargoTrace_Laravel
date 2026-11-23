<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipment Management - CargoTrace</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body { background: #f1f5f9; color: #1e293b; padding: 30px; }
        .container {
            max-width: 1200px; margin: auto; background: white; padding: 28px;
            border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,.05);
        }
        .header {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 22px; flex-wrap: wrap; gap: 12px;
        }
        h1 { font-size: 24px; color: #0f172a; }
        .header-actions { display: flex; gap: 8px; }
        .btn {
            display: inline-block; padding: 9px 15px; border-radius: 6px;
            text-decoration: none; font-size: 13px; font-weight: bold;
            border: none; cursor: pointer;
        }
        .btn-primary { background: #2563eb; color: white; }
        .btn-dark { background: #475569; color: white; }
        .btn-info { background: #0284c7; color: white; padding: 6px 11px; font-size: 12px; }
        .btn-warning { background: #f59e0b; color: white; padding: 6px 11px; font-size: 12px; }
        .btn-danger { background: #dc2626; color: white; padding: 6px 11px; font-size: 12px; }
        .alert-success {
            background: #dcfce7; color: #166534; padding: 12px 16px;
            border-radius: 8px; margin-bottom: 18px; font-size: 14px;
        }
        .table-wrapper { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th {
            background: #2563eb; color: white; text-align: left;
            padding: 12px 10px; font-weight: bold;
        }
        td { padding: 12px 10px; border-bottom: 1px solid #e2e8f0; vertical-align: middle; }
        tr:hover { background: #f8fafc; }
        .shipment-link {
            color: #2563eb; font-weight: bold; text-decoration: none;
        }
        .shipment-link:hover { text-decoration: underline; }
        .badge {
            display: inline-block; padding: 5px 10px; border-radius: 20px;
            font-size: 11px; font-weight: bold; white-space: nowrap;
        }
        .badge-CREATED { background: #e2e8f0; color: #334155; }
        .badge-IN_TRANSIT { background: #fef3c7; color: #b45309; }
        .badge-AT_PORT { background: #dbeafe; color: #1d4ed8; }
        .badge-CUSTOMS_HOLD { background: #fee2e2; color: #b91c1c; }
        .badge-DELIVERED { background: #dcfce7; color: #15803d; }
        .badge-CANCELLED { background: #f1f5f9; color: #64748b; }
        .action-group { display: flex; flex-direction: column; gap: 5px; }
        .pagination { margin-top: 18px; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Shipment Management</h1>
        <div class="header-actions">
            @if(!auth()->user()->isCustomer())
                <a href="{{ route('shipments.create') }}" class="btn btn-primary">+ Add Shipment</a>
            @endif
            <a href="{{ route('dashboard') }}" class="btn btn-dark">Dashboard</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
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
                @forelse($shipments as $index => $shipment)
                    <tr>
                        <td>{{ $shipments->firstItem() + $index }}</td>
                        <td>
                            <a href="{{ route('shipments.show', $shipment->id) }}" class="shipment-link">
                                {{ $shipment->shipment_number }}
                            </a>
                        </td>
                        <td>{{ $shipment->customer->name ?? '-' }}</td>
                        <td>{{ $shipment->carrier->name ?? '-' }}</td>
                        <td>{{ $shipment->origin->name ?? $shipment->originLocation->name ?? '-' }}</td>
                        <td>{{ $shipment->destination->name ?? $shipment->destinationLocation->name ?? '-' }}</td>
                        <td>{{ $shipment->cargo_type }}</td>
                        <td>{{ number_format((float) $shipment->weight, 2) }}</td>
                        <td>{{ $shipment->expected_departure ? \Carbon\Carbon::parse($shipment->expected_departure)->format('d-m-Y H:i') : '-' }}</td>
                        <td>{{ $shipment->expected_arrival ? \Carbon\Carbon::parse($shipment->expected_arrival)->format('d-m-Y H:i') : '-' }}</td>
                        <td>
                            <span class="badge badge-{{ $shipment->current_status }}">
                                {{ str_replace('_', ' ', $shipment->current_status) }}
                            </span>
                        </td>
                        <td>
                            <div class="action-group">
                                <a href="{{ route('shipments.show', $shipment->id) }}" class="btn btn-info">Detail</a>

                                @if(!auth()->user()->isCustomer())
                                    <a href="{{ route('shipments.edit', $shipment->id) }}" class="btn btn-warning">Edit</a>
                                    <form action="{{ route('shipments.destroy', $shipment->id) }}" method="POST" onsubmit="return confirm('Hapus shipment ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" style="width:100%;">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" style="text-align:center; padding: 30px; color: #64748b;">
                            Belum ada data shipment terdaftar.
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