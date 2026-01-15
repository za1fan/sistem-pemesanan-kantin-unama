<x-app-layout>
    <div class="container">
        <h2>QR Code Meja</h2>

        @foreach ($mejas as $meja)
            <div style="margin-bottom:20px">
                <p>{{ $meja->kode_meja }}</p>
                {!! QrCode::size(150)->generate(url('/pesan?meja='.$meja->kode_meja)) !!}
            </div>
        @endforeach
    </div>
</x-app-layout>
