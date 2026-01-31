<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Villa;

class DashboardController extends Controller
{
    public function index(){
        $today = Carbon::today();

        return view('back.dashboard', [
            'totalVilla' => Villa::count(),
            'bookingToday' => Pemesanan::whereDate('tanggal_masuk', $today)->count(),
            'bookingBulanIni' => Pemesanan::whereMonth('tanggal_masuk', now()->month)->count(),
            'pendapatanBulanIni' => Pemesanan::whereMonth('tanggal_masuk', now()->month)
                ->where('status_pemesanan', 'selesai')
                ->sum('total_harga'),

            'bookingTodayList' => Pemesanan::with('villa', 'user')
                ->whereDate('tanggal_masuk', $today)
                ->latest()
                ->get(),

        ]);
    }
}
