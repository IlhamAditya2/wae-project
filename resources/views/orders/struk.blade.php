<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Pemesanan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
            padding: 20px;
        }

        h2 {
            margin-bottom: 10px;
        }

        p {
            margin: 4px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .text-right {
            text-align: right;
        }

        .total-row td {
            font-weight: bold;
        }
    </style>
</head>
<body>

    <h2>Struk Pemesanan</h2>

    <p><strong>Nama:</strong> {{ $order->name }}</p>
    <p><strong>Nomor HP:</strong> {{ $order->phone }}</p>
    <p><strong>Alamat:</strong> {{ $order->address }}</p>
    <p><strong>Pembayaran:</strong> {{ strtoupper($order->payment_method) }}</p>
    <p><strong>Total:</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>

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
            <tr class="total-row">
                <td colspan="4" class="text-right">Total</td>
                <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
