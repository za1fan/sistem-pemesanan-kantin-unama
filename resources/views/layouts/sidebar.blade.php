<aside class="w-72 bg-slate-900 text-slate-100 min-h-screen">
    <div class="p-6 border-b border-slate-800">
        <h1 class="text-xl font-bold tracking-wide">Sistem Pemesanan</h1>
        <p class="text-sm text-slate-400">Kantin UNAMA</p>
    </div>

    <nav class="p-4 space-y-2 text-sm">
        @auth
            @if (auth()->user()->role === 'penjual')
                <p class="px-2 text-xs text-slate-400 uppercase mt-2">Menu Penjual</p>

                <a href="{{ route('penjual.dashboard') }}"
                   class="block px-4 py-2 rounded-full hover:bg-slate-800 {{ request()->routeIs('penjual.dashboard') ? 'bg-slate-800 font-semibold' : '' }}">
                    Dashboard Penjual
                </a>
            @endif

            @if (auth()->user()->role === 'mahasiswa')
                <p class="px-2 text-xs text-slate-400 uppercase mt-2">Menu</p>

                <a href="{{ route('pesan', ['meja' => request('meja'), 'stand' => request('stand')]) }}"
                   class="block px-4 py-2 rounded-full hover:bg-slate-800 {{ request()->routeIs('pesan') ? 'bg-slate-800 font-semibold' : '' }}">
                    Pesan Makanan
                </a>

                <a href="{{ route('keranjang', ['meja' => request('meja'), 'stand' => request('stand')]) }}"
                    class="block px-4 py-2 hover:bg-gray-100">
                    Keranjang
                </a>

                <a href="{{ route('pesanan.saya') }}"
                   class="block px-4 py-2 rounded-full hover:bg-slate-800 {{ request()->routeIs('pesanan.saya') ? 'bg-slate-800 font-semibold' : '' }}">
                    Pesanan Saya
                </a>
            @endif
        @endauth
    </nav>
</aside>
