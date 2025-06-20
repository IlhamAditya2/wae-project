{{--  --}}




<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Formulir Checkout</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background: #f5f5f5;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        h2 {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #28a745;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

        ul {
            margin: 10px 0 20px 20px;
        }

        li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Formulir Checkout</h2>

    <form method="POST" action="{{ route('checkout.finalize') }}">
        @csrf

        <label for="name">Nama Lengkap</label>
        <input type="text" name="name" required value="{{ old('name') }}">

        <label for="phone">Nomor HP</label>
        <input type="text" name="phone" required value="{{ old('phone') }}">

        <label for="address">Alamat Lengkap</label>
        <textarea name="address" rows="3" required>{{ old('address') }}</textarea>

        <label for="payment_method">Metode Pembayaran</label>
        <select name="payment_method" required>
            <option value="">-- Pilih Bank --</option>
            <option value="bca" {{ old('payment_method') == 'bca' ? 'selected' : '' }}>Bank BCA</option>
            <option value="bri" {{ old('payment_method') == 'bri' ? 'selected' : '' }}>Bank BRI</option>
            <option value="bni" {{ old('payment_method') == 'bni' ? 'selected' : '' }}>Bank BNI</option>
            <option value="mandiri" {{ old('payment_method') == 'mandiri' ? 'selected' : '' }}>Bank Mandiri</option>
        </select>

        <h4>Barang yang Anda Checkout:</h4>
        <ul>
            @foreach($cart as $item)
                <li>{{ $item['name'] }} x {{ $item['quantity'] }} - Rp {{ number_format($item['price'], 0, ',', '.') }}</li>
            @endforeach
        </ul>

        <button type="submit">Bayar Sekarang</button>
    </form>
</div>
</body>
</html>
