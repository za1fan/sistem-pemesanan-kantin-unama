{{-- resources/views/menu/index.blade.php (atau file view menu kamu) --}}

{{-- Tombol kembali ke dashboard --}}
<div class="mb-4">
    <a href="{{ route('dashboard') }}"
       class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 inline-block">
        Kembali
    </a>
</div>

{{-- List menu --}}
@if(isset($menus) && count($menus))
    @foreach ($menus as $menu)
        <div class="bg-white rounded-lg shadow p-4 flex justify-between items-center mb-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">{{ $menu->nama_menu }}</h3>
                <p class="text-gray-600">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
            </div>

            <div>
                <form action="{{ route('order.tambah') }}" method="POST">
                    @csrf
                    <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                    <input type="hidden" name="meja" value="{{ $meja }}">
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                        Tambah
                    </button>
                </form>
            </div>
        </div>
    @endforeach
@else
    <div class="bg-white rounded-lg shadow p-4">
        <p class="text-gray-600">Menu belum tersedia.</p>
    </div>
@endif

{{-- Debug meja (opsional, boleh hapus kalau sudah tidak perlu) --}}
<pre>{{ $meja }}</pre>
