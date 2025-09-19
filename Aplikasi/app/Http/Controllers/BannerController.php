<?php

namespace App\Http\Controllers;

use Storage;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('banner.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Batasi maksimal 3 banner
        if (Banner::count() >= 3) {
            return redirect()->route('dashboard')->with('error','Maksimal 3 banner saja.');
        }

        $data = $request->validate([
            'title' => ['nullable','string','max:100'],
            'image' => ['required','image','mimes:jpg,jpeg,png,webp','max:3072'],
        ]);

        $path = $request->file('image')->store('banners','public');

        Banner::create([
            'title' => $data['title'] ?? null,
            'image_path' => $path,
        ]);

        return redirect()->route('dashboard')->with('success','Banner berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        return view('banner.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        $data = $request->validate([
            'title' => ['nullable','string','max:100'],
            'image' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:3072'],
        ]);

        // Kalau upload gambar baru
        if ($request->hasFile('image')) {
            // hapus file lama kalau ada
            if ($banner->image_path && \Storage::disk('public')->exists($banner->image_path)) {
                Storage::disk('public')->delete($banner->image_path);
            }
            $data['image_path'] = $request->file('image')->store('banners','public');
        }

        $banner->update([
            'title' => $data['title'] ?? $banner->title,
            'image_path' => $data['image_path'] ?? $banner->image_path,
        ]);

        return redirect()->route('dashboard')->with('success','Banner berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        //
    }
}
