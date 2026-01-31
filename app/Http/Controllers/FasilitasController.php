<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fasilitas;
use PDO;

class FasilitasController extends Controller
{
    public function index(){
        $fasilitas = Fasilitas::all();

        return view('back.fasilitas.index', compact('fasilitas'));
    }

    public function create(){
        return view('back.fasilitas.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'nama_fasilitas' => 'required'
        ]);

        $fasilitas = Fasilitas::create([
            'nama_fasilitas' => $request->nama_fasilitas
        ]);

        return redirect()->route('fasilitas.index')->with(['success' => 'Data Berhasil Disimpan']);
    }

    public function edit($id){
        $fasilitas = Fasilitas::find($id);

        return view('back.fasilitas.edit', compact('fasilitas'));
    }

    public function update(Request $request, $id){
        $data = $request->all();
        
        $fasilitas = Fasilitas::findOrFail($id);
        $fasilitas->update($data);

        return redirect()->route('fasilitas.index')->with(['success' => 'Data Berhasil Diubah']);
    }

    public function destroy($id){
        $fasilitas = Fasilitas::find($id);

        $fasilitas->delete();

        return redirect()->route('fasilitas.index')->with(['success' => 'Data Berhasil Dihapus']);
    }
}
