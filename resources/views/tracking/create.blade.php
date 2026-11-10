<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Tracking - CargoTrace</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            padding: 30px;
        }

        .container {
            max-width: 750px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            box-sizing: border-box;
            margin-bottom: 20px;
        }

        button {
            background: #2563eb;
            color: white;
            padding: 13px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .error {
            background: #fee2e2;
            color: #b91c1c;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
        }

        a {
            color: #2563eb;
            text-decoration: none;
            margin-left: 15px;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>📍 Tambah Tracking Event</h1>
    <p>Tambahkan informasi terbaru perjalanan shipment.</p>

    @if($errors->any())
        <div class="error">
            <strong>Terjadi kesalahan:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tracking.store') }}" method="POST">
        @csrf

        <label>Shipment</label>
        <select name="shipment_id" required>
            <option value="">Pilih Shipment</option>

            @foreach($shipments as $shipment)
                <option value="{{ $shipment->id }}"
                    {{ old('shipment_id') == $shipment->id ? 'selected' : '' }}>
                    {{ $shipment->shipment_number }}
                </option>
            @endforeach
        </select>

        <label>Event Type</label>
        <select name="event_type" required>
            @foreach([
                'CREATED',
                'BOOKED',
                'PICKED_UP',
                'IN_TRANSIT',
                'ARRIVED',
                'DELIVERED',
                'DELAYED'
            ] as $event)
                <option value="{{ $event }}"
                    {{ old('event_type', 'IN_TRANSIT') == $event ? 'selected' : '' }}>
                    {{ $event }}
                </option>
            @endforeach
        </select>

        <label>Event Time</label>
        <input
            type="datetime-local"
            name="event_time"
            value="{{ old('event_time') }}"
            required
        >

        <label>Location</label>
        <select name="location_id">
            <option value="">Pilih Lokasi</option>

            @foreach($locations as $location)
                <option value="{{ $location->id }}"
                    {{ old('location_id') == $location->id ? 'selected' : '' }}>
                    {{ $location->name }} - {{ $location->city }}
                </option>
            @endforeach
        </select>

        <label>Latitude</label>
        <input
            type="number"
            step="any"
            name="latitude"
            value="{{ old('latitude') }}"
            placeholder="Contoh: -6.2088"
        >

        <label>Longitude</label>
        <input
            type="number"
            step="any"
            name="longitude"
            value="{{ old('longitude') }}"
            placeholder="Contoh: 106.8456"
        >

        <label>Description</label>
        <textarea
            name="description"
            rows="4"
            placeholder="Keterangan perjalanan barang..."
        >{{ old('description') }}</textarea>

        <button type="submit">Simpan Tracking</button>

        <a href="{{ route('tracking.index') }}">Batal</a>

    </form>

</div>

</body>
</html>