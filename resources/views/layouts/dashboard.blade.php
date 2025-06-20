<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Produk')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">
            <img src="{{ asset('logoo.png') }}" alt="Logo" height="50" class="me-2">
            Toko Online
        </a>
        <div class="ms-auto">
            <!-- @if(auth()->check())
                <a href="{{ route('profile') }}" class="btn btn-outline-success me-2">Profil</a>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-primary">Login</a>
            @endif -->
        </div>
    </div>
</nav>

<!-- Konten Utama -->
<div class="container mt-5">
    @yield('content')
</div>

</body>
</html>
