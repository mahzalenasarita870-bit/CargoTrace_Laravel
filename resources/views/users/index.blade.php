<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Management - CargoTrace</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            padding: 30px;
            color: #1e293b;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
        }

        h1 {
            margin-bottom: 8px;
        }

        .subtitle {
            color: #64748b;
            margin-bottom: 25px;
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

        select {
            padding: 9px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
        }

        button {
            background: #2563eb;
            color: white;
            border: none;
            padding: 9px 13px;
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

        .error {
            background: #fee2e2;
            color: #b91c1c;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .role {
            font-weight: bold;
            color: #2563eb;
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

    <h1>👥 Users Management</h1>

    <p class="subtitle">
        Kelola akun dan hak akses pengguna CargoTrace.
    </p>

    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="error">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="error">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pengguna</th>
                <th>Email</th>
                <th>Role</th>
                <th>Tanggal Dibuat</th>
                <th>Ubah Role</th>
            </tr>
        </thead>

        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>
                        {{ $users->firstItem() + $loop->index }}
                    </td>

                    <td>
                        {{ $user->name }}
                    </td>

                    <td>
                        {{ $user->email }}
                    </td>

                    <td>
                        <span class="role">
                            {{ $user->role }}
                        </span>
                    </td>

                    <td>
                        {{ $user->created_at?->format('d-m-Y') ?? '-' }}
                    </td>

                    <td>
                        @if($user->id !== auth()->id())
                            <form
                                action="{{ route('users.updateRole', $user) }}"
                                method="POST"
                            >
                                @csrf
                                @method('PATCH')

                                <select name="role" required>
                                    @foreach(['ADMIN', 'OPERATOR', 'CUSTOMER'] as $role)
                                        <option
                                            value="{{ $role }}"
                                            {{ $user->role == $role ? 'selected' : '' }}
                                        >
                                            {{ $role }}
                                        </option>
                                    @endforeach
                                </select>

                                <button type="submit">
                                    Simpan
                                </button>
                            </form>
                        @else
                            <span style="color:#64748b">
                                Akun Admin aktif
                            </span>
                        @endif
                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:30px">
                        Belum ada pengguna.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:20px">
        {{ $users->links() }}
    </div>

    <a href="{{ route('dashboard') }}" class="back">
        ← Kembali ke Dashboard
    </a>

</div>

</body>
</html>
