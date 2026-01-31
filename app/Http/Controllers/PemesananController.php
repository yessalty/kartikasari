<?php

namespace App\Http\Controllers;

use App\Models\ExtraSewa;
use App\Models\Pemesanan;
use App\Models\Villa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PemesananController extends Controller
{
    public function index()
    {
        $pemesanans = Pemesanan::with([
            'villa.cover'
        ])
            ->where('id_user', Auth::id())
            ->latest()
            ->get();

        return view('front.pemesanan.index', compact('pemesanans'));
    }

    public function create(Villa $villa)
    {
        // $villa = Villa::findorFail($request->id_villa);
        $extras = ExtraSewa::all();

        $bookedDates = Pemesanan::where('id_villa', $villa->id_villa)
            ->where('status_pemesanan', 'dikonfirmasi')
            ->get(['tanggal_masuk', 'tanggal_keluar']);

        return view('front.pemesanan', compact('villa', 'extras', 'bookedDates'));
    }

    public function store(Request $request)
    {
        // dd($request->all());

        // 1. VALIDASI
        $request->validate([
            'id_villa' => 'required|exists:villa,id_villa',
            'jml_penginap' => 'required|integer|min:1',
            'jml_kendaraan' => 'required|string',
            'tanggal_masuk' => 'required|date',
            'tanggal_keluar' => 'required|date|after:tanggal_masuk',
            'jenis_pembayaran' => 'required|in:penuh,dp',
        ]);

        // 2. HITUNG JUMLAH MALAM
        $tanggalMasuk = Carbon::parse($request->tanggal_masuk);
        $tanggalKeluar = Carbon::parse($request->tanggal_keluar);
        $jumlahMalam = $tanggalMasuk->diffInDays($tanggalKeluar);

        // 3. CEK BENTROK JADWAL
        $bookedDates = Pemesanan::where('id_villa', $request->id_villa)
            ->whereIn('status_pemesanan', ['menunggu_pembayaran', 'dikonfirmasi', 'menunggu_konfirmasi'])
            ->where(function ($query) use ($request) {
                $query->whereBetween('tanggal_masuk', [$request->tanggal_masuk, $request->tanggal_keluar])
                    ->orWhereBetween('tanggal_keluar', [$request->tanggal_masuk, $request->tanggal_keluar])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('tanggal_masuk', '<=', $request->tanggal_masuk)
                            ->where('tanggal_keluar', '>=', $request->tanggal_keluar);
                    });
            })
            ->exists();

        if ($bookedDates) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Tanggal pemesanan bertabrakan dengan pemesanan lain.');
        }

        // 4. HITUNG HARGA VILLA
        $villa = Villa::findOrFail($request->id_villa);
        $totalVilla = $jumlahMalam * $villa->harga_villa;

        // 5. HITUNG EXTRA SEWA
        $totalExtra = 0;
        $pivotExtras = [];

        if ($request->filled('extras')) {
            foreach ($request->extras as $extraId => $extra) {
                if (!isset($extra['jumlah'])) continue;

                $dataExtra = ExtraSewa::find($extraId);
                if (!$dataExtra) continue;

                $totalExtra += $dataExtra->harga * $extra['jumlah'] * $jumlahMalam;

                $pivotExtras[$extraId] = [
                    'jumlah' => $extra['jumlah']
                ];
            }
        }


        // 6. TOTAL & DP
        $totalHarga = $totalVilla + $totalExtra;

        if ($request->jml_penginap > $villa->kapasitas_max) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jumlah penginap melebihi kapasitas maksimum villa.');
        }

        if ($request->jenis_pembayaran === 'penuh') {
            $jumlahDibayar = $totalHarga;
            $sisa = 0;
        } else {
            $jumlahDibayar = $totalHarga * 0.3;
            $sisa = $totalHarga - $jumlahDibayar;
        }

        // 7. SIMPAN PEMESANAN
        $pemesanan = Pemesanan::create([
            'id_villa' => $villa->id_villa,
            'id_user' => Auth::id(),
            'tanggal_masuk' => $request->tanggal_masuk,
            'tanggal_keluar' => $request->tanggal_keluar,
            'jml_penginap' => $request->jml_penginap,
            'jml_kendaraan' => $request->jml_kendaraan,
            'status_pemesanan' => 'menunggu_pembayaran',
            'total_harga' => $totalHarga,
            'sisa_pembayaran' => $sisa,
            'jumlah_dibayar' => $jumlahDibayar,
            'jenis_pembayaran' => $request->jenis_pembayaran,
        ]);

        if (!empty($pivotExtras)) {
            $pemesanan->extras()->sync($pivotExtras);
        }

        return redirect()
            ->route('pemesanan')
            ->with('success', 'Pemesanan berhasil dibuat. Silakan bayar DP untuk konfirmasi.');
    }

    public function batal(Pemesanan $pemesanan)
    {
        if ($pemesanan->id_user !== Auth::id()) {
            return redirect()->route('pemesanan')->with('error', 'Anda tidak memiliki izin untuk membatalkan pemesanan ini.');
        }

        $hariIni = Carbon::today();
        $tanggalMasuk = Carbon::parse($pemesanan->tanggal_masuk);

        if ($hariIni->gte($tanggalMasuk, false)) {
            return redirect()->route('pemesanan')
                ->with('error', 'Pemesanan tidak dapat dibatalkan karena sudah melewati batas waktu (H-1).');
        }

        if ($pemesanan->status_pemesanan === 'dp_dibayar') {
        }

        $pemesanan->update([
            'status_pemesanan' => 'dibatalkan'
        ]);

        return redirect()->route('pemesanan')->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
