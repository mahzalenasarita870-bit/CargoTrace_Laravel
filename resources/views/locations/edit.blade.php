
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Location - CargoTrace</title>

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

    <h2>✏️ Edit Location</h2>

    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('locations.update', $location->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Nama Location</label>
        <input type="text"
               name="name"
               value="{{ old('name', $location->name) }}"
               required>

        <label>Kota</label>
        <input type="text"
               name="city"
               value="{{ old('city', $location->city) }}"
               required>

        <label>Negara</label>
        <input type="text"
               name="country"
               value="{{ old('country', $location->country) }}"
               required>

        <label>Latitude</label>
        <input type="number"
               step="any"
               name="latitude"
               value="{{ old('latitude', $location->latitude) }}">

        <label>Longitude</label>
        <input type="number"
               step="any"
               name="longitude"
               value="{{ old('longitude', $location->longitude) }}">

        <div class="button-group">
            <button type="submit">Simpan Perubahan</button>

            <a href="{{ route('locations.index') }}" class="back">
                Kembali
            </a>
        </div>

    </form>

</div>

</body>
</html>
