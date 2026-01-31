<?php

namespace App\Http\Controllers;

use App\Models\Kategori_Villa;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;

class KategoriVillaController extends Controller
{
    public function index(){
        $kategori = Kategori_Villa::all();
        return view('back.kategori.index', compact('kategori'));
    }

    public function create(){
        return view('back.kategori.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'nama' => 'required'
        ]);

        $kategori = Kategori_Villa::create([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama)
        ]);

        return redirect()->route('kategori.index')->with(['success' => 'Data Berhasil Disimpan']);
    }

    public function edit($kategori){
        $kategori = Kategori_Villa::find($kategori);

        return view('back.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $kategori){
        $data = $request->all();
        $data['slug'] = Str::slug($request->nama);

        $kategori = Kategori_Villa::findOrFail($kategori);
        $kategori->update($data);

        return redirect()->route('kategori.index')->with(['success' => 'Data Berhasil Diubah']);
    }

    public function destroy($id){
        $kategori = Kategori_Villa::find($id);

        $kategori->delete();

        return redirect()->route('kategori.index')->with(['success' => 'Data Berhasil Dihapus']);
    }
}
