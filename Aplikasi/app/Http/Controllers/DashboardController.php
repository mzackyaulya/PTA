<?php

namespace App\Http\Controllers;

use App\Models\Announcements;
use App\Models\Banner;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Announcements::query();

        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('body', 'like', '%' . $request->search . '%');
            });
        }

        $announcements = $query->latest()->paginate(6);

        $banners = Banner::latest()->get();

        // Banner hanya disembunyikan pada session login saat ini
        $hideBanner = session('hide_banner', false);

        return view('dashboard', compact('announcements', 'banners', 'hideBanner'));
    }
}
