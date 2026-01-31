<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use Illuminate\Http\Request;

class FasilitasVillaController extends Controller
{
    public function index(){
        $fasilitas = Fasilitas::all();

        return view('back.fasilitas.index', compact('fasilitas'));
    }
}
