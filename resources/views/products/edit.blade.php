<x-app-layout>
    <x-slot name="header">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('products.index') }}" class="text-decoration-none text-dark fw-bold">Daftar Produk</a>
            <a href="{{ route('products.create') }}" class="text-decoration-none text-dark fw-bold">Tambah Produk</a>
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm me-2">Edit</a>
        </div>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="card shadow-sm p-4">
            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Produk</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ $product->name }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control" id="description" rows="4" required>{{ $product->description }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Harga</label>
                    <input type="number" name="price" class="form-control" id="price" value="{{ $product->price }}" required>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Upload Gambar (biarkan kosong jika tidak diganti)</label>
                    <input type="file" name="image" class="form-control" id="image" accept="image/*">
                    <small class="text-muted">Gambar saat ini:</small><br>
                    <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" class="img-thumbnail mt-2" style="width: 150px; height: auto;">
                </div>

                <button type="submit" class="btn btn-primary">Perbarui</button>
            </form>
        </div>
    </div>
</x-app-layout>
