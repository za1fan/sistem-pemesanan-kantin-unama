<x-app-layout>
    <div class="p-6">
        <h2 class="text-2xl font-bold mb-4">QR Code Meja</h2>

        <a href="#" onclick="window.print(); return false;"
            class="inline-flex items-center px-3 py-2 rounded bg-gray-700 text-white text-sm">
                Cetak Semua QR
        </a>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @for ($i = 1; $i <= 8; $i++)
                <div class="border p-4 text-center rounded shadow">
                    <p class="font-bold mb-2">Meja {{ $i }}</p>

                    <img src="{{ url('/qrcode/meja/' . $i) }}" alt="QR Meja {{ $i }}">

                    <p class="mt-2 text-sm">Scan untuk pesan</p>
                </div>
            @endfor
        </div>
    </div>
</x-app-layout>
