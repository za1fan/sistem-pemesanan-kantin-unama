<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        // Ambil meja dari query atau dari session
        $meja = $request->query('meja') ?? session('meja_aktif');

        // Jika ada query meja, simpan sebagai meja aktif
        if ($request->filled('meja')) {
            session(['meja_aktif' => $request->query('meja')]);
        }

        // Kalau belum ada meja sama sekali, arahkan user untuk scan QR dulu
        if (!$meja) {
            return redirect('/dashboard')->with('error', 'Silakan scan QR meja terlebih dahulu.');
        }

        // Ambil stand dari query
        $standId = $request->query('stand');

        // Kalau stand belum dipilih, tampilkan halaman pilih stand
        if (!$standId) {
            $stands = User::where('role', 'penjual')->get();
            return view('mahasiswa.pilih-stand', compact('stands', 'meja'));
        }

        // Kalau stand sudah dipilih, tampilkan menu sesuai stand
        $menus = Menu::where('user_id', $standId)->get();

        return view('mahasiswa.menu', compact('menus', 'meja', 'standId'));
    }
}
