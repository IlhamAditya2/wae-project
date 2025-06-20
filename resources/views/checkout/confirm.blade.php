<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Konfirmasi Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container py-4">
    <h1 class="mb-4">Konfirmasi Checkout</h1>

    @if(count($items) > 0)
        @php $total = 0; @endphp
        <div class="list-group mb-4">
            @foreach($items as $item)
                @php
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                @endphp
                <div class="list-group-item d-flex align-items-center">
                    <img src="{{ asset('images/' . $item['image']) }}" alt="{{ $item['name'] }}" width="80" class="me-3 rounded" style="object-fit: cover;">
                    <div class="flex-grow-1">
                        <h5 class="mb-1">{{ $item['name'] }}</h5>
                        <p class="mb-1">Harga: Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                        <small>Jumlah: {{ $item['quantity'] }}</small>
                    </div>
                    <div class="fw-bold">
                        Rp {{ number_format($subtotal, 0, ',', '.') }}
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-end fs-4 fw-bold mb-4">
            Total: Rp {{ number_format($total, 0, ',', '.') }}
        </div>

        <form method="POST" action="{{ route('checkout.finalize') }}">
            @csrf
            <!-- Bisa tambahkan input hidden produk jika perlu -->
            <a href="{{ route('checkout.form') }}" class="btn btn-primary btn-lg">Bayar Sekarang</a>
            <a href="{{ route('cart.index') }}" class="btn btn-secondary btn-lg ms-2">Kembali ke Keranjang</a>
        </form>
    @else
        <p>Tidak ada produk yang dipilih untuk checkout.</p>
        <a href="{{ route('cart.index') }}" class="btn btn-primary mt-3">Kembali ke Keranjang</a>
    @endif
</div>
</body>
</html>
