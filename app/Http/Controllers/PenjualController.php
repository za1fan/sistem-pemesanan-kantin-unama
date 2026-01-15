<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenjualController extends Controller
{
    public function dashboard()
    {
        $orders = Order::with('details.menu')
            ->where('stand_id', Auth::id())
            ->whereIn('status', ['dipesan', 'diproses', 'selesai'])
            ->latest()
            ->get();

        return view('penjual.dashboard', compact('orders'));
    }

    public function proses($id)
    {
        Order::where('id', $id)->update([
            'status' => 'diproses'
        ]);

        return back();
    }

    public function selesai($id)
    {
        Order::where('id', $id)->update([
            'status' => 'selesai'
        ]);

        return back();
    }

    public function hapus($id)
    {
        $order = \App\Models\Order::findOrFail($id);

        // hapus detail dulu, baru hapus order (biar aman walau FK belum cascade)
        \App\Models\OrderDetail::where('order_id', $order->id)->delete();
        $order->delete();

        return back()->with('success', 'Pesanan dihapus.');
    }

}
