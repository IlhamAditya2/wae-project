<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran Berhasil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background-color: #f0f2f5;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        h1 {
            color: #28a745;
            text-align: center;
        }

        .info {
            margin: 20px 0;
        }

        .info p {
            margin: 5px 0;
            font-size: 15px;
        }

        .divider {
            border-top: 1px solid #ccc;
            margin: 20px 0;
        }

        .btn {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            text-align: center;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 14px;
        }

        th {
            background-color: #f2f2f2;
            text-align: left;
        }

        td {
            vertical-align: top;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
<div class="container">

        <a href="{{ url('/') }}" class="absolute top-4 right-4 text-gray-500 hover:text-red-600" title="Kembali">
        <!-- Heroicon: X Mark -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </a>
    
    <h1>✅ Pembayaran Berhasil!</h1>
    <p style="text-align: center;">Terima kasih, pesanan Anda telah kami terima dan sedang diproses.</p>

    <div class="divider"></div>

    <div class="info">
        <p><strong>Nama:</strong> {{ $order->name }}</p>
        <p><strong>Nomor HP:</strong> {{ $order->phone }}</p>
        <p><strong>Alamat:</strong> {{ $order->address }}</p>
        <p><strong>Metode Pembayaran:</strong> {{ strtoupper($order->payment_method) }}</p>
        <p><strong>Total:</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
    </div>

    <div class="divider"></div>

    <h4>Daftar Barang:</h4>
    <table>
        <thead>
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Jumlah</th>
            <th>Harga Satuan</th>
            <th>Subtotal</th>
        </tr>
        </thead>
        <tbody>
        @foreach($order->items as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->product_name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="4" class="text-right"><strong>Total:</strong></td>
            <td><strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong></td>
        </tr>
        </tfoot>
    </table>

    <div class="divider"></div>

    <div style="text-align: right;">
        <a href="{{ route('order.struk', ['id' => $order->id]) }}" class="btn" target="_blank">📄 Download Struk</a>
    </div>
</div>
</body>
</html>
