
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Carrier - CargoTrace</title>

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
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        h2 {
            color: #1e293b;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #334155;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .button-group {
            display: flex;
            gap: 10px;
        }

        button {
            background: #2563eb;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            cursor: pointer;
        }

        .back {
            background: #64748b;
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 6px;
        }

        .error {
            color: #dc2626;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>Tambah Carrier</h2>

    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('carriers.store') }}" method="POST">
        @csrf

        <label>Nama Carrier</label>
        <input type="text" name="name"
               value="{{ old('name') }}"
               placeholder="Masukkan nama carrier" required>

        <label>Kode Carrier</label>
        <input type="text" name="code"
               value="{{ old('code') }}"
               placeholder="Masukkan kode carrier" required>

        <label>Nomor Telepon</label>
        <input type="text" name="phone"
               value="{{ old('phone') }}"
               placeholder="Masukkan nomor telepon">

        <label>Email</label>
        <input type="email" name="email"
               value="{{ old('email') }}"
               placeholder="Masukkan email">

        <div class="button-group">
            <button type="submit">Simpan Data</button>

            <a href="{{ route('carriers.index') }}" class="back">
                Kembali
            </a>
        </div>

    </form>

</div>

</body>
</html>
