
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Shipment - CargoTrace</title>

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
            font-size: 27px;
        }

        .subtitle {
            color: #64748b;
            margin-top: 8px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .item {
            padding: 18px;
            background: #f8fafc;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .item label {
            display: block;
            color: #64748b;
            font-size: 13px;
            margin-bottom: 8px;
        }

        .item p {
            font-weight: bold;
            font-size: 15px;
            word-break: break-word;
        }

        .status {
            display: inline-block;
            padding: 7px 12px;
            background: #dbeafe;
            color: #1d4ed8;
            border-radius: 20px;
            font-size: 12px;
        }

        .btn {
            display: inline-block;
            padding: 12px 18px;
            border-radius: 8px;
            text-decoration: none;
            border: none;
            cursor: pointer;
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
            margin-top: 25px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        @media(max-width: 600px) {
            body {
                padding: 15px;
            }

            .container {
                padding: 20px;
            }

            .grid {
                grid-template-columns: 1fr;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <div>
            <h1>📦 Detail Shipment</h1>
            <p class="subtitle">
                Informasi lengkap pengiriman CargoTrace.
            </p>
        </div>
    </div>

    <div class="grid">

        <div class="item">
            <label>Shipment Number</label>
            <p>{{ $shipment->shipment_number }}</p>
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
            <label>Cargo Type</label>
            <p>{{ $shipment->cargo_type }}</p>
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
            <label>Weight</label>
            <p>{{ $shipment->weight ?? '-' }} kg</p>
        </div>

        <div class="item">
            <label>Volume</label>
            <p>{{ $shipment->volume ?? '-' }} m³</p>
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
            <label>Current Status</label>
            <p>
                <span class="status">
                    {{ str_replace('_', ' ', $shipment->current_status) }}
                </span>
            </p>
        </div>

        <div class="item">
            <label>Created At</label>
            <p>{{ $shipment->created_at->format('d-m-Y H:i') }}</p>
        </div>

    </div>

    <div class="actions">
        <a href="{{ route('shipments.index') }}" class="btn back">
            ← Kembali
        </a>

        <a href="{{ route('shipments.edit', $shipment->id) }}" class="btn edit">
            ✏️ Edit Shipment
        </a>
    </div>

</div>

</body>
</html>
