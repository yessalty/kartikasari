<?php

namespace App\Http\Controllers;

use App\Models\Kategori_Villa;
use App\Models\Slide;
use App\Models\Villa;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index(){
        $slide = Slide::where('status', 1)->get();
        $villa = Villa::with('cover')->inRandomOrder()->limit(3)->get();

        return view('welcome', compact('slide', 'villa'));
    }
}
