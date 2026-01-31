<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengeluaran::query();

        if ($request->from_date && $request->to_date) {
            $query->whereBetween('tanggal', [$request->from_date, $request->to_date]);
        }

        if ($request->month) {
            $query->whereMonth('tanggal', $request->month);
        }

        if ($request->year) {
            $query->whereYear('tanggal', $request->year);
        }

        $pengeluaran = $query->latest()->get();

        return view('back.pengeluaran.index', compact('pengeluaran'));
    }

    public function create()
    {
        return view('back.pengeluaran.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_pengeluaran' => 'required',
            'harga' => 'required|numeric|min:0',
            'tanggal' => 'required',
            'kategori_pengeluaran' => 'required'
        ]);

        $pengeluaran = Pengeluaran::create([
            'nama_pengeluaran' => $request->nama_pengeluaran,
            'harga' => $request->harga,
            'tanggal' => $request->tanggal,
            'kategori_pengeluaran' => $request->kategori_pengeluaran
        ]);

        return redirect()->route('pengeluaran.index')->with(['success' => 'Data Berhasil Disimpan']);
    }

    public function edit($id)
    {
        $pengeluaran = Pengeluaran::find($id);

        return view('back.pengeluaran.edit', compact('pengeluaran'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        $pengeluaran = Pengeluaran::findOrFail($id);
        $pengeluaran->update($data);

        return redirect()->route('pengeluaran.index')->with(['success' => 'Data Berhasil Diubah']);
    }

    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::find($id);

        $pengeluaran->delete();

        return redirect()->route('pengeluaran.index')->with(['success' => 'Data Berhasil Dihapus']);
    }

    public function exportPdf(Request $request)
    {
        $query = Pengeluaran::query();

        if ($request->from_date && $request->to_date) {
            $query->whereBetween('tanggal', [$request->from_date, $request->to_date]);
        }

        if ($request->month) {
            $query->whereMonth('tanggal', $request->month);
        }

        if ($request->year) {
            $query->whereYear('tanggal', $request->year);
        }

        $pengeluaran = $query->get();

        $pdf = Pdf::loadView('back.pengeluaran.export-pdf', compact('pengeluaran'));

        return $pdf->download('pengeluaran-villa.pdf');
    }
}
