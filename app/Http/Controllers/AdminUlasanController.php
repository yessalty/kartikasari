<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use Illuminate\Http\Request;

class AdminUlasanController extends Controller
{
    public function index()
    {
        $ulasans = Ulasan::with(['villa', 'user'])
            ->latest()
            ->get();

        return view('back.ulasan.index', compact('ulasans'));
    }

    public function toogleVisibility(Ulasan $ulasan)
    {
        $ulasan->update([
            'status' => $ulasan->status === 'approved'
            ? 'pending'
            : 'approved',
        ]);

        return redirect()->back()->with('success', 'Status ulasan berhasil diubah.');
    }
}
