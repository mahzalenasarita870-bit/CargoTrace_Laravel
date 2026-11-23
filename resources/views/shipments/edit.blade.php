<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Shipment - CargoTrace</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body { background: #f1f5f9; color: #1e293b; padding: 30px; }
        .container {
            max-width: 820px; margin: auto; background: white; padding: 30px;
            border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,.04);
        }
        h1 { font-size: 24px; margin-bottom: 6px; }
        .subtitle { color: #64748b; font-size: 14px; margin-bottom: 24px; }
        .alert-error {
            background: #fef2f2; border: 1px solid #fecaca; color: #991b1b;
            padding: 14px 18px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;
        }
        .alert-error ul { margin-left: 18px; margin-top: 6px; }
        .grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; }
        .form-group { display: flex; flex-direction: column; }
        .form-group.full { grid-column: 1 / -1; }
        label { font-size: 13px; font-weight: bold; color: #475569; margin-bottom: 6px; }
        input, select, textarea {
            padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 8px;
            font-size: 14px; color: #0f172a; background: #fff;
        }
        input:focus, select:focus, textarea:focus { outline: none; border-color: #2563eb; }
        .actions { margin-top: 26px; display: flex; justify-content: flex-end; gap: 10px; }
        .btn {
            padding: 11px 20px; border-radius: 8px; font-size: 14px; font-weight: bold;
            text-decoration: none; border: none; cursor: pointer;
        }
        .btn-back { background: #64748b; color: white; }
        .btn-save { background: #2563eb; color: white; }
        @media(max-width: 600px) { .grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

<div class="container">
    <h1>✏️ Edit Shipment: {{ $shipment->shipment_number }}</h1>
    <p class="subtitle">Perbarui informasi pengiriman, jadwal keberangkatan/kedatangan, atau status.</p>

    @if ($errors->any())
        <div class="alert-error">
            <strong>Terjadi kesalahan pengisian data:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('shipments.update', $shipment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid">
            <div class="form-group">
                <label for="shipment_number">Shipment Number</label>
                <input type="text" name="shipment_number" id="shipment_number"
                    value="{{ old('shipment_number', $shipment->shipment_number) }}" required>
            </div>

            <div class="form-group">
                <label for="current_status">Current Status</label>
                <select name="current_status" id="current_status" required>
                    @foreach(['CREATED', 'IN_TRANSIT', 'AT_PORT', 'CUSTOMS_HOLD', 'DELIVERED', 'CANCELLED'] as $status)
                        <option value="{{ $status }}" {{ old('current_status', $shipment->current_status) === $status ? 'selected' : '' }}>
                            {{ str_replace('_', ' ', $status) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="customer_id">Customer</label>
                <select name="customer_id" id="customer_id" required>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" {{ old('customer_id', $shipment->customer_id) == $customer->id ? 'selected' : '' }}>
                            {{ $customer->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="carrier_id">Carrier</label>
                <select name="carrier_id" id="carrier_id" required>
                    @foreach($carriers as $carrier)
                        <option value="{{ $carrier->id }}" {{ old('carrier_id', $shipment->carrier_id) == $carrier->id ? 'selected' : '' }}>
                            {{ $carrier->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="origin_location_id">Origin Location</label>
                <select name="origin_location_id" id="origin_location_id" required>
                    @foreach($locations as $loc)
                        <option value="{{ $loc->id }}" {{ old('origin_location_id', $shipment->origin_location_id) == $loc->id ? 'selected' : '' }}>
                            {{ $loc->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="destination_location_id">Destination Location</label>
                <select name="destination_location_id" id="destination_location_id" required>
                    @foreach($locations as $loc)
                        <option value="{{ $loc->id }}" {{ old('destination_location_id', $shipment->destination_location_id) == $loc->id ? 'selected' : '' }}>
                            {{ $loc->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group full">
                <label for="cargo_type">Cargo Type</label>
                <input type="text" name="cargo_type" id="cargo_type" value="{{ old('cargo_type', $shipment->cargo_type) }}" required>
            </div>

            <div class="form-group">
                <label for="weight">Weight (kg)</label>
                <input type="number" step="0.01" name="weight" id="weight" value="{{ old('weight', $shipment->weight) }}">
            </div>

            <div class="form-group">
                <label for="volume">Volume (m³)</label>
                <input type="number" step="0.01" name="volume" id="volume" value="{{ old('volume', $shipment->volume) }}">
            </div>

            <div class="form-group">
                <label for="expected_departure">Expected Departure</label>
                <input type="datetime-local" name="expected_departure" id="expected_departure"
                    value="{{ old('expected_departure', $shipment->expected_departure ? \Carbon\Carbon::parse($shipment->expected_departure)->format('Y-m-d\TH:i') : '') }}" required>
            </div>

            <div class="form-group">
                <label for="expected_arrival">Expected Arrival</label>
                <input type="datetime-local" name="expected_arrival" id="expected_arrival"
                    value="{{ old('expected_arrival', $shipment->expected_arrival ? \Carbon\Carbon::parse($shipment->expected_arrival)->format('Y-m-d\TH:i') : '') }}" required>
            </div>

            <div class="form-group">
                <label for="estimated_arrival">Estimated Arrival (ETA)</label>
                <input type="datetime-local" name="estimated_arrival" id="estimated_arrival"
                    value="{{ old('estimated_arrival', $shipment->estimated_arrival ? \Carbon\Carbon::parse($shipment->estimated_arrival)->format('Y-m-d\TH:i') : '') }}">
            </div>

            <div class="form-group">
                <label for="delay_reason">Alasan Keterlambatan (Opsional)</label>
                <input type="text" name="delay_reason" id="delay_reason" value="{{ old('delay_reason', $shipment->delay_reason) }}" placeholder="Contoh: Cuaca buruk / antrean pelabuhan">
            </div>
        </div>

        <div class="actions">
            <a href="{{ route('shipments.show', $shipment->id) }}" class="btn btn-back">← Batal</a>
            <button type="submit" class="btn btn-save">💾 Simpan Perubahan</button>
        </div>
    </form>
</div>

</body>
</html>