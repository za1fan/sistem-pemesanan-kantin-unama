@extends('layouts.kantin')

@section('title', 'Keranjang')

@section('content')
    <div class="topbar">
        <div>
            <h2>Keranjang</h2>
            <p>Meja: {{ $meja ?? '-' }}</p>
        </div>

        <a class="link" href="{{ route('pesan', ['meja' => $meja]) }}">Kembali ke Menu</a>
    </div>

    @if(!isset($orders) || $orders->count() == 0)
        <div class="card">
            <div class="desc">Keranjang masih kosong.</div>
        </div>
    @else
        @foreach($orders as $order)
            @php
                $totalStand = $order->details->sum(fn($i) => $i->harga * $i->qty);
            @endphp

            <div class="card">
                <div class="desc">
                    Status: <b style="color:#fff;">{{ $order->status }}</b>
                    <span style="opacity:.8;"> | Stand: {{ $order->stand_id }}</span>
                </div>

                <div style="margin-top:14px;">
                    @foreach($order->details as $item)
                        <div style="display:flex; justify-content:space-between; gap:16px; padding:8px 0;">
                            <div>
                                <b style="color:#fff;">{{ $item->menu->nama_menu ?? 'Menu' }}</b>
                                <div class="desc" style="margin-top:4px;">
                                    Qty: {{ $item->qty }} | Harga: Rp {{ number_format($item->harga) }}
                                </div>
                            </div>

                            <div style="text-align:right;">
                                <div class="desc">Subtotal</div>
                                <div class="price">Rp {{ number_format($item->harga * $item->qty) }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div style="display:flex; justify-content:space-between; align-items:center; gap:12px; margin-top:14px;">
                    <div>
                        <div class="desc">Total Harga</div>
                        <div class="price">Rp {{ number_format($totalStand) }}</div>
                    </div>

                    {{-- Checkout per stand (karena penjual berbeda) --}}
                    <form action="{{ route('order.checkout') }}" method="POST">
                        @csrf
                        <input type="hidden" name="meja" value="{{ $meja }}">
                        <input type="hidden" name="stand" value="{{ $order->stand_id }}">
                        <button class="btn" type="submit">Checkout</button>
                    </form>
                </div>
                <form action="{{ route('order.hapus', $order->id) }}" method="POST"
                    onsubmit="return confirm('Hapus keranjang pending ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn" type="submit" style="background: rgba(255,60,60,.25);">
                        Hapus
                    </button>
                </form>
            </div>
        @endforeach
    @endif
@endsection
