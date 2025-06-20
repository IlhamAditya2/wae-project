<x-app-layout>
<x-slot name="header">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('products.index') }}" class="text-decoration-none text-dark fw-bold">Daftar Produk</a>
        <a href="{{ route('products.create') }}" class="text-decoration-none text-dark fw-bold">Tambah Produk</a>
    </div>
</x-slot>

    <div class="py-6 max-w-2xl mx-auto sm:px-6 lg:px-8">
       <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div>
        <label>Nama Produk</label>
        <input type="text" name="name" required class="border rounded p-2 w-full">
    </div>

    <div class="mt-4">
        <label>Deskripsi</label>
        <textarea name="description" required class="border rounded p-2 w-full"></textarea>
    </div>

    <div class="mt-4">
        <label>Harga</label>
        <input type="number" name="price" required class="border rounded p-2 w-full">
    </div>

    <div class="mt-4">
        <label>Upload Gambar</label>
        <input type="file" name="image" accept="image/*" required class="border rounded p-2 w-full">
    </div>

    <div class="mt-4">
        <button type="submit" class="bg-blue-600 text-white rounded px-4 py-2">Simpan</button>
    </div>
</form>

    </div>
</x-app-layout>
