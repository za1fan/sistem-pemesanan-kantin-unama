@extends('layouts.kantin')

@section('title', 'Dashboard')

@section('content')
    <div class="topbar">
        <div>
            <h2>Halo? Mau makan apa hari ini... :)</h2>
            <p>Selamat datang di Sistem Pemesanan Kantin UNAMA</p>
        </div>
    </div>

    {{-- Pilih meja --}}
    <div class="card" style="margin-top:18px;">
        <div class="title" style="font-size:22px;">Pilih meja</div>
        <div class="desc" style="margin-top:8px;">
            Bisa scan QR atau klik tombol meja untuk mulai pesan.
        </div>

        @php
            $maxMeja = 8; // ubah kalau jumlah meja lebih banyak
        @endphp

        <div style="margin-top:14px; display:grid; grid-template-columns:repeat(4, minmax(0, 1fr)); gap:14px;">
            @for($i = 1; $i <= $maxMeja; $i++)
                <div class="card" style="padding:14px; border-radius:16px;">
                    <div style="font-weight:900; color:#fff; margin-bottom:10px;">
                        Meja {{ $i }}
                    </div>

                    {{-- QR untuk di-scan --}}
                    <div style="background:#fff; border-radius:12px; padding:10px; display:flex; justify-content:center;">
                        <img
                            src="{{ url('/qrcode/meja/' . $i) }}"
                            alt="QR Meja {{ $i }}"
                            style="width:140px; height:140px;"
                        >
                    </div>

                    {{-- Tombol klik langsung --}}
                    <a class="btn"
                       href="{{ route('pesan', ['meja' => $i]) }}"
                       style="display:inline-block; margin-top:12px; width:100%; text-align:center;">
                        Pilih Meja 
                    </a>
                </div>
            @endfor
        </div>
    </div>
<script>
  setInterval(() => {
    location.reload();
  }, 20000); 
</script>
@endsection
