<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Tambah Produk Baru
        </h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto sm:px-6 lg:px-8">
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div>
                <label class="block font-medium text-sm text-gray-700">Nama Produk</label>
                <input type="text" name="name" required class="mt-1 block w-full border rounded p-2">
            </div>

            <div class="mt-4">
                <label class="block font-medium text-sm text-gray-700">Deskripsi</label>
                <textarea name="description" required class="mt-1 block w-full border rounded p-2"></textarea>
            </div>

            <div class="mt-4">
                <label class="block font-medium text-sm text-gray-700">Harga</label>
                <input type="number" name="price" required class="mt-1 block w-full border rounded p-2">
            </div>

            <div class="mt-4">
                <label class="block font-medium text-sm text-gray-700">Upload Gambar</label>
                <input type="file" name="image" accept="image/*" required class="mt-1 block w-full border rounded p-2">
            </div>

            <div class="mt-4">
                <button type="submit" class="bg-blue-600 text-white rounded px-4 py-2">Simpan</button>
            </div>
        </form>
    </div>
</x-app-layout>
