@extends('layouts.kantin')

@section('title', 'Pilih Stand')

@section('content')
    <div class="topbar">
        <div>
            <h2>Pilih Stand / Kantin</h2>
            <p>Meja: {{ $meja }}</p>
        </div>

        <div style="margin-left:auto;">
            <a class="btn" href="{{ route('dashboard') }}">Kembali</a>
        </div>
    </div>

    <div style="display:flex; flex-direction:column; gap:16px;">
        @forelse ($stands as $stand)
            <a href="{{ route('pesan', ['meja' => $meja, 'stand' => $stand->id]) }}" style="text-decoration:none;">
                <div class="card" style="padding:20px 22px;">
                    <div class="cardRow" style="align-items:center; gap:14px;">
                        <div style="display:flex; flex-direction:column; gap:6px;">
                            <div class="title" style="font-size:20px; line-height:1.2;">
                                {{ $stand->name }}
                            </div>
                            <div class="desc" style="margin:0;">
                                Klik untuk lihat menu
                            </div>
                        </div>

                        <div style="margin-left:auto;">
                            <div class="price" style="opacity:.9;">Stand</div>
                        </div>
                    </div>
                </div>
            </a>
        @empty
            <div class="card" style="padding:18px 20px;">
                <div class="desc" style="margin:0;">Belum ada stand penjual.</div>
            </div>
        @endforelse
    </div>
@endsection
