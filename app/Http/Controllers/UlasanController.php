<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{
    public function index()
    {
        //
    }

    public function create(Pemesanan $pemesanan)
    {
        if ($pemesanan->id_user !== Auth::id()) {
            abort(403);
        }

        if ($pemesanan->status_pemesanan !== 'selesai') {
            abort(403);
        }

        if ($pemesanan->ulasan) {
            return redirect()->back()->with('error', 'Anda sudah memberikan ulasan untuk pemesanan ini.');
        }
        return view('front.ulasan.create', compact('pemesanan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pemesanan' => 'required|exists:pemesanan,id_pemesanan',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string',
        ]);

        $pemesanan = Pemesanan::findOrFail($request->id_pemesanan);

        Ulasan::create([
            'id_pemesanan' => $pemesanan->id_pemesanan,
            'id_villa' => $pemesanan->id_villa,
            'id_user' => Auth::id(),
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return redirect()->route('pemesanan')
            ->with('success', 'Berhasil memberikan ulasan.');
    }
}
