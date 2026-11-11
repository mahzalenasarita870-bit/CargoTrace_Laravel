<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tracking - CargoTrace</title>

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
            background: white;
            padding: 25px;
            border-radius: 12px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .btn {
            background: #2563eb;
            color: white;
            padding: 12px 18px;
            text-decoration: none;
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        th {
            background: #f8fafc;
        }

        .status {
            background: #dbeafe;
            color: #1d4ed8;
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: bold;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <div>
            <h1>📍 Shipment Tracking</h1>
            <p>Monitor perjalanan dan status pengiriman barang.</p>
        </div>

        <a href="{{ route('tracking.create') }}" class="btn">
            + Tambah Tracking
        </a>
    </div>
    <form action="{{ route('tracking.search') }}" method="GET"
      style="display:flex; gap:10px; margin-bottom:20px;">

    <input
        type="text"
        name="shipment_number"
        placeholder="Masukkan nomor shipment..."
        required
        style="padding:12px; border:1px solid #cbd5e1;
               border-radius:8px; flex:1;"
    >

    <button type="submit"
        style="background:#2563eb; color:white;
               padding:12px 18px; border:none;
               border-radius:8px; cursor:pointer;">
        Cari Shipment
    </button>

</form>

    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
    <div style="background:#fee2e2; color:#b91c1c;
                padding:12px; border-radius:8px;
                margin-bottom:20px;">
        {{ session('error') }}
    </div>
@endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Shipment Number</th>
                <th>Event</th>
                <th>Waktu</th>
                <th>Lokasi</th>
                <th>Deskripsi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($trackingEvents as $event)
                <tr>
                    <td>{{ $trackingEvents->firstItem() + $loop->index }}</td>

                    <td>
                        {{ $event->shipment->shipment_number ?? '-' }}
                    </td>

                    <td>
                        <span class="status">
                            {{ $event->event_type }}
                        </span>
                    </td>

                    <td>
                        {{ $event->event_time?->format('d-m-Y H:i') ?? '-' }}
                    </td>

                    <td>
                        {{ $event->location->name ?? '-' }}
                    </td>

                    <td>
                        {{ $event->description ?? '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:30px">
                        Belum ada data tracking.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:20px">
        {{ $trackingEvents->links() }}
    </div>

    <br>

    <a href="{{ route('dashboard') }}">← Kembali ke Dashboard</a>

</div>

</body>
</html>