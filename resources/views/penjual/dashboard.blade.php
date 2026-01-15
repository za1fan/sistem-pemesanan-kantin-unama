@extends('layouts.kantin')

@section('title', 'Dashboard Penjual')

@section('content')
    <div class="topbar" style="display:flex; justify-content:space-between; align-items:flex-start; gap:16px;">
        <div>
            <h2>Dashboard Penjual</h2>
            <p>Pesanan masuk</p>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn" type="submit" style="background: rgba(255,60,60,.25);">
                Logout
            </button>
        </form>
    </div>

    @if (session('success'))
        <div class="card" style="background: rgba(21,26,32,.65);">
            {{ session('success') }}
        </div>
    @endif

    @forelse ($orders as $order)
        <div class="card">
            <div class="cardRow">
                <div style="flex:1;">
                    <div class="title">Meja: {{ $order->meja }}</div>
                    <div class="desc">Status: {{ $order->status }}</div>

                    <div class="desc" style="margin-top:14px;">
                        @foreach ($order->details as $item)
                            <div>
                                {{ $item->menu->nama_menu ?? 'Menu' }}
                                ({{ $item->qty }}x) - Rp {{ number_format($item->harga) }}
                            </div>
                        @endforeach
                    </div>

                    <div class="desc" style="margin-top:12px; font-weight:800; color:#fff;">
                        Total: Rp {{ number_format($order->total_harga) }}
                    </div>

                    <div style="margin-top:16px; display:flex; gap:10px; flex-wrap:wrap;">
                        @if ($order->status == 'dipesan')
                            <form method="POST" action="{{ route('penjual.order.proses', $order->id) }}">
                                @csrf
                                <button class="btn" type="submit">Proses</button>
                            </form>
                        @endif

                        @if ($order->status == 'diproses')
                            <form method="POST" action="{{ route('penjual.order.selesai', $order->id) }}">
                                @csrf
                                <button class="btn" type="submit">Selesai</button>
                            </form>
                        @endif

                        @if ($order->status == 'selesai')
                            <form method="POST" action="{{ route('penjual.order.hapus', $order->id) }}"
                                  onsubmit="return confirm('Hapus pesanan ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn" type="submit" style="background: rgba(255,60,60,.25);">
                                    Hapus
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="card">
            <div class="desc" style="color: rgba(255,255,255,.8);">Belum ada pesanan masuk.</div>
        </div>
    @endforelse
@endsection
