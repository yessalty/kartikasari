<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;

class KonfirmasiPemesananController extends Controller
{
    public function index()
    {
        $pemesanans = Pemesanan::with(['user', 'villa', 'pembayaran'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('back.konfirmasi.index', compact('pemesanans'));
    }

    public function show(Pemesanan $pemesanan)
    {
        $pemesanan->load(['user', 'villa', 'pembayaran']);

        return view('back.konfirmasi.show', compact('pemesanan'));
    }

    public function konfirmasi(Pemesanan $pemesanan)
    {
        $pemesanan->update([
            'status_pemesanan' => 'dikonfirmasi',
        ]);

        return redirect()->route('back.konfirmasi.index')->with('success', 'Pemesanan berhasil dikonfirmasi.');
    }

    public function tolak(Pemesanan $pemesanan)
    {
        $pemesanan->update([
            'status_pemesanan' => 'ditolak',
        ]);

        return redirect()->route('back.konfirmasi.index')->with('success', 'Pemesanan berhasil ditolak.');
    }
}
