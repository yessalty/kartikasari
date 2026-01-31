<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminPemasukanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pemesanan::with('villa', 'user')
            ->where('status_pemesanan', 'selesai');

        if($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereBetween('created_at', [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        $pemesanans = $query->get();

        $totalPemasukan = $pemesanans->sum('total_harga');
        return view('back.pemasukan.index', compact('pemesanans', 'totalPemasukan'));
    }

    public function exportPdf(Request $request)
    {
        $query = Pemesanan::with('villa', 'user')
            ->where('status_pemesanan', 'selesai');

        if($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereBetween('created_at', [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        $pemesanans = $query->get();

        $totalPemasukan = $pemesanans->sum('total_harga');

        $pdf = Pdf::loadView('back.pemasukan.pdf', compact('pemesanans', 'totalPemasukan', 'request'));

        return $pdf->download('pemasukan.pdf');
    }
}
