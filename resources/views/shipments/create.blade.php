<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Shipment - CargoTrace</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            padding: 30px;
            color: #1e293b;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
        }

        h1 {
            margin-bottom: 10px;
        }

        .subtitle {
            color: #64748b;
            margin-bottom: 25px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
        }

        input, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            box-sizing: border-box;
        }

        .btn {
            background: #2563eb;
            color: white;
            border: none;
            padding: 13px 20px;
            border-radius: 8px;
            cursor: pointer;
        }

        .back {
            color: #2563eb;
            text-decoration: none;
            margin-left: 15px;
        }

        .error {
            background: #fee2e2;
            color: #b91c1c;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        @media(max-width: 600px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<div class="container">

    <h1>📦 Tambah Shipment</h1>

    <p class="subtitle">
        Masukkan informasi pengiriman barang.
    </p>

    @if($errors->any())
        <div class="error">
            <strong>Periksa kembali data:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('shipments.store') }}" method="POST">
        @csrf

        <div class="form-grid">

            <div class="form-group">
                <label>Shipment Number</label>
                <input
                    type="text"
                    name="shipment_number"
                    value="{{ old('shipment_number') }}"
                    placeholder="CT-2026-001"
                    required
                >
            </div>

            <div class="form-group">
                <label>Customer</label>
                <select name="customer_id" required>
                    <option value="">Pilih Customer</option>

                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}"
                            {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                            {{ $customer->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Carrier</label>
                <select name="carrier_id" required>
                    <option value="">Pilih Carrier</option>

                    @foreach($carriers as $carrier)
                        <option value="{{ $carrier->id }}"
                            {{ old('carrier_id') == $carrier->id ? 'selected' : '' }}>
                            {{ $carrier->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Cargo Type</label>
                <input
                    type="text"
                    name="cargo_type"
                    value="{{ old('cargo_type') }}"
                    placeholder="Contoh: Electronics"
                    required
                >
            </div>

            <div class="form-group">
                <label>Origin</label>
                <select name="origin_location_id" required>
                    <option value="">Pilih lokasi asal</option>

                    @foreach($locations as $location)
                        <option value="{{ $location->id }}"
                            {{ old('origin_location_id') == $location->id ? 'selected' : '' }}>
                            {{ $location->name }} - {{ $location->city }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Destination</label>
                <select name="destination_location_id" required>
                    <option value="">Pilih lokasi tujuan</option>

                    @foreach($locations as $location)
                        <option value="{{ $location->id }}"
                            {{ old('destination_location_id') == $location->id ? 'selected' : '' }}>
                            {{ $location->name }} - {{ $location->city }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Weight (kg)</label>
                <input
                    type="number"
                    step="0.01"
                    min="0"
                    name="weight"
                    value="{{ old('weight') }}"
                    placeholder="Contoh: 250"
                >
            </div>

            <div class="form-group">
                <label>Volume (m³)</label>
                <input
                    type="number"
                    step="0.01"
                    min="0"
                    name="volume"
                    value="{{ old('volume') }}"
                    placeholder="Contoh: 12.5"
                >
            </div>

            <div class="form-group">
                <label>Expected Departure</label>
                <input
                    type="datetime-local"
                    name="expected_departure"
                    value="{{ old('expected_departure') }}"
                >
            </div>

            <div class="form-group">
                <label>Expected Arrival</label>
                <input
                    type="datetime-local"
                    name="expected_arrival"
                    value="{{ old('expected_arrival') }}"
                >
            </div>

            <div class="form-group">
                <label>Current Status</label>
                <select name="current_status" required>
                    @foreach(['CREATED', 'BOOKED', 'PICKED_UP', 'IN_TRANSIT', 'DELIVERED'] as $status)
                        <option value="{{ $status }}"
                            {{ old('current_status', 'CREATED') == $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
            </div>

        </div>

        <button type="submit" class="btn">
            Simpan Shipment
        </button>

        <a href="{{ route('shipments.index') }}" class="back">
            Batal
        </a>

    </form>

</div>

</body>
</html>
