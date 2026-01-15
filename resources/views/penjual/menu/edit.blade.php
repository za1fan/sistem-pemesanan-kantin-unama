<x-app-layout>
    <div class="container">
        <h2>Edit Menu</h2>

        <form action="{{ route('menu.update', $menu) }}" method="POST">
            @csrf
            @method('PUT')

            <input type="text" name="nama_menu" value="{{ $menu->nama_menu }}"><br><br>
            <input type="number" name="harga" value="{{ $menu->harga }}"><br><br>
            <textarea name="deskripsi">{{ $menu->deskripsi }}</textarea><br><br>

            <button type="submit">Update</button>
        </form>
    </div>
</x-app-layout>
