<?php

namespace App\Http\Controllers;

use App\Models\Announcements;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AnnouncementsController extends Controller
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

        return view('dashboard', compact('announcements', 'banners'));
    }

    public function create()
    {
        return view('announcements.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'body'         => 'nullable|string',
            'file'         => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf,xls,xlsx,csv|max:5120',
            'published_at' => 'required|date',
        ]);

        $path = null;

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('announcements', 'public');
        }

        Announcements::create([
            'title'        => $data['title'],
            'body'         => $data['body'] ?? null,
            'image_path'   => $path,
            'published_at' => $data['published_at'],
        ]);

        return redirect()->route('dashboard')->with('success', 'Pengumuman berhasil ditambahkan');
    }

    public function preview($id)
    {
        $announcement = Announcements::findOrFail($id);

        if (!$announcement->image_path || !Storage::disk('public')->exists($announcement->image_path)) {
            abort(404);
        }

        $path = Storage::disk('public')->path($announcement->image_path);
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        $mimeType = match ($extension) {
            'pdf' => 'application/pdf',
            'jpg', 'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'webp' => 'image/webp',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'csv' => 'text/csv',
            default => 'application/octet-stream',
        };

        return response()->file($path, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
        ]);
    }

    public function pdfViewer($id)
    {
        $announcement = Announcements::findOrFail($id);

        if (!$announcement->image_path || !Storage::disk('public')->exists($announcement->image_path)) {
            abort(404);
        }

        $path = Storage::disk('public')->path($announcement->image_path);
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        if ($extension !== 'pdf') {
            abort(404);
        }

        $pdfBase64 = base64_encode(file_get_contents($path));

        return view('announcements.pdf-viewer', compact('pdfBase64', 'announcement'));
    }

    public function excelViewer($id)
    {
        $announcement = Announcements::findOrFail($id);

        if (!$announcement->image_path || !Storage::disk('public')->exists($announcement->image_path)) {
            abort(404);
        }

        $path = Storage::disk('public')->path($announcement->image_path);
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        if (!in_array($extension, ['xls', 'xlsx', 'csv'])) {
            abort(404);
        }

        $spreadsheet = IOFactory::load($path);
        $sheet = $spreadsheet->getActiveSheet();

        $rows = $sheet->toArray(null, true, true, true);

        return view('announcements.excel-viewer', compact('rows', 'announcement'));
    }

    public function show(Announcements $announcements)
    {
        //
    }

    public function edit(Announcements $announcements)
    {
        //
    }

    public function update(Request $request, Announcements $announcements)
    {
        //
    }

    public function destroy(Announcements $announcements)
    {
        //
    }
}