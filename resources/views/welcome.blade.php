<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    <style>
        .btn-outline-secondary:hover {
            background-color: #052659 !important;
            color: white !important;
            border-color: #052659 !important;
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

<div class="swiper w-full max-w-screen-xl mx-auto rounded overflow-hidden mb-4" style="height: 400px; max-height: 400px;">
  <div class="swiper-wrapper">
    <div class="swiper-slide d-flex justify-content-center align-items-center">
      <img src="{{ asset('images/sample3.jpg') }}" 
           style="width: 100%; height: auto;" 
           alt="Gambar 1">
    </div>
    <div class="swiper-slide">
        <video width="100%" height="auto" autoplay muted loop>
            <source src="{{ asset('images/vid1y.mp4') }}" type="video/mp4">
            Browser Anda tidak mendukung video.
        </video>
    </div>
  </div>
  <div class="swiper-button-next text-white"></div>
  <div class="swiper-button-prev text-white"></div>
</div>

<div class="container mt-5">
    <h1 class="mb-4">Daftar Produk</h1>
    {{-- <div class="row">
        @forelse ($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('images/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        <p class="card-text fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

                        <form class="add-to-cart-form" data-product-id="{{ $product->id }}">
                            @csrf
                            <button type="submit" class="btn btn-primary">Masukkan Keranjang</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p>Tidak ada produk tersedia.</p>
        @endforelse
    </div> --}}
    <div class="row">
        @forelse ($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm"> {{-- Tambah shadow-sm agar lebih terlihat clickable --}}
                    {{-- Bungkus seluruh konten kartu dengan tag <a>, kecuali bagian 'add to cart' --}}
                    <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none text-dark d-flex flex-column h-100">
                        <img src="{{ asset('images/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body flex-grow-1"> {{-- flex-grow-1 agar body mengisi ruang --}}
                            <h5 class="card-title">{{ $product->name }}</h5>
                            {{-- Deskripsi singkat. Tombol "Lihat Selengkapnya" di sini akan mengarah ke halaman detail. --}}
                            <p class="card-text description-text">
                                {{ Str::limit($product->description, 100) }}
                                @if (strlen($product->description) > 100)
                                    <span class="text-muted">...</span> <span class="text-primary fw-bold">Lihat Selengkapnya</span>
                                @endif
                            </p>
                            <p class="card-text fw-bold mt-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                    </a> {{-- Tutup tag <a> untuk link produk --}}
    
                    {{-- Formulir "Masukkan Keranjang" tetap di luar link agar bisa dipicu via AJAX --}}
                    <div class="card-footer bg-white border-top-0 pt-0">
                        <form class="add-to-cart-form" data-product-id="{{ $product->id }}">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100">Masukkan Keranjang</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p>Tidak ada produk tersedia.</p>
        @endforelse
    </div>
    
</div>

<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Inisialisasi Swiper
        new Swiper('.swiper', {
            loop: true,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });

        function updateCartCount(count) {
            $('#cart-count').text(count);
        }

        $('.add-to-cart-form').on('submit', function(e) {
            e.preventDefault();

            var productId = $(this).data('product-id');
            var form = $(this);
            var token = form.find('input[name="_token"]').val();

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