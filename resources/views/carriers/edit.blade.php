
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Carrier - CargoTrace</title>

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
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,.04);
        }

        h2 {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #334155;
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
            background: #fee2e2;
            color: #b91c1c;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>✏️ Edit Carrier</h2>

    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('carriers.update', $carrier->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Nama Carrier</label>
        <input type="text"
               name="name"
               value="{{ old('name', $carrier->name) }}"
               required>

        <label>Kode Carrier</label>
        <input type="text"
               name="code"
               value="{{ old('code', $carrier->code) }}"
               required>

        <label>Nomor Telepon</label>
        <input type="text"
               name="phone"
               value="{{ old('phone', $carrier->phone) }}">

        <label>Email</label>
        <input type="email"
               name="email"
               value="{{ old('email', $carrier->email) }}">

        <div class="button-group">
            <button type="submit">Simpan Perubahan</button>

            <a href="{{ route('carriers.index') }}" class="back">
                Kembali
            </a>
        </div>

    </form>

</div>

</body>
</html>
