
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locations - CargoTrace</title>

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
            max-width: 1200px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }

        h2 {
            color: #1e293b;
        }

        .btn {
            display: inline-block;
            padding: 9px 14px;
            border: none;
            border-radius: 5px;
            color: white;
            text-decoration: none;
            font-size: 13px;
            cursor: pointer;
        }

        .btn-add {
            background: #2563eb;
        }

        .btn-edit {
            background: #f59e0b;
        }

        .btn-delete {
            background: #dc2626;
        }

        .btn-dashboard {
            background: #475569;
        }

        .alert {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #e2e8f0;
            padding: 12px;
            text-align: left;
            font-size: 14px;
        }

        th {
            background: #2563eb;
            color: white;
        }

        tr:nth-child(even) {
            background: #f8fafc;
        }

        .aksi {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .pagination {
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .container {
                padding: 15px;
                overflow-x: auto;
            }

            table {
                min-width: 900px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <h2>Location Management</h2>

        <div>
            <a href="{{ route('locations.create') }}" class="btn btn-add">
                + Add Location
            </a>

            <a href="{{ route('dashboard') }}" class="btn btn-dashboard">
                Dashboard
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert">
            {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Location Name</th>
                <th>City</th>
                <th>Country</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($locations as $location)
                <tr>
                    <td>{{ $loop->iteration + ($locations->currentPage() - 1) * $locations->perPage() }}</td>

                    <td>{{ $location->name }}</td>
                    <td>{{ $location->city }}</td>
                    <td>{{ $location->country }}</td>
                    <td>{{ $location->latitude ?? '-' }}</td>
                    <td>{{ $location->longitude ?? '-' }}</td>

                    <td>
                        <div class="aksi">

                            <a href="{{ route('locations.edit', $location->id) }}"
                               class="btn btn-edit">
                                Edit
                            </a>

                            <form action="{{ route('locations.destroy', $location->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus location ini?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-delete">
                                    Delete
                                </button>

                            </form>

                        </div>
                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="7" style="text-align:center;">
                        Belum ada data location.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination">
        {{ $locations->links() }}
    </div>

</div>

</body>
</html>
