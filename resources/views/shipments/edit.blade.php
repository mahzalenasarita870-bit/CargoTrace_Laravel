
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Shipment - CargoTrace</title>

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
            max-width: 900px;
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
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-group.full {
            grid-column: span 2;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 14px;
        }

        input, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
        }

        .buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 25px;
        }

        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
        }

        .save {
            background: #2563eb;
            color: white;
        }

        .back {
            background: #e2e8f0;
            color: #1e293b;
        }

        .error {
            color: #dc2626;
            margin-top: 5px;
            font-size: 12px;
        }

        .alert {
            background: #fee2e2;
            color: #991b1b;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        @media(max-width: 600px) {
            body {
                padding: 15px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full {
                grid-column: span 1;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <h1>✏️ Edit Shipment</h1>
    <p class="subtitle">Perbarui informasi pengiriman CargoTrace.</p>

    @if($errors->any())
        <div class="alert">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('shipments.update', $shipment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-grid">

            <div class="form-group">
                <label>Shipment Number</label>
                <input type="text" name="shipment_number"
                    value="{{ old('shipment_number', $shipment->shipment_number) }}" required>
            </div>

            <div class="form-group">
                <label>Customer</label>
                <select name="customer_id" required>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}"
                            {{ old('customer_id', $shipment->customer_id) == $customer->id ? 'selected' : '' }}>
                            {{ $customer->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Carrier</label>
                <select name="carrier_id" required>
                    @foreach($carriers as $carrier)
                        <option value="{{ $carrier->id }}"
                            {{ old('carrier_id', $shipment->carrier_id) == $carrier->id ? 'selected' : '' }}>
                            {{ $carrier->name }} ({{ $carrier->code }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Cargo Type</label>
                <input type="text" name="cargo_type"
                    value="{{ old('cargo_type', $shipment->cargo_type) }}" required>
            </div>

            <div class="form-group">
                <label>Origin Location</label>
                <select name="origin_location_id" required>
                    @foreach($locations as $location)
                        <option value="{{ $location->id }}"
                            {{ old('origin_location_id', $shipment->origin_location_id) == $location->id ? 'selected' : '' }}>
                            {{ $location->name }} - {{ $location->city }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Destination Location</label>
                <select name="destination_location_id" required>
                    @foreach($locations as $location)
                        <option value="{{ $location->id }}"
                            {{ old('destination_location_id', $shipment->destination_location_id) == $location->id ? 'selected' : '' }}>
                            {{ $location->name }} - {{ $location->city }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Weight (kg)</label>
                <input type="number" step="0.01" min="0" name="weight"
                    value="{{ old('weight', $shipment->weight) }}">
            </div>

            <div class="form-group">
                <label>Volume (m³)</label>
                <input type="number" step="0.01" min="0" name="volume"
                    value="{{ old('volume', $shipment->volume) }}">
            </div>

            <div class="form-group">
                <label>Expected Departure</label>
                <input type="datetime-local" name="expected_departure"
                    value="{{ old('expected_departure', $shipment->expected_departure ? \Carbon\Carbon::parse($shipment->expected_departure)->format('Y-m-d\TH:i') : '') }}">
            </div>

            <div class="form-group">
                <label>Expected Arrival</label>
                <input type="datetime-local" name="expected_arrival"
                    value="{{ old('expected_arrival', $shipment->expected_arrival ? \Carbon\Carbon::parse($shipment->expected_arrival)->format('Y-m-d\TH:i') : '') }}">
            </div>

            <div class="form-group full">
                <label>Current Status</label>
                <select name="current_status" required>
                    @foreach(['CREATED', 'BOOKED', 'PICKED_UP', 'IN_TRANSIT', 'DELIVERED'] as $status)
                        <option value="{{ $status }}"
                            {{ old('current_status', $shipment->current_status) == $status ? 'selected' : '' }}>
                            {{ str_replace('_', ' ', $status) }}
                        </option>
                    @endforeach
                </select>
            </div>

        </div>

        <div class="buttons">
            <a href="{{ route('shipments.index') }}" class="btn back">Batal</a>
            <button type="submit" class="btn save">💾 Update Shipment</button>
        </div>

    </form>

</div>

</body>
</html>
