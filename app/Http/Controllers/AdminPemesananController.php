<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;

class AdminPemesananController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;

        $pemesanan = Pemesanan::with(['user', 'villa'])
            ->when($status, function ($query) use ($status) {
                return $query->where('status_pemesanan', $status);
            })
            ->latest()
            ->get();

        return view('back.pemesanan.index', compact('pemesanan', 'status'));
    }

    public function show(Pemesanan $pemesanan)
    {
        $pemesanan->load(['user', 'villa', 'pembayaran', 'extras']);

        return view('back.pemesanan.show', compact('pemesanan'));
    }

    public function konfirmasi(Pemesanan $pemesanan)
    {
        $pemesanan->update([
            'status_pemesanan' => 'dikonfirmasi',
        ]);

        return redirect()->route('admin.pemesanan.index')->with('success', 'Pemesanan berhasil dikonfirmasi');
    }

    public function tolak(Request $request, Pemesanan $pemesanan)
    {
        $request->validate([
            'alasan_ditolak' => 'required|string|max:1000',
        ]);

        $pemesanan->update([
            'status_pemesanan' => 'ditolak',
            'alasan_ditolak' => $request->alasan_ditolak,
        ]);

        return redirect()->route('admin.pemesanan.index')->with('success', 'Pemesanan ditolak dengan alasan yang diberikan.');
    }
}
