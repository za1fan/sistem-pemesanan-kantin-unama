<x-app-layout>
    <div class="container">
        <h2>Daftar Menu</h2>

        <a href="{{ route('menu.create') }}">Tambah Menu</a>

        <table border="1" cellpadding="10">
            <tr>
                <th>Nama</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
            @foreach ($menus as $menu)
            <tr>
                <td>{{ $menu->nama_menu }}</td>
                <td>Rp {{ number_format($menu->harga) }}</td>
                <td>
                    <a href="{{ route('menu.edit', $menu) }}">Edit</a>
                    <form action="{{ route('menu.destroy', $menu) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</x-app-layout>
