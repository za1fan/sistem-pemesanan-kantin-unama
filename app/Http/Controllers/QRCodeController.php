<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class QRCodeController extends Controller
{
    // Existing: generate QR dari query ?meja=1
    // Dipakai kalau kamu akses: /qrcode?meja=1
    public function generate(Request $request)
    {
        $meja = $request->query('meja', '1'); // default meja 1 kalau tidak diisi

        $result = Builder::create()
            ->writer(new PngWriter())
            ->data(rtrim(config('app.url'), '/') . '/pesan?meja=' . $meja)
            ->size(300)
            ->margin(10)
            ->build();

        return response($result->getString())
            ->header('Content-Type', $result->getMimeType());
    }

    // Baru: generate QR dari path parameter /qrcode/meja/{meja}
    // Dipakai oleh halaman penjual: <img src="{{ url('/qrcode/meja/' . $i) }}">
    public function meja($meja)
    {
        $result = Builder::create()
            ->writer(new PngWriter())
            ->data(url('/pesan?meja=' . $meja))
            ->size(300)
            ->margin(10)
            ->build();

        return response($result->getString())
            ->header('Content-Type', $result->getMimeType());
    }
}
