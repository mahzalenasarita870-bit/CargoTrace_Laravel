
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan CargoTrace</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }

        h2 {
            text-align: center;
            color: #1e3a8a;
        }

        p {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #999;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #1e3a8a;
            color: white;
        }

        .summary {
            margin-top: 15px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <h2>LAPORAN PENGIRIMAN CARGOTRACE</h2>
    <p>Sistem Logistik dan Pelacakan Pengiriman</p>

    <div class="summary">
        Total Pengiriman: {{ $totalShipments }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No. Pengiriman</th>
                <th>Pelanggan</th>
                <th>Kurir</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($shipments as $shipment)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $shipment->shipment_number }}</td>
                    <td>{{ $shipment->customer->name ?? '-' }}</td>
                    <td>{{ $shipment->carrier->name ?? '-' }}</td>
                    <td>{{ $shipment->current_status }}</td>
                    <td>{{ $shipment->created_at->format('d-m-Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">
                        Tidak ada data pengiriman.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
