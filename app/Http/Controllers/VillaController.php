<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use App\Models\Kategori_Villa;
use App\Models\Villa;
use App\Models\VillaFoto;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class VillaController extends Controller
{
    public function index()
    {
        $villa = Villa::all();

        return view('back.villa.index', compact('villa'));
    }

    public function show($id)
    {
        $villa = Villa::with(
            'kategori',
            'fotos',
            'fasilitas',
            'cover')->findOrFail($id);
        return view('back.villa.show', compact('villa'));
    }

    public function create()
    {
        $kategori = Kategori_Villa::all();
        $fasilitas = Fasilitas::all();
        return view('back.villa.create', compact('kategori', 'fasilitas'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_villa' => 'required|string',
            'harga_villa' => 'required|numeric|min:1',
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string',
            'jumlah_kamar' => 'required|integer|min:1',
            'kamar_mandi' => 'required|integer|min:1',
            'id_kategori' => 'required|exists:kategori_villa,id_kategori',
            'kapasitas_min' => 'required|integer|min:1',
            'kapasitas_max' => 'required|integer|gte:kapasitas_min',
            
            'fasilitas' => 'required|array',
            'fasilitas.*' => 'exists:fasilitas,id_fasilitas',
            
            'foto' => 'required|array|max:10',
            'foto.*' => 'image|mimes:jpg,jpeg,png|max:5120', // Ubah 5120 ke ukuran yang diinginkan (dalam KB)
        ]);

        $villa = Villa::create([
            'nama_villa' => $request->nama_villa,
            'harga_villa' => $request->harga_villa,
            'deskripsi' => $request->deskripsi,
            'lokasi' => $request->lokasi,
            'jumlah_kamar' => $request->jumlah_kamar,
            'kamar_mandi' => $request->kamar_mandi,
            'kapasitas_min' => $request->kapasitas_min,
            'kapasitas_max' => $request->kapasitas_max,
            
            'id_kategori' => $request->id_kategori
        ]);

        if ($request->filled('fasilitas')) {
            $villa->fasilitas()->sync($request->fasilitas);
        }

        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $index => $file) {
                $path = $file->store('villa', 'public');

                VillaFoto::create([
                    'id_villa' => $villa->id_villa,
                    'foto' => $path,
                    'is_cover' => $index === 0
                ]);
            }
        }

        return redirect()->route('villa.index')->with(['success' => 'Data Berhasil Disimpan']);
    }

    public function edit($id)
    {
        $villa = Villa::with('fotos')->findOrFail($id);
        $kategori = Kategori_Villa::all();
        $fasilitas = Fasilitas::all();

        return view('back.villa.edit', compact('villa', 'kategori', 'fasilitas'));
    }

    public function update(Request $request, $id)
    {
        $villa = Villa::findOrFail($id);

        $request->validate([
            'nama_villa' => 'required|string',
            'harga_villa' => 'required|numeric|min:1',
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string',
            'jumlah_kamar' => 'required|integer|min:1',
            'kamar_mandi' => 'required|integer|min:1',
            'fasilitas' => 'required|array',
            'id_kategori' => 'required|exists:kategori_villa,id_kategori',
            'kapasitas_min' => 'required|integer|min:1',
            'kapasitas_max' => 'required|integer|gte:kapasitas_min',
        ]);

        $villa->update($request->only([
            'nama_villa',
            'harga_villa',
            'deskripsi',
            'lokasi',
            'jumlah_kamar',
            'kamar_mandi',
            'id_kategori',
            'kapasitas_min',
            'kapasitas_max',
        ]));

        if ($request->hasFile('foto')) {
            $request->validate([
                'foto' => 'array|max:10',
                'foto.*' => 'image|mimes:jpg,jpeg,png|max:5120',
            ]);

            foreach ($request->file('foto') as $file) {
                $path = $file->store('villa', 'public');

                VillaFoto::create([
                    'id_villa' => $villa->id_villa,
                    'foto' => $path,
                    'is_cover' => false
                ]);
            }
        }

        if ($request->filled('cover_id')) {
            VillaFoto::where('id_villa', $villa->id_villa)
                ->update(['is_cover' => false]);

            VillaFoto::where('id', $request->cover_id)
                ->update(['is_cover' => true]);
        }

        return redirect()->route('villa.index')->with(['success' => 'Data Berhasil Diubah']);
    }

    public function destroy($villa)
    {
        $villa = Villa::find($villa);

        $villa->delete();

        return redirect()->route('villa.index')->with(['success' => 'Data Berhasil Dihapus']);
    }

    public function deleteFoto($id)
    {
        $foto = VillaFoto::findOrFail($id);

        if (Storage::disk('public')->exists($foto->foto)) {
            Storage::disk('public')->delete($foto->foto);
        }

        $foto->delete();

        if ($foto->is_cover) {
            $nextFoto = VillaFoto::where('id_villa', $foto->id_villa)->first();
            if ($nextFoto) {
                $nextFoto->update(['is_cover' => true]);
            }
        }


        return redirect()->route('villa.edit', $foto->id_villa)
            ->with('success', 'Foto berhasil dihapus');
    }
}
