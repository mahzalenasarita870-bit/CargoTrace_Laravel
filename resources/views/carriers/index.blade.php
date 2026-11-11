
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carriers - CargoTrace</title>

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
            max-width: 1200px;
            margin: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            gap: 15px;
        }

        h1 {
            font-size: 28px;
        }

        p {
            color: #64748b;
            margin-top: 8px;
        }

        .section {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,.04);
        }

        .btn {
            display: inline-block;
            padding: 12px 18px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 8px;
        }

        .btn-back {
            background: #64748b;
        }

        .btn-add {
            display: inline-block;
            padding: 12px 20px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 15px;
        }

        .btn-edit {
            display: inline-block;
            background: #f59e0b;
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-delete {
            background: #dc2626;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f8fafc;
            text-align: left;
            padding: 15px;
            font-size: 13px;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 13px;
        }

        .empty {
            text-align: center;
            padding: 30px;
            color: #64748b;
        }

        .pagination {
            margin-top: 20px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        @media(max-width: 600px) {
            body {
                padding: 15px;
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
            <h1>🚛 Carrier Management</h1>

            <a href="{{ route('carriers.create') }}" class="btn-add">
                + Tambah Carrier
            </a>

            <p>Kelola data perusahaan pengiriman CargoTrace.</p>
        </div>

        <a href="{{ route('dashboard') }}" class="btn btn-back">
            ← Dashboard
        </a>
    </div>

    <div class="section">

        @if (session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Carrier Name</th>
                        <th>Carrier Code</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($carriers as $carrier)
                        <tr>
                            <td>
                                {{ $carriers->firstItem() + $loop->index }}
                            </td>

                            <td>
                                {{ $carrier->name ?? '-' }}
                            </td>

                            <td>
                                {{ $carrier->code ?? '-' }}
                            </td>

                            <td>
                                {{ $carrier->phone ?? '-' }}
                            </td>

                            <td>
                                {{ $carrier->email ?? '-' }}
                            </td>

                            <td>
                                <div class="action-buttons">

                                    <a href="{{ route('carriers.edit', $carrier->id) }}"
                                       class="btn-edit">
                                        Edit
                                    </a>

                                    <form action="{{ route('carriers.destroy', $carrier->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Apakah kamu yakin ingin menghapus data carrier ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn-delete">
                                            Hapus
                                        </button>

                                    </form>

                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="empty">
                                Belum ada data carrier.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $carriers->links() }}
        </div>

    </div>

</div>

</body>
</html>
