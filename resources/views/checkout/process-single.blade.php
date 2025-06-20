<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pembelian Langsung - Checkout</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    {{-- PASTIKAN BOOTSTRAP CSS DAN BOOTSTRAP ICONS ADA --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        /* Anda bisa copy paste semua CSS dari checkout.form.blade.php di sini */
        /* Atau lebih baik, gunakan sistem layout Laravel jika Anda menggunakannya */
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
        .form-control {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px; 
            border-radius: 6px;
            border: 1px solid #ccc;
            display: block;
            font-size: 1rem;
            line-height: 1.5;
            color: #212529;
            background-color: #fff;
            background-clip: padding-box;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        }
        .form-control:focus {
            color: #212529;
            background-color: #fff;
            border-color: #86b7fe;
            outline: 0;
            box-shadow: 0 0 0 .25rem rgba(13,110,253,.25);
        }
        .is-invalid {
            border-color: #dc3545;
            padding-right: calc(1.5em + .75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right .75rem center;
            background-size: 1rem 1rem;
        }
        .invalid-feedback {
            display: none;
            width: 100%;
            margin-top: -10px;
            margin-bottom: 15px;
            font-size: .875em;
            color: #dc3545;
        }
        .is-invalid + .invalid-feedback {
            display: block;
        }
        button[type="submit"] { 
            background-color: #28a745; 
            color: white; 
            padding: 12px 20px; 
            border: none; 
            border-radius: 6px; 
            font-size: 16px; 
            cursor: pointer; 
            width: 100%;
        } 
        button[type="submit"]:hover { 
            background-color: #218838; 
        } 
        h4 {
            margin-top: 20px;
            margin-bottom: 10px;
        }
        ul { 
            margin: 0; 
            padding: 0; 
            list-style: none; 
            border: 1px solid #eee; 
            border-radius: 6px;
            overflow: hidden; 
        } 
        li { 
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            padding: 10px 15px; 
            border-bottom: 1px solid #eee; 
            font-size: 0.95rem;
        }
        li:last-child {
            border-bottom: none; 
        }
        .total-summary {
            text-align: right;
            font-weight: bold;
            margin-top: 15px;
            padding-right: 15px;
            font-size: 1.1rem;
        }
        .alert {
            padding: 1rem 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: .25rem;
        }
        .alert-danger {
            color: #842029;
            background-color: #f8d7da;
            border-color: #f5c2c7;
        }
        .alert-warning {
            color: #664d03;
            background-color: #fff3cd;
            border-color: #ffecb5;
        }
        .alert-link {
            font-weight: 700;
            text-decoration: none;
            color: inherit; 
        }
        .alert-link:hover {
            text-decoration: underline;
        }
        .card {
            background-color: #fff;
            border: 1px solid rgba(0,0,0,.125);
            border-radius: .25rem;
            box-shadow: 0 .125rem .25rem rgba(0,0,0,.075);
            margin-bottom: 1.5rem;
        }
        .card-header {
            padding: .75rem 1.25rem;
            margin-bottom: 0;
            background-color: #0d6efd; 
            color: #fff; 
            border-bottom: 1px solid rgba(0,0,0,.125);
            border-top-left-radius: inherit;
            border-top-right-radius: inherit;
        }
        .card-body {
            padding: 1.25rem;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Pembelian Langsung - Checkout</h2>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- Ringkasan Produk yang Dibeli Langsung --}}
    @if ($itemToCheckout)
        <div class="card mb-4">
            <div class="card-header">
                Detail Produk
            </div>
            <div class="card-body">
                <ul>
                    <li>
                        <span>{{ $itemToCheckout['name'] }} x {{ $itemToCheckout['quantity'] }}</span>
                        <span>Rp {{ number_format($itemToCheckout['price'] * $itemToCheckout['quantity'], 0, ',', '.') }}</span>
                    </li>
                </ul>
                <div class="total-summary">
                    Total: Rp {{ number_format($total, 0, ',', '.') }}
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            Tidak ada produk untuk diproses secara langsung. Silakan kembali ke <a href="{{ route('welcome') }}" class="alert-link">beranda</a>.
        </div>
    @endif

    {{-- Formulir Data Pengiriman dan Pembayaran --}}
    <form method="POST" action="{{ route('checkout.finalize-single') }}">
        @csrf

        <div class="mb-3">
            <label for="name">Nama Lengkap</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" required value="{{ old('name') }}">
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="phone">Nomor HP</label>
            <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" required value="{{ old('phone') }}">
            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="address">Alamat Lengkap</label>
            <textarea name="address" id="address" rows="3" class="form-control @error('address') is-invalid @enderror" required>{{ old('address') }}</textarea>
            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="payment_method">Metode Pembayaran</label>
            <select name="payment_method" id="payment_method" class="form-control @error('payment_method') is-invalid @enderror" required>
                <option value="">-- Pilih Metode Pembayaran --</option>
                <option value="bca_transfer" {{ old('payment_method') == 'bca_transfer' ? 'selected' : '' }}>Bank BCA Transfer</option>
                <option value="bri_transfer" {{ old('payment_method') == 'bri_transfer' ? 'selected' : '' }}>Bank BRI Transfer</option>
                <option value="bni_transfer" {{ old('payment_method') == 'bni_transfer' ? 'selected' : '' }}>Bank BNI Transfer</option>
                <option value="mandiri_transfer" {{ old('payment_method') == 'mandiri_transfer' ? 'selected' : '' }}>Bank Mandiri Transfer</option>
                <option value="cod" {{ old('payment_method') == 'cod' ? 'selected' : '' }}>Cash On Delivery (COD)</option>
            </select>
            @error('payment_method') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button type="submit">Bayar Sekarang</button>
    </form>
</div>
</body>
</html>