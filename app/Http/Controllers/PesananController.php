<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function saya(Request $request)
    {
        $meja = $request->get('meja') ?? session('meja_aktif');

        $ordersQuery = Order::whereIn('status', ['dipesan', 'diproses', 'selesai'])->latest();

        if ($meja) {
            $ordersQuery->where('meja', $meja);
        }

        $orders = $ordersQuery->get();

        return view('mahasiswa.pesanan', compact('orders', 'meja'));
    }

}
