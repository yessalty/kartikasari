<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\Ulasan;
use App\Models\Villa;
use Illuminate\Http\Request;

class VillaController extends Controller
{
    public function index(Villa $villa)
    {
        $ulasans = Ulasan::with('user')
            ->where('status', 'approved')
            ->latest()
            ->get();

        $villa->load([
            'fasilitas',
            'fotos'
        ]);

        $cover = $villa->fotos->firstWhere('is_cover', 1);

        $others = $villa->fotos->where('is_cover', 0);

        $photos = collect();

        if($cover){
            $photos->push($cover);
        }

        $photos = $photos->merge($others);

        $pemesanan = Pemesanan::where('id_villa', $villa->id_villa)
            ->whereIn('status_pemesanan', ['dikonfirmasi', 'menunggu_konfirmasi', 'menunggu_pembayaran'])
            ->get();

        $events = $pemesanan->map(function ($item) {
            return [
                'title' => 'Terpesan',
                'start' => $item->tanggal_masuk,
                'end' => date('Y-m-d', strtotime($item->tanggal_keluar . ' +1 day')),
                'color' => '#ff0000',
            ];
        });

        return view('front.detail', compact('ulasans', 'villa', 'pemesanan', 'events', 'photos'));
    }

    public function list()
    {
        $villas = Villa::with('cover')->get();
        return view('front.layouts.villa', compact('villas'));
    }
}
