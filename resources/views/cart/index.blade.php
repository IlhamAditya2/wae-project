<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Keranjang Belanja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>

       body {
            margin-bottom: 100px; /* beri ruang bawah supaya konten gak ketutup bar checkout */
        }
        .cart-item {
            display: flex;
            align-items: center;
            padding: 15px 10px;
            border-bottom: 1px solid #eee;
            background-color: rgb(167, 194, 220);
            border-radius: 10px;
            margin-bottom: 12px;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .form-check {
            margin-right: 15px;
            flex-shrink: 0;
        }

        .cart-item-img img {
            width: 100px;
            border-radius: 8px;
            object-fit: cover;
        }

        .cart-item-info {
            flex: 1;
            margin-left: 15px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: #212529;
        }

        .cart-item-info .name {
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 5px;
            color: #212529;
        }

        .cart-item-info .price {
            color: #052659;
            font-weight: 700;
            font-size: 1rem;
        }

        .cart-item-qty {
            flex: 0 0 130px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
        }

        .qty-btn {
            width: 30px;
            height: 30px;
            border: 1px solid #ddd;
            background: #052659;
            color: white;
            font-size: 20px;
            line-height: 1;
            font-weight: 700;
            border-radius: 4px;
            cursor: pointer;
            user-select: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s ease;
        }

        .qty-btn:hover {
            background: #5483B3;
        }

        .qty-number {
            min-width: 30px;
            text-align: center;
            font-weight: 600;
            font-size: 1rem;
            color: #212529;
        }

        /* Bagian checkout sticky di bawah */
        .checkout-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color:rgb(206, 215, 224);
            color: white;
            padding: 5px 30px 15px 30px;
            box-shadow: 0 -3px 8px rgba(0,0,0,0.2);
            display: flex;
            justify-content: flex-end;
            align-items: center;
            z-index: 1000;
        }

        .checkout-bar .total-price {
            font-size: 1rem;
            font-weight: bold;
            color:black;
        }


        .checkout-bar button {
            background-color:  #052659;
            border: none;
            padding: 10px 15px;
            font-size: 1.1rem;
            font-weight: 700;
            border-radius: 6px;
            cursor: pointer;
            color: white;
            transition: background-color 0.3s ease;
            width: auto;
            min-width: 100px;
            flex-shrink: 0; /* penting ini */
            margin-left:30px;   
        }


        .checkout-bar button:hover {
            background-color:rgb(53, 88, 141);
        }
    </style>
</head>
<body>
<div class="container py-4">
    <div class="d-flex align-items-center mb-4" style="gap: 10px;">
        <a href="{{ url('/') }}" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left"></i>
        </a>

        <h1 class="mb-0">Keranjang Belanja</h1>
    </div>


    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('cart') && count(session('cart')) > 0)

        <div class="cart-list">
            @foreach(session('cart') as $id => $item)
                <div class="cart-item d-flex align-items-center mb-3 p-3 rounded bg-light">

                    {{-- Checkbox pilih produk --}}
                    <div class="form-check ms-3">
                        <input class="form-check-input" type="checkbox" name="selected_items[]" value="{{ $id }}" form="checkout-form" checked>
                    </div>


                     {{-- Gambar --}}
                    <div class="cart-item-img me-3">
                        <img src="{{ asset('images/' . $item['image']) }}" alt="{{ $item['name'] }}" class="img-thumbnail" style="width: 80px;">
                    </div>

                    {{-- Info produk --}}
                    <div class="cart-item-info flex-grow-1">
                        <div class="name fw-semibold">{{ $item['name'] }}</div>
                        <div class="price text-primary fw-bold">Rp {{ number_format($item['price'], 0, ',', '.') }}</div>
                    </div>

                    {{-- Form tombol decrease --}}
                    <form action="{{ route('cart.decrease', $id) }}" method="POST" class="qty-form me-2">
                        @csrf
                        <button type="submit" class="qty-btn btn btn-sm btn-outline-secondary">−</button>
                    </form>

                    {{-- Quantity --}}
                    <div class="qty-number px-3">{{ $item['quantity'] }}</div>

                    {{-- Form tombol increase --}}
                    <form action="{{ route('cart.increase', $id) }}" method="POST" class="qty-form ms-2 me-3">
                        @csrf
                        <button type="submit" class="qty-btn btn btn-sm btn-outline-secondary">+</button>
                    </form>

                   

                    

                </div>
            @endforeach
        </div>

        {{-- Form checkout terpisah --}}
        <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form" >
            @csrf
            @php
                $total = 0;
                foreach(session('cart') as $item) {
                    $total += $item['price'] * $item['quantity'];
                }
            @endphp

            <div class="checkout-bar">
                <div class="total-price">
                Total Harga: Rp {{ number_format($total, 0, ',', '.') }}
                </div>
                
                <button type="submit" class="btn btn-success btn-lg px-4">
                    Checkout
                </button>
            </div>
        </form>

    @else
        <p>Keranjang kamu kosong.</p>
    @endif
</div>

</body>
</html>
