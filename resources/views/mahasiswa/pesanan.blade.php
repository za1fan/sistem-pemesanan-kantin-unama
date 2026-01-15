@extends('layouts.kantin')

@section('title', 'Pesanan Saya')

@section('content')
    <div class="topbar">
        <div>
            <h2>Pesanan Saya</h2>
            @if(!empty($meja))
                <p>Meja aktif: {{ $meja }}</p>
            @endif
        </div>

        <a class="link" href="{{ route('dashboard') }}">Kembali ke Dashboard</a>
    </div>

    @if(session('success'))
        <div class="card" style="background: rgba(21,26,32,.65);">
            {{ session('success') }}
        </div>
    @endif

    @if(isset($orders) && $orders->count())
        @foreach($orders as $order)
            @php
                // Ambil item + relasi menu supaya bisa tampil nama menu (kalau relation ada)
                $items = \App\Models\OrderDetail::with('menu')->where('order_id', $order->id)->get();
                $total = $items->sum(fn ($i) => $i->harga * $i->qty);
            @endphp

            <div class="card">
                <div class="cardRow" style="align-items:flex-start;">
                    <div style="flex:1;">
                        <div class="desc">Meja</div>
                        <div class="title" style="font-size:22px;">{{ $order->meja }}</div>

                        <div class="desc" style="margin-top:14px; font-weight:700; color:#fff;">Item</div>

                        @if($items->count())
                            <div style="margin-top:8px;">
                                @foreach($items as $item)
                                    <div style="padding:8px 0; border-bottom:1px solid rgba(255,255,255,.06);">
                                        <div style="font-weight:800; color:#fff;">
                                            {{ $item->menu->nama_menu ?? ('Menu ID: ' . $item->menu_id) }}
                                        </div>
                                        <div class="desc" style="margin-top:4px;">
                                            Qty: {{ $item->qty }} | Harga: Rp {{ number_format($item->harga) }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="desc" style="margin-top:8px;">Tidak ada item.</div>
                        @endif
                    </div>

                    <div style="min-width:220px; text-align:right;">
                        <div class="desc">Status</div>
                        <div style="margin-top:6px; font-weight:800; color:#fff;">
                            {{ $order->status }}
                        </div>

                        <div class="desc" style="margin-top:14px;">Total</div>
                        <div style="margin-top:6px; font-weight:900; color:#8bffb0;">
                            Rp {{ number_format($total) }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="card">
            <div class="desc">Belum ada pesanan.</div>
        </div>
    @endif

    <script>
        setInterval(() => {
            location.reload();
        }, 5000);
    </script>
@endsection
