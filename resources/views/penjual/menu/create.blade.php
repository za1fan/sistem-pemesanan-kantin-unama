<x-app-layout>
    <div class="container">
        <h2>Tambah Menu</h2>

        <form action="{{ route('menu.store') }}" method="POST">
            @csrf
            <input type="text" name="nama_menu" placeholder="Nama Menu"><br><br>
            <input type="number" name="harga" placeholder="Harga"><br><br>
            <textarea name="deskripsi" placeholder="Deskripsi"></textarea><br><br>
            <button type="submit">Simpan</button>
        </form>
    </div>
</x-app-layout>
