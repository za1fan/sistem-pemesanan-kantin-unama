<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Menu;

class OrderController extends Controller
{
    // TAMBAH KE KERANJANG (pending dipisah per meja + stand)
    public function tambah(Request $request)
    {
        $request->validate([
            'meja' => 'required',
            'menuid' => 'required|exists:menus,id',
            'stand' => 'required|exists:users,id',
        ]);

        $order = Order::firstOrCreate([
            'meja' => $request->meja,
            'stand_id' => $request->stand,
            'status' => 'pending',
        ]);

        $detail = OrderDetail::where('order_id', $order->id)
            ->where('menu_id', $request->menuid)
            ->first();

        if ($detail) {
            $detail->qty += 1;
            $detail->save();
        } else {
            $menu = Menu::findOrFail($request->menuid);

            OrderDetail::create([
                'order_id' => $order->id,
                'menu_id' => $request->menuid,
                'qty' => 1,
                'harga' => $menu->harga,
            ]);
        }

        return back()->with('success', 'Menu ditambahkan.');
    }

    // TAMPILKAN KERANJANG (gabungan semua pending untuk meja)
    public function keranjang(Request $request)
    {
        $meja = $request->query('meja') ?? session('meja_aktif');

        // ambil semua order pending untuk meja ini (tiap stand = 1 order)
        $orders = Order::with(['details.menu'])
            ->where('status', 'pending')
            ->where('meja', $meja)
            ->whereNotNull('stand_id')
            ->latest()
            ->get();

        return view('mahasiswa.keranjang', compact('orders', 'meja'));
    }

    // CHECKOUT: pending -> dipesan (per meja + stand)
    public function checkout(Request $request)
    {
        $request->validate([
            'meja' => 'required',
            'stand' => 'required|exists:users,id',
        ]);

        $order = Order::where('status', 'pending')
            ->where('meja', $request->meja)
            ->where('stand_id', $request->stand)
            ->latest()
            ->first();

        if (!$order) {
            return redirect()->back()->with('success', 'Keranjang masih kosong.');
        }

        $items = OrderDetail::where('order_id', $order->id)->get();
        if ($items->count() == 0) {
            return redirect()->back()->with('success', 'Keranjang masih kosong.');
        }

        $total = 0;
        foreach ($items as $item) {
            $total += ($item->harga * $item->qty);
        }

        $order->total_harga = $total;
        $order->status = 'dipesan';
        $order->save();

        return redirect()->route('pesanan.saya')->with('success', 'Pesanan berhasil dibuat.');
    }

    public function hapus($id)
    {
        $order = Order::findOrFail($id);

        // Hapus hanya order yang masih pending (biar aman)
        if ($order->status !== 'pending') {
            return back()->with('success', 'Order ini sudah diproses, tidak bisa dihapus dari keranjang.');
        }

        OrderDetail::where('order_id', $order->id)->delete();
        $order->delete();

        return back()->with('success', 'Keranjang (pending) berhasil dihapus.');
    }

}
