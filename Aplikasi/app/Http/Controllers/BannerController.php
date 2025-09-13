<?php

namespace App\Http\Controllers;

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
        $data = $request->validate([
            'title' => ['nullable','string','max:100'],
            'image' => ['required','image','mimes:jpg,jpeg,png,webp','max:3072'],
            'sort_order' => ['nullable','integer','min:0'],
            'is_active' => ['nullable','boolean'],
        ]);
        $path = $request->file('image')->store('banners','public');

        Banner::create([
            'title'=>$data['title']??null,
            'image_path'=>$path,
            'sort_order'=>$data['sort_order']??0,
            'is_active'=>$request->boolean('is_active', true),
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        //
    }
}
