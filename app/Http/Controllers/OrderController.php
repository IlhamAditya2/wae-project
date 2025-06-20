<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function index()
{
    $orders = Order::with('items')->latest()->get(); // ambil data + item-nya
    return view('orders.index', compact('orders'));
}

public function downloadStruk($id)
    {
        // Ambil order beserta relasi item-nya
        $order = Order::with('items')->findOrFail($id);

        // Load view untuk PDF
        $pdf = Pdf::loadView('orders.struk', compact('order'));

        // Kembalikan file PDF untuk di-download
        return $pdf->download('struk-order-' . $order->id . '.pdf');
    }
}
