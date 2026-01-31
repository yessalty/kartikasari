<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Villa;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $villas = Villa::with('cover')->get();
        return view('front.dashboard', compact('villas'));
    }
}
