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
        $announcements = Announcements::where('is_published',1)->latest()->paginate(9);
        return view('dashboard', compact('banners','announcements'));
    }
}
