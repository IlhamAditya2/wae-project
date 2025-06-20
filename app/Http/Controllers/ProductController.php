<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric',
        'image' => 'required|image|mimes:jpg, jpeg,png|max:2048',
    ]);

    $imageName = time() . '.' . $request->image->extension();
    $request->image->move(public_path('images'), $imageName);

    Product::create([
        'name' => $validated['name'],
        'description' => $validated['description'],
        'price' => $validated['price'],
        'image' => $imageName,
    ]);

    // Product::create($validated);

    return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id); // Cari produk berdasarkan ID, jika tidak ketemu akan otomatis 404 Not Found
        return view('products.show', compact('product')); // Mengirim data produk ke view products/show.blade.php
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $product->image = $imageName;
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }


    public function buyNow(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $cart = Session::get('cart', []);

        // Tambahkan produk ke keranjang (jika belum ada atau tingkatkan kuantitas)
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }
        Session::put('cart', $cart);

        // Langsung arahkan ke halaman form checkout.
        // Kita akan mengirimkan ID produk ini sebagai bagian dari redirect
        // agar showCheckoutForm bisa tahu produk mana yang "dibeli sekarang".
        return redirect()->route('checkout.form.single', ['product_id' => $productId]);
    }

    public function handleDirectBuy(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $cart = Session::get('cart', []);

        // Tambahkan produk ke keranjang utama (jika belum ada atau tingkatkan kuantitas)
        // Ini penting karena data produknya nanti akan diambil dari $cart untuk proses checkout.
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }
        Session::put('cart', $cart);

        // Simpan ID produk yang akan langsung dibeli ke sesi khusus
        // agar CheckoutController bisa tahu produk mana yang harus diproses.
        Session::put('single_checkout_product_id', $productId);

        // Langsung redirect ke halaman proses checkout untuk satu produk
        // Ini akan memanggil metode 'processSingleProductCheckout' di CheckoutController
        return redirect()->route('checkout.process-single');
    }
}
