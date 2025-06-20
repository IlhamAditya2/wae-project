<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }}</title> {{-- Mengatur judul halaman sesuai nama produk --}}

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    {{-- Swiper CSS (jika masih diperlukan, biasanya tidak di halaman detail) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    <style>
        /* CSS yang sudah ada */
        .btn-outline-secondary:hover {
            background-color: #052659 !important;
            color: white !important;
            border-color: #052659 !important;
        }
        /* Jika Anda punya CSS custom untuk body atau lainnya, masukkan di sini */
        body {
            background-color: #F0F2F5; /* Contoh warna latar belakang */
        }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <img src="{{ asset('logoo.png') }}" alt="Logo" height="50" class="me-2">
            </a>
            <div class="ms-auto">
                <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary position-relative">
                    <i class="bi bi-cart"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cart-count">
                        0 <span class="visually-hidden">items in cart</span>
                    </span>
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline-secondary">Login</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            {{-- Kolom untuk Gambar Produk --}}
            <div class="col-md-6">
                <img src="{{ asset('images/' . $product->image) }}" class="img-fluid rounded shadow-sm" alt="{{ $product->name }}">
            </div>

            {{-- Kolom untuk Detail Produk --}}
            <div class="col-md-6 d-flex flex-column"> {{-- PENTING: Tambahkan d-flex flex-column di sini --}}
                <h1 class="mb-3">{{ $product->name }}</h1>
                {{-- Jika Anda memiliki relasi kategori, Anda bisa menampilkannya --}}
                {{-- <p class="text-muted">Kategori: {{ $product->category->name ?? 'Tidak Berkategori' }}</p> --}}
            
            
                <h2 class="mb-4 text-primary fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</h2>
            
                {{-- Formulir untuk "Beli Sekarang" atau "Masukkan Keranjang" --}}
                <div class="mt-auto"> {{-- mt-auto sudah benar di sini, mendorong blok ke bawah --}}
                    <div> 
                        {{-- Pembungkus d-flex untuk dua tombol beli/keranjang --}}
                        <div class="d-flex gap-2"> 
                            {{-- FORM UNTUK TOMBOL "BELI SEKARANG" (SUBMIT LANGSUNG KE CHECKOUT) --}}
                            {{-- Ini akan mengirimkan POST request ke route('checkout.form') --}}
                            <form action="{{ route('products.handle-direct-buy', $product->id) }}" method="POST" class="flex-fill">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    <i class="bi bi-lightning-fill me-2"></i> Beli Sekarang
                                </button>
                            </form>
                
                            {{-- FORM UNTUK TOMBOL "MASUKKAN KERANJANG" (TETAP VIA AJAX) --}}
                            {{-- Ini akan diproses oleh JavaScript AJAX yang memanggil route('cart.add') --}}
                            <form class="add-to-cart-form flex-fill" data-product-id="{{ $product->id }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary btn-lg w-100">
                                    <i class="bi bi-cart-plus me-2"></i> Masukkan Keranjang
                                </button>
                            </form>
                        </div> {{-- Penutup d-flex gap-2 --}}
                        
                        {{-- Tombol "Kembali ke Daftar Produk" (berada di bawah kedua tombol di atas) --}}
                        <a href="{{ route('welcome') }}" class="btn btn-outline-secondary mt-3 w-100">
                            <i class="bi bi-arrow-left me-2"></i> Kembali ke Daftar Produk
                        </a>
                    </div> {{-- Penutup div pembungkus utama --}}
                </div>
            </div>
            <hr class="my-5"> {{-- Garis pemisah opsional --}}

<div class="row mb-5">
    <div class="col-12">
        <div class="card shadow-sm p-4">
            <h3 class="mb-4">Dijual oleh:</h3>
            <div class="d-flex align-items-center">
                {{-- Logo Toko Hardcoded --}}
                <img src="{{ asset('logoo.png') }}" alt="Logo" width="120" height="120" />
                     
                
                <div>
                    {{-- Nama Toko Hardcoded --}}
                    <h4 class="mb-0">Nama Toko Anda</h4> 
                    {{-- Deskripsi Singkat Toko Hardcoded (opsional) --}}
                    <p class="text-muted mb-0">Toko menyediakan berbagai produk berkualitas.</p>
                    
                    {{-- Opsional: Link ke halaman toko statis (jika ada) --}}
                    {{-- <p class="text-muted mb-0"><a href="{{ url('/about-us-store') }}" class="text-decoration-none">Kunjungi Halaman Toko</a></p> --}}
                </div>
            </div>
            {{-- Opsional: Tombol untuk chat toko atau lihat semua produk toko ini --}}
            <div class="mt-4">
                {{-- Contoh link ke halaman daftar produk utama Anda (welcome route) --}}
                <a href="{{ route('welcome') }}" class="btn btn-outline-primary me-2">
                    <i class="bi bi-shop me-2"></i>Lihat Semua Produk Toko Ini
                </a>
                {{-- Anda bisa menambahkan tombol lain seperti Chat Penjual jika ada fitur itu --}}
                {{-- <a href="#" class="btn btn-outline-success">
                    <i class="bi bi-chat-dots me-2"></i>Chat Penjual
                </a> --}}
            </div>
        </div>
    </div>
</div>
<h3 class="mb-3 mt-4">Deskripsi Produk:</h3>

<a>Spesifikasi Produk: </a>
{{-- PENTING: Tambahkan flex-grow-1 pada elemen deskripsi --}}
{{-- <p class="lead flex-grow-1">{{ $product->description }}</p> --}} {{-- Baris ini di-comment atau dihapus --}}

<div class="flex-grow-1"> {{-- Pembungkus flex-grow-1 untuk list --}}
    @php
        // Pecah deskripsi berdasarkan baris baru
        $descriptionLines = explode("\n", $product->description);
        $hasListItems = false;
    @endphp

    @if (count($descriptionLines) > 1)
        <ul>
            @foreach ($descriptionLines as $line)
                @php
                    $trimmedLine = trim($line);
                @endphp
                {{-- Hanya tampilkan baris yang tidak kosong --}}
                @if (!empty($trimmedLine))
                    @php $hasListItems = true; @endphp
                    <li>{{ $trimmedLine }}</li>
                @endif
            @endforeach
        </ul>
    @endif

    {{-- Fallback jika deskripsi hanya satu baris atau kosong, atau jika tidak ada item list yang valid --}}
    @if (!empty(trim($product->description)) && !$hasListItems)
        <p class="lead">{{ $product->description }}</p>
    @elseif (empty(trim($product->description)))
        <p class="text-muted">Deskripsi tidak tersedia.</p>
    @endif
</div>
        </div>
    </div>

    {{-- Semua script JavaScript dimuat di sini, tepat sebelum tag </body> penutup --}}
    {{-- 1. Swiper JS (jika masih diperlukan) --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    {{-- 2. jQuery (PENTING: Harus dimuat sebelum script yang menggunakan $ atau jQuery) --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- 3. Bootstrap JS (Opsional, tapi disarankan jika Anda menggunakan komponen JS Bootstrap seperti dropdown, modal, dll.) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- 4. Script kustom Anda untuk keranjang --}}
    <script>
        // Pastikan DOM sudah siap sebelum menjalankan script
        document.addEventListener("DOMContentLoaded", function () {
            // Inisialisasi Swiper (Jika elemen Swiper ada di halaman ini, jika tidak, bisa dihapus)
            // Pastikan juga script Swiper CDN di-load sebelum script ini
            if (typeof Swiper !== 'undefined') {
                new Swiper('.swiper', {
                    loop: true,
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                });
            }
    
            // Fungsi untuk memperbarui jumlah item di keranjang di navbar
            function updateCartCount(count) {
                $('#cart-count').text(count);
            }
    
            // Tangani pengiriman FORM AJAX (hanya untuk "Masukkan Keranjang" sekarang)
            $('.add-to-cart-form').on('submit', function(e) {
                e.preventDefault(); // Mencegah pengiriman formulir standar (reload halaman)
    
                var productId = $(this).data('product-id');
                var form = $(this);
                var token = form.find('input[name="_token"]').val();
    
                // Ini adalah aksi "Masukkan Keranjang" (add-to-cart)
                // Tombol "Beli Sekarang" sudah ditangani oleh form submission HTML biasa
                $.ajax({
                    url: '{{ route("cart.add", ["id" => ":productId"]) }}'.replace(':productId', productId),
                    method: 'POST',
                    data: {
                        _token: token,
                        product_id: productId
                    },
                    success: function(response) {
                        if (response.success) {
                            updateCartCount(response.cart_count);
                            // Opsional: Notifikasi sukses non-alert (misalnya, popup toast)
                            // Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Produk ditambahkan ke keranjang!' });
                        } else {
                            alert('Gagal menambahkan produk ke keranjang: ' + (response.message || 'Terjadi kesalahan.'));
                        }
                    },
                    error: function(xhr) {
                        console.error("Error adding to cart:", xhr.responseText);
                        alert('Terjadi kesalahan saat menambahkan produk ke keranjang.');
                    }
                });
            });
    
            // Dapatkan jumlah keranjang saat halaman detail dimuat
            $.ajax({
                url: '{{ route("cart.count") }}',
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        updateCartCount(response.cart_count);
                    }
                },
                error: function(xhr) {
                    console.error("Error fetching cart count:", xhr.responseText);
                }
            });
        });
    </script>

</body>
</html>