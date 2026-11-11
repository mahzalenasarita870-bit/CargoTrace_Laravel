
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Shipment - CargoTrace</title>

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
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        }

        h2 {
            color: #1e293b;
            margin-bottom: 25px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #334155;
            font-size: 14px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 11px;
            border: 1px solid #cbd5e1;
            border-radius: 5px;
            font-size: 14px;
            background: white;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #2563eb;
        }

        .error {
            color: #dc2626;
            font-size: 12px;
            margin-top: 5px;
        }

        .buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .btn {
            padding: 11px 18px;
            border: none;
            border-radius: 5px;
            color: white;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-save {
            background: #2563eb;
        }

        .btn-back {
            background: #475569;
        }

        @media (max-width: 600px) {
            body {
                padding: 10px;
            }

            .container {
                padding: 20px;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 0;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <h2>Add New Shipment</h2>

    @if ($errors->any())
        <div style="background:#fee2e2;color:#991b1b;padding:12px;border-radius:5px;margin-bottom:20px;">
            <strong>Periksa kembali data yang dimasukkan:</strong>
            <ul style="margin-left:20px;margin-top:8px;">
                @foreach ($errors->all() as $error)
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
                <input type="text"
                       name="shipment_number"
                       value="{{ old('shipment_number') }}"
                       placeholder="Contoh: CT-001"
                       required>
            </div>

            <div class="form-group">
                <label>Customer</label>
                <select name="customer_id" required>
                    <option value="">-- Select Customer --</option>

                    @foreach ($customers as $customer)
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
                    <option value="">-- Select Carrier --</option>

                    @foreach ($carriers as $carrier)
                        <option value="{{ $carrier->id }}"
                            {{ old('carrier_id') == $carrier->id ? 'selected' : '' }}>
                            {{ $carrier->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Origin Location</label>
                <select name="origin_location_id" required>
                    <option value="">-- Select Origin --</option>

                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}"
                            {{ old('origin_location_id') == $location->id ? 'selected' : '' }}>
                            {{ $location->name }} - {{ $location->city }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Destination Location</label>
                <select name="destination_location_id" required>
                    <option value="">-- Select Destination --</option>

                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}"
                            {{ old('destination_location_id') == $location->id ? 'selected' : '' }}>
                            {{ $location->name }} - {{ $location->city }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Cargo Type</label>
                <input type="text"
                       name="cargo_type"
                       value="{{ old('cargo_type') }}"
                       placeholder="Contoh: Electronics"
                       required>
            </div>

            <div class="form-group">
                <label>Weight (kg)</label>
                <input type="number"
                       name="weight"
                       step="0.01"
                       min="0"
                       value="{{ old('weight') }}"
                       placeholder="Contoh: 25.50">
            </div>

            <div class="form-group">
                <label>Volume (m³)</label>
                <input type="number"
                       name="volume"
                       step="0.01"
                       min="0"
                       value="{{ old('volume') }}"
                       placeholder="Contoh: 2.50">
            </div>

            <div class="form-group">
                <label>Expected Departure</label>
                <input type="datetime-local"
                       name="expected_departure"
                       value="{{ old('expected_departure') }}">
            </div>

            <div class="form-group">
                <label>Expected Arrival</label>
                <input type="datetime-local"
                       name="expected_arrival"
                       value="{{ old('expected_arrival') }}">
            </div>

            <div class="form-group">
                <label>Current Status</label>
                <select name="current_status">
                    <option value="CREATED"
                        {{ old('current_status', 'CREATED') == 'CREATED' ? 'selected' : '' }}>
                        CREATED
                    </option>

                    <option value="IN_TRANSIT"
                        {{ old('current_status') == 'IN_TRANSIT' ? 'selected' : '' }}>
                        IN TRANSIT
                    </option>

                    <option value="DELIVERED"
                        {{ old('current_status') == 'DELIVERED' ? 'selected' : '' }}>
                        DELIVERED
                    </option>

                    <option value="CANCELLED"
                        {{ old('current_status') == 'CANCELLED' ? 'selected' : '' }}>
                        CANCELLED
                    </option>
                </select>
            </div>

        </div>

        <div class="buttons">
            <button type="submit" class="btn btn-save">
                Save Shipment
            </button>

            <a href="{{ route('shipments.index') }}" class="btn btn-back">
                Back
            </a>
        </div>

    </form>

</div>

</body>
</html>
