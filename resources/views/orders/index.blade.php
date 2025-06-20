<x-app-layout>
   <x-slot name="header">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('orderan') }}" class="text-decoration-none text-dark fw-bold">Order Masuk</a>
        <!-- <a href="{{ route('products.create') }}" class="text-decoration-none text-dark fw-bold">Tambah Produk</a> -->
        

    </div>
</x-slot>
<div class="container">
    <!-- <h2>Daftar Order Masuk</h2> -->

    @foreach($orders as $order)
        <div class="mb-4 p-3 border rounded">
            <p><strong>Nama:</strong> {{ $order->name }}</p>
            <p><strong>Nomor HP:</strong> {{ $order->phone }}</p>
            <p><strong>Alamat:</strong> {{ $order->address }}</p>
            <p><strong>Metode Pembayaran:</strong> {{ strtoupper($order->payment_method) }}</p>
            <p><strong>Total:</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>

            <h5>Barang:</h5>
            <ul>
                @foreach($order->items as $item)
                    <li>{{ $item->product_name }} x {{ $item->quantity }} - Rp {{ number_format($item->price, 0, ',', '.') }}</li>
                @endforeach
            </ul>
        </div>
    @endforeach
</div>
</x-app-layout>
