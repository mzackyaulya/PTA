<?php

namespace App\Http\Controllers;

use App\Models\Announcements;
use App\Models\Banner;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $banners = Banner::where('is_active',1)->orderBy('sort_order')->get();
        $announcements = Announcements::whereNotNull('published_at')
            ->orderBy('published_at','desc')
            ->paginate(9);
        return view('dashboard', compact('banners','announcements'));
    }
}
