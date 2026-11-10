<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exceptions - CargoTrace</title>

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

        h1 {
            margin-bottom: 8px;
        }

        .subtitle {
            color: #64748b;
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

        .badge {
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: bold;
        }

        .open {
            background: #fee2e2;
            color: #b91c1c;
        }

        .resolved {
            background: #dcfce7;
            color: #166534;
        }

        .low {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .medium {
            background: #fef3c7;
            color: #92400e;
        }

        .high {
            background: #ffedd5;
            color: #c2410c;
        }

        .critical {
            background: #fee2e2;
            color: #991b1b;
        }

        .resolve-btn {
            background: #16a34a;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 6px;
            cursor: pointer;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .back {
            display: inline-block;
            margin-top: 20px;
            color: #2563eb;
            text-decoration: none;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <div>
            <h1>⚠️ Shipment Exceptions</h1>
            <p class="subtitle">
                Kelola masalah dan kendala pengiriman CargoTrace.
            </p>
        </div>

        <a href="{{ route('exceptions.create') }}" class="btn">
            + Tambah Exception
        </a>
    </div>

    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Shipment</th>
                <th>Exception Type</th>
                <th>Severity</th>
                <th>Status</th>
                <th>Detected At</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse($exceptions as $exception)
                <tr>
                    <td>
                        {{ $exceptions->firstItem() + $loop->index }}
                    </td>

                    <td>
                        {{ $exception->shipment->shipment_number ?? '-' }}
                    </td>

                    <td>
                        {{ $exception->exception_type }}
                    </td>

                    <td>
                        <span class="badge {{ strtolower($exception->severity) }}">
                            {{ $exception->severity }}
                        </span>
                    </td>

                    <td>
                        <span class="badge {{ $exception->status == 'RESOLVED' ? 'resolved' : 'open' }}">
                            {{ $exception->status }}
                        </span>
                    </td>

                    <td>
                        {{ $exception->detected_at?->format('d-m-Y H:i') ?? '-' }}
                    </td>

                    <td>
                        {{ $exception->description }}
                    </td>

                    <td>
                        @if($exception->status != 'RESOLVED')
                            <form action="{{ route('exceptions.resolve', $exception) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <button type="submit" class="resolve-btn">
                                    Resolve
                                </button>
                            </form>
                        @else
                            <span style="color:#16a34a;font-weight:bold">
                                Selesai
                            </span>
                        @endif
                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="8" style="text-align:center;padding:30px">
                        Belum ada data Exceptions.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:20px">
        {{ $exceptions->links() }}
    </div>

    <a href="{{ route('dashboard') }}" class="back">
        ← Kembali ke Dashboard
    </a>

</div>

</body>
</html>
