<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CargoTrace</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0f172a;
            color: #fff;
        }

        .login-container {
            width: 900px;
            max-width: 95%;
            display: flex;
            background: #fff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0,0,0,.3);
        }

        .left-panel {
            width: 50%;
            background: linear-gradient(135deg, #1e40af, #0f172a);
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .left-panel h1 {
            font-size: 34px;
            margin-bottom: 20px;
        }

        .left-panel p {
            line-height: 1.7;
            color: #dbeafe;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 40px;
        }

        .right-panel {
            width: 50%;
            padding: 50px 40px;
            color: #1e293b;
        }

        .right-panel h2 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #64748b;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 13px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            outline: none;
        }

        input:focus {
            border-color: #2563eb;
        }

        button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 8px;
            background: #2563eb;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #1d4ed8;
        }

        .error {
            color: #dc2626;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .demo {
            margin-top: 25px;
            padding: 15px;
            background: #eff6ff;
            border-radius: 8px;
            font-size: 13px;
            line-height: 1.8;
            color: #1e40af;
        }

        @media (max-width: 650px) {
            .left-panel {
                display: none;
            }

            .right-panel {
                width: 100%;
                padding: 35px 25px;
            }
        }
    </style>
</head>

<body>

<div class="login-container">

    <div class="left-panel">
        <div class="logo">🚚 CargoTrace</div>

        <h1>Global Shipment Visibility</h1>

        <p>
            Pantau perjalanan pengiriman barang secara mudah.
            Kelola shipment, tracking, lokasi, dan status
            pengiriman dalam satu platform logistik.
        </p>
    </div>

    <div class="right-panel">

        <h2>Welcome Back!</h2>

        <p class="subtitle">
            Silakan login ke akun CargoTrace Anda.
        </p>

        @if ($errors->any())
            <div class="error">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.process') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Email</label>
                <input
                    type="email"
                    name="email"
                    placeholder="Masukkan email"
                    value="{{ old('email') }}"
                    required
                >
            </div>

            <div class="form-group">
                <label>Password</label>
                <input
                    type="password"
                    name="password"
                    placeholder="Masukkan password"
                    required
                >
            </div>

            <button type="submit">Login</button>
        </form>

        <div class="demo">
            <strong>Akun Demo</strong><br>
            Admin: admin@cargotrace.test<br>
            Operator: operator@cargotrace.test<br>
            Customer: customer@cargotrace.test<br>
            Password: password
        </div>

    </div>

</div>

</body>
</html>
