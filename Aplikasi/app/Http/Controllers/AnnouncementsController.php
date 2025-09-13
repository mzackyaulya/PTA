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
        $data = $request->validate([
            'title'=>['required','string','max:150'],
            'body'=>['required','string'],
            'category'=>['nullable','string','max:50'],
            'starts_at'=>['nullable','date'],
            'ends_at'=>['nullable','date','after_or_equal:starts_at'],
            'is_published'=>['nullable','boolean'],
        ]);

        Announcements::create([
            ...$data,
            'is_published'=>$request->boolean('is_published', true),
            'created_by'=>optional(auth()->user())->id,
        ]);
        return redirect()->route('dashboard')->with('success','Pengumuman Berhasil ditambahkan');
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
