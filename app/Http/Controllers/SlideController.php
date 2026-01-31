<?php

namespace App\Http\Controllers;

use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SlideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $slide = Slide::all();

        return view('back.slide.index', compact('slide'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('back.slide.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'gambar_slide' => 'nullable|mimes:jpg,jpeg,png|max:5120',
            'status' => 'required|boolean',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar_slide')) {
            $data['gambar_slide'] = $request->file('gambar_slide')->store('slides', 'public');
        }

        Slide::create($data);

        return redirect()->route('slide.index')->with(['success' => 'Slide berhasil ditambahkan.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $slide = Slide::findOrFail($id);
        return view('back.slide.edit', compact('slide'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $slide = Slide::findOrFail($id);

        $request->validate([
            'gambar_slide' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'status' => 'required|boolean',
        ]);

        $data = [
            'status' => $request->status
        ];

        if ($request->hasFile('gambar_slide')) {

            if ($slide->gambar_slide && Storage::disk('public')->exists($slide->gambar_slide)) {
                Storage::disk('public')->delete($slide->gambar_slide);
            }

            $data['gambar_slide'] = $request->file('gambar_slide')
                ->store('slides', 'public');
        }

        $slide->update($data);

        return redirect()
            ->route('slide.index')
            ->with('success', 'Slide berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $slide = Slide::findOrFail($id);
        $slide->delete();

        return redirect()->route('slide.index')->with(['success' => 'Slide berhasil dihapus.']);
    }
}
