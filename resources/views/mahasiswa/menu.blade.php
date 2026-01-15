@extends('layouts.kantin')

@section('title', 'Menu Kantin')

@section('content')
    <div class="topbar">
        <div>
            <h2>Menu Kantin</h2>
            <p>Meja = {{ $meja }}</p>
        </div>

        <a class="link" href="{{ route('pesan', ['meja' => $meja]) }}">Ganti Stand</a>
    </div>

    {{-- TAMPILKAN ERROR VALIDASI (taruh di atas list menu) --}}
    @if ($errors->any())
        <div class="card" style="border:1px solid rgba(255,0,0,.35);">
            <div class="desc" style="color:#ffd2d2; margin:0;">
                {{ implode(' | ', $errors->all()) }}
            </div>
        </div>
    @endif

    @forelse($menus as $menu)
        <div class="card">
            <div class="cardRow">
                <div>
                    <div class="title">{{ $menu->nama_menu }}</div>
                    <div class="desc">{{ $menu->deskripsi }}</div>
                </div>

                <div class="price">Rp {{ number_format($menu->harga) }}</div>
            </div>

            <form action="{{ route('keranjang.tambah') }}" method="POST">
                @csrf
                <input type="hidden" name="menuid" value="{{ $menu->id }}">
                <input type="hidden" name="meja" value="{{ $meja }}">
                <input type="hidden" name="stand" value="{{ $standId }}">
                <button class="btn" type="submit">Tambah ke Keranjang</button>
            </form>
        </div>
    @empty
        <div class="card">
            <div class="desc" style="margin:0;">Menu belum tersedia.</div>
        </div>
    @endforelse
@endsection
