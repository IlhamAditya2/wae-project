<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);

        $cartCount = array_sum(array_column($cart, 'quantity'));

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang!',
            'cart_count' => $cartCount 
        ]);
    }

    public function index()
    {
    $cart = session()->get('cart', []);
    return view('cart.index', compact('cart'));
    }

    

    public function increase(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index');
    }

    public function decrease(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']--;

            if ($cart[$id]['quantity'] <= 0) {
                unset($cart[$id]);
            }

            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index');
    }

    public function getCartCount()
    {
        $cart = session()->get('cart', []);
        $cartCount = array_sum(array_column($cart, 'quantity'));

        return response()->json([
            'success' => true,
            'cart_count' => $cartCount
        ]);
    }

}
