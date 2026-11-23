<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Shipment - CargoTrace</title>

    <!-- Leaflet.js CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

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
            max-width: 960px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,.04);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            gap: 15px;
        }

        h1 {
            font-size: 26px;
        }

        h2 {
            font-size: 18px;
            margin-top: 30px;
            margin-bottom: 14px;
            padding-bottom: 8px;
            border-bottom: 1px solid #e2e8f0;
            color: #0f172a;
        }

        .subtitle {
            color: #64748b;
            margin-top: 6px;
            font-size: 14px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .item {
            padding: 16px;
            background: #f8fafc;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .item label {
            display: block;
            color: #64748b;
            font-size: 12px;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .item p {
            font-weight: bold;
            font-size: 15px;
            word-break: break-word;
        }

        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .status-normal {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .status-delayed {
            background: #fee2e2;
            color: #b91c1c;
        }

        .status-ontime {
            background: #dcfce7;
            color: #15803d;
        }

        .alert-box {
            margin-top: 18px;
            padding: 14px 18px;
            border-radius: 8px;
            font-size: 14px;
            line-height: 1.5;
        }

        .alert-danger {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        .alert-info {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1e40af;
        }

        .map-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 30px;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid #e2e8f0;
        }

        .map-header h2 {
            margin: 0;
            padding: 0;
            border: none;
        }

        .map-legend {
            display: flex;
            gap: 14px;
            font-size: 12px;
            color: #475569;
        }

        .legend-dot {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 4px;
        }

        #shipment-map {
            width: 100%;
            height: 380px;
            border-radius: 10px;
            border: 1px solid #cbd5e1;
            z-index: 1;
        }

        .timeline {
            list-style: none;
            margin-top: 12px;
            border-left: 3px solid #cbd5e1;
            padding-left: 20px;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 18px;
            background: #f8fafc;
            padding: 14px 16px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .timeline-item::before {
            content: "";
            position: absolute;
            left: -27px;
            top: 18px;
            width: 11px;
            height: 11px;
            border-radius: 50%;
            background: #2563eb;
            border: 2px solid white;
        }

        .timeline-item.exception {
            background: #fef2f2;
            border-color: #fecaca;
        }

        .timeline-item.exception::before {
            background: #dc2626;
        }

        .timeline-meta {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 4px;
        }

        .timeline-title {
            font-weight: bold;
            font-size: 15px;
            color: #0f172a;
        }

        .timeline-desc {
            font-size: 14px;
            color: #334155;
            margin-top: 4px;
        }

        .btn {
            display: inline-block;
            padding: 11px 18px;
            border-radius: 8px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }

        .back {
            background: #64748b;
            color: white;
        }

        .edit {
            background: #2563eb;
            color: white;
        }

        .actions {
            margin-top: 30px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        @media(max-width: 600px) {
            body { padding: 15px; }
            .container { padding: 20px; }
            .grid { grid-template-columns: 1fr; }
            .header { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <div>
            <h1>📦 Detail Shipment: {{ $shipment->shipment_number }}</h1>
            <p class="subtitle">
                Informasi lengkap pengiriman, status ETA, lokasi rute, dan riwayat perjalanan CargoTrace.
            </p>
        </div>
        <div>
            @if($shipment->is_delayed)
                <span class="badge status-delayed">
                    ⚠️ DELAYED ({{ $shipment->delay_hours }} jam - {{ $shipment->delay_severity ?? 'HIGH' }})
                </span>
            @else
                <span class="badge status-ontime">
                    ✅ ON SCHEDULE
                </span>
            @endif
        </div>
    </div>

    @if($shipment->is_delayed && $shipment->delay_reason)
        <div class="alert-box alert-danger">
            <strong>Alasan Keterlambatan:</strong> {{ $shipment->delay_reason }}
        </div>
    @endif

    @if(isset($weather) && ($weather['available'] ?? false))
        <div class="alert-box alert-info">
            <strong>🌤️ Cuaca Operasional Sekitar Lokasi Terkini:</strong>
            Suhu {{ $weather['temperature_c'] }}°C, Kecepatan Angin {{ $weather['windspeed_kmh'] }} km/jam.
            <br><small><em>{{ $weather['disclaimer'] }}</em></small>
        </div>
    @endif

    <div class="grid" style="margin-top: 20px;">
        <div class="item">
            <label>Shipment Number</label>
            <p>{{ $shipment->shipment_number }}</p>
        </div>

        <div class="item">
            <label>Current Status</label>
            <p>
                <span class="badge status-normal">
                    {{ str_replace('_', ' ', $shipment->current_status) }}
                </span>
            </p>
        </div>

        <div class="item">
            <label>Customer</label>
            <p>{{ $shipment->customer->name ?? '-' }}</p>
        </div>

        <div class="item">
            <label>Carrier</label>
            <p>{{ $shipment->carrier->name ?? '-' }}</p>
        </div>

        <div class="item">
            <label>Origin Location</label>
            <p>{{ $shipment->origin->name ?? '-' }}</p>
        </div>

        <div class="item">
            <label>Destination Location</label>
            <p>{{ $shipment->destination->name ?? '-' }}</p>
        </div>

        <div class="item">
            <label>Cargo Type</label>
            <p>{{ $shipment->cargo_type }}</p>
        </div>

        <div class="item">
            <label>Weight / Volume</label>
            <p>{{ $shipment->weight ?? '-' }} kg / {{ $shipment->volume ?? '-' }} m³</p>
        </div>

        <div class="item">
            <label>Expected Departure</label>
            <p>
                {{ $shipment->expected_departure
                    ? \Carbon\Carbon::parse($shipment->expected_departure)->format('d-m-Y H:i')
                    : '-' }}
            </p>
        </div>

        <div class="item">
            <label>Expected Arrival</label>
            <p>
                {{ $shipment->expected_arrival
                    ? \Carbon\Carbon::parse($shipment->expected_arrival)->format('d-m-Y H:i')
                    : '-' }}
            </p>
        </div>

        <div class="item">
            <label>Estimated Arrival (ETA)</label>
            <p>
                {{ $shipment->estimated_arrival
                    ? \Carbon\Carbon::parse($shipment->estimated_arrival)->format('d-m-Y H:i')
                    : '-' }}
            </p>
        </div>

        <div class="item">
            <label>Current Location (Latest Valid Event)</label>
            <p>
                {{ $shipment->trackingEvents->last()?->location?->name
                    ?? $shipment->origin->name
                    ?? '-' }}
            </p>
        </div>
    </div>

    <!-- Peta Rute Pengiriman -->
    <div class="map-header">
        <h2>🗺️ Peta Rute & Titik Pelacakan</h2>
        <div class="map-legend">
            <span><i class="legend-dot" style="background:#16a34a;"></i>Origin</span>
            <span><i class="legend-dot" style="background:#2563eb;"></i>Checkpoint / Transit</span>
            <span><i class="legend-dot" style="background:#dc2626;"></i>Destination</span>
        </div>
    </div>
    <div id="shipment-map"></div>

    <!-- Exception Aktif / Riwayat Exception -->
    @if($shipment->exceptions && $shipment->exceptions->count() > 0)
        <h2>🚨 Laporan Kendala (Exceptions)</h2>
        <ul class="timeline">
            @foreach($shipment->exceptions as $exc)
                <li class="timeline-item exception">
                    <div class="timeline-meta">
                        Terdeteksi: {{ \Carbon\Carbon::parse($exc->detected_at)->format('d-m-Y H:i') }}
                        • Severity: <strong>{{ $exc->severity }}</strong>
                        • Status: <strong>{{ $exc->status }}</strong>
                    </div>
                    <div class="timeline-title">{{ str_replace('_', ' ', $exc->exception_type) }}</div>
                    <div class="timeline-desc">{{ $exc->description }}</div>
                </li>
            @endforeach
        </ul>
    @endif

    <!-- Timeline Riwayat Perjalanan -->
    <h2>🕒 Timeline Perjalanan (Chronological Events)</h2>
    @if($shipment->trackingEvents && $shipment->trackingEvents->count() > 0)
        <ul class="timeline">
            @foreach($shipment->trackingEvents as $event)
                <li class="timeline-item">
                    <div class="timeline-meta">
                        {{ \Carbon\Carbon::parse($event->event_time)->format('d-m-Y H:i') }}
                        @if($event->location)
                            • 📍 {{ $event->location->name }}
                        @endif
                    </div>
                    <div class="timeline-title">{{ str_replace('_', ' ', $event->event_type) }}</div>
                    <div class="timeline-desc">{{ $event->description ?? 'Status pengiriman diperbarui.' }}</div>
                </li>
            @endforeach
        </ul>
    @else
        <p class="subtitle">Belum ada riwayat tracking event untuk pengiriman ini.</p>
    @endif

    <div class="actions">
        <a href="{{ route('shipments.index') }}" class="btn back">
            ← Kembali
        </a>

        @if(auth()->user()->hasRole(['admin', 'operator']))
            <a href="{{ route('shipments.edit', $shipment->id) }}" class="btn edit">
                ✏️ Edit Shipment
            </a>
        @endif
    </div>

</div>

<!-- Leaflet.js Script -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const map = L.map('shipment-map').setView([10.0, 60.0], 3);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Fallback koordinat pelabuhan utama jika tabel locations belum menyimpan lat/lng
    function resolveCoords(loc) {
        if (!loc) return null;
        if (loc.latitude && loc.longitude) {
            return [parseFloat(loc.latitude), parseFloat(loc.longitude)];
        }
        const name = (loc.name || '').toLowerCase();
        if (name.includes('jakarta') || name.includes('priok')) return [-6.1025, 106.8833];
        if (name.includes('singapore')) return [1.2644, 103.8222];
        if (name.includes('rotterdam')) return [51.9496, 4.1453];
        if (name.includes('tokyo')) return [35.6192, 139.7798];
        if (name.includes('surabaya')) return [-7.2047, 112.7344];
        if (name.includes('shanghai')) return [31.2304, 121.4737];
        return null;
    }

    const points = [];
    const originObj = @json($shipment->origin);
    const destObj = @json($shipment->destination);
    const events = @json($shipment->trackingEvents);

    // 1. Marker Origin (Hijau)
    const originCoords = resolveCoords(originObj);
    if (originCoords) {
        points.push(originCoords);
        L.circleMarker(originCoords, {
            radius: 9,
            fillColor: '#16a34a',
            color: '#ffffff',
            weight: 2.5,
            fillOpacity: 1
        }).addTo(map).bindPopup(`<strong>🟢 Origin:</strong><br>${originObj.name}`);
    }

    // 2. Marker Tracking Events (Biru)
    let latestMarker = null;
    if (Array.isArray(events)) {
        events.forEach((ev, idx) => {
            let evCoords = null;
            if (ev.latitude && ev.longitude) {
                evCoords = [parseFloat(ev.latitude), parseFloat(ev.longitude)];
            } else if (ev.location) {
                evCoords = resolveCoords(ev.location);
            }

            if (evCoords) {
                points.push(evCoords);
                const isLast = idx === events.length - 1;
                const marker = L.circleMarker(evCoords, {
                    radius: isLast ? 10 : 7,
                    fillColor: '#2563eb',
                    color: '#ffffff',
                    weight: 2.5,
                    fillOpacity: 1
                }).addTo(map).bindPopup(`
                    <strong>${isLast ? '📍 Posisi Terkini' : '🔹 Checkpoint'}: ${ev.event_type.replace('_', ' ')}</strong><br>
                    ${ev.location ? ev.location.name + '<br>' : ''}
                    <small>${ev.description ?? ''}</small>
                `);

                if (isLast) latestMarker = marker;
            }
        });
    }

    // 3. Marker Destination (Merah)
    const destCoords = resolveCoords(destObj);
    if (destCoords) {
        points.push(destCoords);
        L.circleMarker(destCoords, {
            radius: 9,
            fillColor: '#dc2626',
            color: '#ffffff',
            weight: 2.5,
            fillOpacity: 1
        }).addTo(map).bindPopup(`<strong>🔴 Destination:</strong><br>${destObj.name}`);
    }

    // 4. Garis Rute Penghubung & Auto-Fit Zoom
    if (points.length > 1) {
        const polyline = L.polyline(points, {
            color: '#2563eb',
            weight: 3,
            opacity: 0.85,
            dashArray: '8, 8'
        }).addTo(map);

        map.fitBounds(polyline.getBounds(), { padding: [50, 50], maxZoom: 6 });
    } else if (points.length === 1) {
        map.setView(points[0], 5);
    }

    if (latestMarker) {
        latestMarker.openPopup();
    }

    setTimeout(() => map.invalidateSize(), 200);
});
</script>

</body>
</html>