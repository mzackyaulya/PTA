<?php

namespace App\Http\Controllers;

use App\Models\Announcements;
use App\Models\Banner;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
         // Query pengumuman
        $query = Announcements::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%'.$request->search.'%')
                  ->orWhere('body', 'like', '%'.$request->search.'%');
        }

        $announcements = $query->latest()->paginate(6);

        // Tetap load banners
        $banners = Banner::latest()->get();

        return view('dashboard', compact('announcements', 'banners'));
    }
}
