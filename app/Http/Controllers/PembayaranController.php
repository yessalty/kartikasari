<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Pemesanan;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index()
    {
        //
    }

    public function create(Pemesanan $pemesanan)
    {
        return view('front.pembayaran', compact('pemesanan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pemesanan' => 'required|exists:pemesanan,id_pemesanan',
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $path = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');

        $pemesanan = Pemesanan::findOrFail($request->id_pemesanan);

        Pembayaran::create([
            'id_pemesanan' => $pemesanan->id_pemesanan,
            'jenis_pembayaran' => $pemesanan->jenis_pembayaran,
            'jumlah_bayar' => $pemesanan->jumlah_dibayar,
            'bukti_pembayaran' => $path,
            'status_pembayaran' => 'menunggu',
        ]);

        $pemesanan->update([
            'status_pemesanan' => 'menunggu_konfirmasi',
        ]);

        return redirect()->route('pemesanan')->with('success', 'Pembayaran berhasil dikirim, menunggu konfirmasi admin.');
    }
}
