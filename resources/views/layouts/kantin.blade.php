<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Menu Kantin')</title>

    <style>
        :root{
            --bg: #6f7174;
            --sidebar: #111418;
            --sidebarText: #f1f5f9;
            --sidebarMuted: rgba(241,245,249,.65);
            --card: #151a20;
            --cardText: #ffffff;
            --cardMuted: rgba(255,255,255,.70);
        }

        *{ box-sizing:border-box; }
        body{ margin:0; font-family: Arial, Helvetica, sans-serif; background: var(--bg); }

        .wrap{ min-height:100vh; display:flex; }

        .sidebar{
            width: 300px;
            background: var(--sidebar);
            color: var(--sidebarText);
            min-height: 100vh;
        }
        .brand{ padding:24px; border-bottom:1px solid rgba(255,255,255,.08); }
        .brand h1{ margin:0 0 6px 0; font-size:20px; }
        .brand p{ margin:0; font-size:13px; color: var(--sidebarMuted); }

        .nav{ padding:16px; }
        .nav .label{ font-size:12px; letter-spacing:.08em; text-transform:uppercase; color: var(--sidebarMuted); margin:10px 8px; }
        .nav a{
            display:block;
            padding:10px 14px;
            border-radius:999px;
            color: var(--sidebarText);
            text-decoration:none;
            margin:6px 0;
        }
        .nav a:hover{ background: rgba(255,255,255,.08); }
        .nav a.active{ background: rgba(255,255,255,.12); font-weight:700; }

        .content{ flex:1; padding:40px; color:#fff; }

        .topbar{
            display:flex;
            align-items:flex-start;
            justify-content:space-between;
            gap:16px;
            margin-bottom:28px;
        }
        .topbar h2{ margin:0; font-size:26px; }
        .topbar p{ margin:6px 0 0 0; opacity:.9; }
        .link{ color:#fff; font-weight:700; text-decoration:none; }
        .link:hover{ text-decoration:underline; }

        .card{
            background: var(--card);
            color: var(--cardText);
            border-radius: 28px;
            padding: 28px 34px;
            box-shadow: 0 16px 40px rgba(0,0,0,.25);
            margin-bottom: 20px;
        }
        .cardRow{ display:flex; justify-content:space-between; gap:24px; }
        .title{ font-size:28px; font-weight:800; margin:0; }
        .desc{ margin-top:8px; color: var(--cardMuted); }
        .price{ font-size:18px; font-weight:800; white-space:nowrap; }

        .btn{
            margin-top:18px;
            border:0;
            padding:10px 16px;
            border-radius:999px;
            background: rgba(255,255,255,.12);
            color:#fff;
            cursor:pointer;
        }
        .btn:hover{ background: rgba(255,255,255,.18); }
    </style>
</head>

<body>
    <div class="wrap">
        <aside class="sidebar">
            <div class="brand">
                <h1>Sistem Pemesanan</h1>
                <p>Kantin UNAMA</p>
            </div>

            <nav class="nav">
                @auth
                    @if (auth()->user()->role === 'penjual')
                        <div class="label">Menu Penjual</div>
                        <a href="{{ route('penjual.dashboard') }}" class="{{ request()->routeIs('penjual.dashboard') ? 'active' : '' }}">
                            Dashboard Penjual
                        </a>
                    @endif

                    @if (auth()->user()->role === 'mahasiswa')
                        <div class="label">Menu</div>
                        <a href="{{ route('pesan', ['meja' => request('meja'), 'stand' => request('stand')]) }}" class="{{ request()->routeIs('pesan') ? 'active' : '' }}">
                            Pesan Makanan
                        </a>
                        <a href="{{ route('keranjang', ['meja' => request('meja'), 'stand' => request('stand')]) }}" class="{{ request()->routeIs('keranjang') ? 'active' : '' }}">
                            Keranjang
                        </a>
                        <a href="{{ route('pesanan.saya') }}" class="{{ request()->routeIs('pesanan.saya') ? 'active' : '' }}">
                            Pesanan Saya
                        </a>
                    @endif
                @endauth
            </nav>
        </aside>

        <main class="content">
            @yield('content')
        </main>
    </div>
</body>
</html>
