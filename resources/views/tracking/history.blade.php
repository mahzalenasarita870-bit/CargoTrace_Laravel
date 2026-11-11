
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tracking History - CargoTrace</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            padding: 30px;
            color: #1e293b;
        }

        .container {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
        }

        .shipment-info {
            background: #f8fafc;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .timeline {
            border-left: 3px solid #2563eb;
            margin-left: 10px;
            padding-left: 25px;
        }

        .event {
            position: relative;
            margin-bottom: 30px;
        }

        .event::before {
            content: "";
            position: absolute;
            left: -34px;
            top: 5px;
            width: 14px;
            height: 14px;
            background: #2563eb;
            border-radius: 50%;
        }

        .status {
            color: #2563eb;
            font-weight: bold;
        }

        .date {
            color: #64748b;
            font-size: 13px;
            margin-bottom: 8px;
        }

        .description {
            margin-top: 8px;
        }

        .btn {
            display: inline-block;
            background: #2563eb;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 8px;
            margin-top: 20px;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>📍 Tracking History</h1>
    <p>Riwayat perjalanan shipment CargoTrace.</p>

    <div class="shipment-info">
        <h3>Shipment Information</h3>

        <p>
            <strong>Shipment Number:</strong>
            {{ $shipment->shipment_number }}
        </p>

        <p>
            <strong>Status:</strong>
            {{ $shipment->status }}
        </p>
    </div>

    <h3>Perjalanan Paket</h3>

    <div class="timeline">

        @forelse($trackingEvents as $event)

            <div class="event">

                <div class="date">
                    {{ $event->event_time?->format('d-m-Y H:i') ?? '-' }}
                </div>

                <div class="status">
                    {{ $event->event_type }}
                </div>

                <p>
                    <strong>Lokasi:</strong>
                    {{ $event->location->name ?? '-' }}
                </p>

                <div class="description">
                    {{ $event->description ?? 'Tidak ada deskripsi.' }}
                </div>

            </div>

        @empty

            <p>Belum ada riwayat tracking untuk shipment ini.</p>

        @endforelse

    </div>

    <a href="{{ route('tracking.index') }}" class="btn">
        ← Kembali ke Tracking
    </a>

</div>

</body>
</html>
