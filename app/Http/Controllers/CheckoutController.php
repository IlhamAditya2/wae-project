<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function process(Request $request)
{
    $selected = $request->input('selected_items', []);
    $cart = session('cart', []);
    $items = [];

    foreach ($selected as $id) {
        if (isset($cart[$id])) {
            $items[] = $cart[$id];
        }
    }

    if (count($items) == 0) {
        return redirect()->back()->with('error', 'Tidak ada produk yang dipilih.');
    }

    // Tampilkan halaman konfirmasi checkout atau proses pembayaran
    return view('checkout.confirm', ['items' => $items]);
}

public function showCheckoutForm(Request $request)
{
    $selected = $request->input('selected_items', []);
    $cart = session('cart', []);
    $items = [];
    $total = 0;

    foreach ($selected as $id) {
        if (isset($cart[$id])) {
            $items[$id] = $cart[$id];
            $total += $cart[$id]['price'] * $cart[$id]['quantity'];
        }
    }

    if (count($items) === 0) {
        return redirect()->back()->with('error', 'Tidak ada produk yang dipilih.');
    }

    // ⬅️ Simpan items ke session supaya bisa dipakai di finalize
    session(['checkout_items' => $items]);

    return view('checkout.form', compact('items', 'total'));
}



public function showCheckoutFormSingle(Request $request)
    {
        $productId = $request->query('product_id'); // Ambil product_id dari query string
        $cart = session('cart', []);
        $items = [];
        $total = 0;

        if (isset($cart[$productId])) {
            $items[$productId] = $cart[$productId];
            $total += $cart[$productId]['price'] * $cart[$productId]['quantity'];
        }

        if (count($items) === 0) {
            // Ini bisa terjadi jika produk_id yang dikirim tidak ada di keranjang
            return redirect()->back()->with('error', 'Produk tidak ditemukan di keranjang untuk checkout.');
        }

        session(['checkout_items' => $items]); // Simpan item yang hanya satu produk ini
        return view('checkout.form', compact('items', 'total')); // Gunakan view checkout.form yang sama
    }


public function finalize(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'payment_method' => 'required|string|max:50',
        ]);

        $cart = session('cart', []);

        if (count($cart) == 0) {
            return redirect('/cart')->with('error', 'Keranjang kosong!');
        }

        // Hitung total harga
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Simpan order
        $order = Order::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'payment_method' => $data['payment_method'],
            'total_price' => $total,
        ]);

        // Simpan order items
        foreach ($cart as $item) {
            $order->items()->create([
                'product_name' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        // Kosongkan session cart
        session()->forget('cart');

        // return redirect('checkout.success', ['order' => $order->id])->with('success', 'Pesanan berhasil dibuat!');
        return redirect()->route('checkout.success', ['order' => $order->id]);

    }

public function showForm(Request $request)
    {
        $cart = session('cart', []);

        if (count($cart) == 0) {
            return redirect('/cart')->with('error', 'Keranjang kosong!');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('checkout.form', compact('cart', 'total'));
    }

    public function success(Order $order)
    {
        return view('checkout.success', compact('order'));
    }

//     public function downloadStruk($id)
// {
//     $order = Order::with('items')->findOrFail($id);
//     $pdf = Pdf::loadView('orders.struk', compact('order'));
//     return $pdf->download('struk-order-' . $order->id . '.pdf');
// }





public function processSingleProductCheckout(Request $request)
    {
        $productId = Session::get('single_checkout_product_id'); // Ambil ID produk dari sesi
        $cart = Session::get('cart', []); // Ambil keranjang utama

        $itemToCheckout = null; // Variabel untuk menyimpan detail produk yang akan di-checkout
        $total = 0;

        // Pastikan produk ada di keranjang dan merupakan produk yang akan dibeli langsung
        if ($productId && isset($cart[$productId])) {
            $itemToCheckout = $cart[$productId];
            $total = $itemToCheckout['price'] * $itemToCheckout['quantity'];
        }

        // Jika tidak ada produk yang ditemukan untuk checkout langsung
        if (!$itemToCheckout) {
            return redirect()->route('welcome')->with('error', 'Tidak ada produk untuk checkout langsung. Silakan kembali berbelanja.');
        }

        // Render view formulir checkout khusus satu produk
        // Ini adalah file baru yang akan Anda buat: resources/views/checkout/process-single.blade.php
        return view('checkout.process-single', compact('itemToCheckout', 'total'));
    }

    // Metode ini akan memfinalisasi pesanan dari formulir pembayaran langsung satu produk
    // Ini dipanggil melalui route POST: /checkout/finalize-single
    public function finalizeSingleProductCheckout(Request $request)
    {
        // Validasi data input form (nama, telepon, alamat, metode pembayaran)
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'payment_method' => 'required|string|max:50',
        ]);

        $productId = Session::get('single_checkout_product_id'); // Ambil ID produk dari sesi
        $cart = Session::get('cart', []); // Ambil keranjang utama

        $itemToFinalize = null;
        if ($productId && isset($cart[$productId])) {
            $itemToFinalize = $cart[$productId];
        }

        // Jika produk tidak ditemukan di sesi atau keranjang saat finalisasi
        if (!$itemToFinalize) {
            return redirect()->route('welcome')->with('error', 'Produk untuk finalisasi tidak ditemukan. Silakan coba lagi.');
        }

        DB::beginTransaction(); // Memulai transaksi database
        try {
            // Hitung total harga untuk keamanan (meskipun sudah dihitung di view)
            $total = $itemToFinalize['price'] * $itemToFinalize['quantity'];

            // Simpan data order ke tabel orders
            $order = Order::create([
                'name' => $data['name'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'payment_method' => $data['payment_method'],
                'total_price' => $total,
                // 'user_id' => auth()->id(), // Jika Anda punya user yang login
            ]);

            // Simpan detail item order ke tabel order_items (hanya satu item ini)
            $order->items()->create([
                'product_id' => $productId, // Simpan ID produk asli
                'product_name' => $itemToFinalize['name'],
                'quantity' => $itemToFinalize['quantity'],
                'price' => $itemToFinalize['price'],
            ]);

            // Hapus produk ini dari keranjang utama setelah dibeli langsung
            $cart = Session::get('cart', []);
            if (isset($cart[$productId])) {
                unset($cart[$productId]);
            }
            Session::put('cart', $cart); // Perbarui sesi keranjang utama

            Session::forget('single_checkout_product_id'); // Bersihkan sesi produk tunggal setelah checkout

            DB::commit(); // Commit transaksi database

            // Redirect ke halaman sukses dengan ID order
            return redirect()->route('checkout.success', ['order' => $order->id]);

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback jika ada error
            \Log::error("Finalize single product checkout failed: " . $e->getMessage()); // Catat error
            return redirect()->back()->with('error', 'Gagal memproses pembelian langsung. Silakan coba lagi.');
        }
    }
}
