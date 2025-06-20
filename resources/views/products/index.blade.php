<x-app-layout>
   <x-slot name="header">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('products.index') }}" class="text-decoration-none text-dark fw-bold">Daftar Produk</a>
        <a href="{{ route('products.create') }}" class="text-decoration-none text-dark fw-bold">Tambah Produk</a>
        

    </div>
</x-slot>

<style>
    .header-products {
    font-weight: 700;          /* bold */
    font-size: 1.5rem;         /* ukuran agak besar */
    color: #212529;            /* warna gelap (mirip teks default Bootstrap) */
    text-decoration: none;     /* hilangkan underline untuk link */
    cursor: pointer;           /* pointer saat hover */
    transition: color 0.3s ease;
}

.header-products:hover {
    color: #0d6efd;            /* warna biru Bootstrap saat hover */
    text-decoration: underline;
}


</style>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

       

        @if(session('success'))
            <div class="alert alert-success mb-4">{{ session('success') }}</div>
        @endif

        <div class="row">
            @forelse ($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ asset('images/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->description }}</p>
                            <p class="card-text fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <!-- <form method="POST" action="#">
                                @csrf
                                <button type="submit" class="btn btn-primary">Masukkan Keranjang</button>
                            </form> -->
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="btn btn-sm" onsubmit="return confirm('Yakin mau hapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <p>Tidak ada produk tersedia.</p>
            @endforelse
        </div>

        {{ $products->links() }}
    </div>
</x-app-layout>
