<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Exception - CargoTrace</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            padding: 30px;
            color: #1e293b;
        }

        .container {
            max-width: 750px;
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
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .back {
            color: #2563eb;
            text-decoration: none;
            margin-left: 15px;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>⚠️ Tambah Shipment Exception</h1>

    <p class="subtitle">
        Catat masalah atau kendala yang terjadi pada pengiriman.
    </p>

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

    <form action="{{ route('exceptions.store') }}" method="POST">
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

        <label>Exception Type</label>

        <select name="exception_type" required>
            <option value="">Pilih Jenis Masalah</option>

            @foreach([
                'DELAYED',
                'DAMAGED',
                'LOST',
                'CUSTOMS_HOLD',
                'ADDRESS_ISSUE',
                'OTHER'
            ] as $type)
                <option value="{{ $type }}"
                    {{ old('exception_type') == $type ? 'selected' : '' }}>
                    {{ $type }}
                </option>
            @endforeach
        </select>

        <label>Severity</label>

        <select name="severity" required>
            @foreach(['LOW', 'MEDIUM', 'HIGH', 'CRITICAL'] as $severity)
                <option value="{{ $severity }}"
                    {{ old('severity', 'LOW') == $severity ? 'selected' : '' }}>
                    {{ $severity }}
                </option>
            @endforeach
        </select>

        <label>Detected At</label>

        <input
            type="datetime-local"
            name="detected_at"
            value="{{ old('detected_at') }}"
            required
        >

        <label>Description</label>

        <textarea
            name="description"
            rows="5"
            placeholder="Jelaskan masalah pengiriman..."
            required
        >{{ old('description') }}</textarea>

        <button type="submit">
            Simpan Exception
        </button>

        <a href="{{ route('exceptions.index') }}" class="back">
            Batal
        </a>

    </form>

</div>

</body>
</html>
