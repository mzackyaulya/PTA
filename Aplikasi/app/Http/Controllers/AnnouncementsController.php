<?php

namespace App\Http\Controllers;

use App\Models\Announcements;
use Illuminate\Http\Request;

class AnnouncementsController extends Controller
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
        return view('announcements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'body'         => 'nullable|string',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'published_at' => 'required|date',
        ]);

        // Simpan gambar jika ada
        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('announcements', 'public');
        }

        // Simpan ke database
        Announcements::create([
            'title'        => $data['title'],
            'body'         => $data['body'] ?? null,
            'image_path'   => $path,
            'published_at' => $data['published_at'],
        ]);

        return redirect()->route('dashboard')->with('success', 'Pengumuman berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Announcements $announcements)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Announcements $announcements)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Announcements $announcements)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcements $announcements)
    {
        //
    }
}
