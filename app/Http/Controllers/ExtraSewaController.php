<?php

namespace App\Http\Controllers;

use App\Models\ExtraSewa;
use Illuminate\Http\Request;

class ExtraSewaController extends Controller
{
    public function index(){
        $extra = ExtraSewa::all();

        return view('back.extrasewa.index', compact('extra'));
    }

    public function create(){
        return view('back.extrasewa.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'nama_extra' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required|numeric|min:0',
            
        ]);

        $extra = ExtraSewa::create([
            'nama_extra' => $request->nama_extra,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
        ]);

        return redirect()->route('extra.index')->with(['success' => 'Data Berhasil Disimpan']);
    }

    public function edit($extra){
        $extra = ExtraSewa::findOrFail($extra);

        return view('back.extrasewa.edit', compact('extra'));
    }

    public function update(Request $request, $extra){
        $data = $request->all();
        
        $extra = ExtraSewa::findOrFail($extra);
        $extra->update($data);

        return redirect()->route('extra.index')->with(['success' => 'Data Berhasil Diubah']);
    }

    public function destroy($extra){
        $extra = ExtraSewa::find($extra);

        $extra->delete();

        return redirect()->route('extra.index')->with(['success' => 'Data Berhasil Dihapus']);
    }
}
