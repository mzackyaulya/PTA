<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SuratController extends Controller
{
    /**
     * Menampilkan daftar surat.
     * Siswa hanya melihat surat miliknya.
     * Waka/Admin melihat semua surat.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'siswa') {
            $surats = Surat::with(['pembuat', 'siswaTerlibat', 'waka'])
                ->where('user_id', $user->id)
                ->latest()
                ->paginate(10);
        } else {
            $surats = Surat::with(['pembuat', 'siswaTerlibat', 'waka'])
                ->latest()
                ->paginate(10);
        }

        return view('surat.index', compact('surats'));
    }

    /**
     * Menampilkan form tambah surat.
     */
    public function create()
    {
        $siswas = Siswa::with('user')
            ->where('status_siswa', 'aktif')
            ->orderBy('nis', 'asc')
            ->get();

        return view('surat.create', compact('siswas'));
    }

    /**
     * Menyimpan surat yang diajukan siswa.
     */
    public function store(Request $request)
    {
        $rules = [
            'jenis_surat' => 'required|in:dispensasi,permohonan_lomba,permohonan_organisasi,izin_kegiatan,keterangan,lainnya',
            'judul' => 'required|string|max:255',
            'nama_kegiatan' => 'nullable|string|max:255',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'tempat_kegiatan' => 'nullable|string|max:255',
            'nama_pelatih' => 'nullable|string|max:255',
            'nama_organisasi' => 'nullable|string|max:255',
            'keperluan' => 'required|string',
            'siswa_ids' => 'nullable|array',
            'siswa_ids.*' => 'exists:siswas,id',
            'pengaju_user_id' => 'required|exists:users,id', // Validasi input baru
        ];

        $request->validate($rules);

        $surat = Surat::create([
            'user_id' => $request->pengaju_user_id, // Menggunakan ID siswa pemohon yang dikirim form
            'jenis_surat' => $request->jenis_surat,
            'judul' => $request->judul,
            'nama_kegiatan' => $request->nama_kegiatan,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'tempat_kegiatan' => $request->tempat_kegiatan,
            'nama_pelatih' => $request->nama_pelatih,
            'nama_organisasi' => $request->nama_organisasi,
            'keperluan' => $request->keperluan,
            'status' => 'pending',
        ]);

        if ($request->filled('siswa_ids')) {
            $surat->siswaTerlibat()->sync($request->siswa_ids);
        }

        return redirect()
            ->route('surat.index')
            ->with('success', 'Surat berhasil diajukan dan menunggu persetujuan Waka.');
    }

    /**
     * Menampilkan detail surat.
     */
    public function show(Surat $surat)
    {
        $user = auth()->user();

        if ($user->role === 'siswa' && $surat->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke surat ini.');
        }

        $surat->load(['pembuat', 'siswaTerlibat.user', 'waka']);

        return view('surat.show', compact('surat'));
    }

    /**
     * Mengubah status surat menjadi review.
     * Digunakan oleh Waka/Admin.
     */
    public function review(Surat $surat)
    {
        $this->cekAksesWaka();

        if ($surat->status !== 'pending') {
            return back()->with('error', 'Surat ini tidak bisa direview.');
        }

        $surat->update([
            'status' => 'review',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Surat berhasil masuk tahap review.');
    }

    /**
     * Waka menerima surat.
     * Status menjadi selesai dan siswa bisa download.
     */
    public function terima(Request $request, Surat $surat)
    {
        $this->cekAksesWaka();

        if (!in_array($surat->status, ['pending', 'review'])) {
            return back()->with('error', 'Surat ini tidak bisa diterima.');
        }

        $kodeSurat = $this->generateKodeSurat($surat);

        $surat->update([
            'kode_surat' => $kodeSurat,
            'status' => 'selesai',
            'catatan_waka' => $request->catatan_waka,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Surat berhasil diterima. Siswa sudah bisa mengunduh surat.');
    }

    /**
     * Waka menolak surat.
     */
    public function tolak(Request $request, Surat $surat)
    {
        $this->cekAksesWaka();

        $request->validate([
            'catatan_waka' => 'required|string',
        ], [
            'catatan_waka.required' => 'Alasan penolakan wajib diisi.',
        ]);

        if (!in_array($surat->status, ['pending', 'review'])) {
            return back()->with('error', 'Surat ini tidak bisa ditolak.');
        }

        $surat->update([
            'status' => 'ditolak',
            'catatan_waka' => $request->catatan_waka,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Surat berhasil ditolak.');
    }

    /**
     * Download surat dalam bentuk PDF.
     * Hanya bisa jika status selesai.
     */
    public function download(Surat $surat)
    {
        $user = auth()->user();

        if ($user->role === 'siswa' && $surat->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke surat ini.');
        }

        if ($surat->status !== 'selesai') {
            return back()->with('error', 'Surat belum selesai dan belum dapat diunduh.');
        }

        $surat->load(['pembuat', 'siswaTerlibat.user', 'waka']);

        $pdf = Pdf::loadView('surat.pdf', compact('surat'))
            ->setPaper('A4', 'portrait');

        $namaFile = 'surat-' . str_replace('/', '-', $surat->kode_surat) . '.pdf';

        return $pdf->download($namaFile);
    }

    /**
     * Edit surat.
     * Untuk awal, sebaiknya hanya surat pending yang boleh diedit.
     */
    public function edit(Surat $surat)
    {
        $user = auth()->user();

        if ($user->role === 'siswa' && $surat->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke surat ini.');
        }

        if ($surat->status !== 'pending') {
            return redirect()
                ->route('surat.show', $surat->id)
                ->with('error', 'Surat yang sudah direview tidak bisa diedit.');
        }

        $siswas = Siswa::with('user')
            ->where('status_siswa', 'aktif')
            ->orderBy('nis', 'asc')
            ->get();

        $surat->load('siswaTerlibat');

        return view('surat.edit', compact('surat', 'siswas'));
    }

    /**
     * Update surat.
     */
    public function update(Request $request, Surat $surat)
    {
        $user = auth()->user();

        if ($user->role === 'siswa' && $surat->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke surat ini.');
        }

        if ($surat->status !== 'pending') {
            return redirect()
                ->route('surat.show', $surat->id)
                ->with('error', 'Surat yang sudah direview tidak bisa diubah.');
        }

        $request->validate([
            'jenis_surat' => 'required|in:dispensasi,permohonan_lomba,permohonan_organisasi,izin_kegiatan,keterangan,lainnya',
            'judul' => 'required|string|max:255',
            'nama_kegiatan' => 'nullable|string|max:255',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'tempat_kegiatan' => 'nullable|string|max:255',
            'nama_pelatih' => 'nullable|string|max:255',
            'nama_organisasi' => 'nullable|string|max:255',
            'keperluan' => 'required|string',
            'siswa_ids' => 'nullable|array',
            'siswa_ids.*' => 'exists:siswas,id',
        ]);

        $surat->update([
            'jenis_surat' => $request->jenis_surat,
            'judul' => $request->judul,
            'nama_kegiatan' => $request->nama_kegiatan,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'tempat_kegiatan' => $request->tempat_kegiatan,
            'nama_pelatih' => $request->nama_pelatih,
            'nama_organisasi' => $request->nama_organisasi,
            'keperluan' => $request->keperluan,
        ]);

        $surat->siswaTerlibat()->sync($request->siswa_ids ?? []);

        return redirect()
            ->route('surat.show', $surat->id)
            ->with('success', 'Surat berhasil diperbarui.');
    }

    /**
     * Hapus surat.
     * Opsional, hanya admin atau pemilik surat yang statusnya pending.
     */
    public function destroy(Surat $surat)
    {
        $user = auth()->user();

        if ($user->role === 'siswa' && $surat->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke surat ini.');
        }

        if ($user->role === 'siswa' && $surat->status !== 'pending') {
            return back()->with('error', 'Surat yang sudah direview tidak bisa dihapus.');
        }

        $surat->delete();

        return redirect()
            ->route('surat.index')
            ->with('success', 'Surat berhasil dihapus.');
    }

    /**
     * Cek akses Waka/Admin.
     */
    private function cekAksesWaka()
    {
        if (auth()->user()->role !== 'waka') {
            abort(403, 'Hanya Waka yang dapat melakukan aksi ini.');
        }
    }

    /**
     * Generate kode surat otomatis.
     */
    private function generateKodeSurat(Surat $surat)
    {
        $tahun = date('Y');

        $jumlahSuratSelesai = Surat::whereYear('created_at', $tahun)
            ->whereNotNull('kode_surat')
            ->count() + 1;

        $nomorUrut = str_pad($jumlahSuratSelesai, 3, '0', STR_PAD_LEFT);

        return $nomorUrut . '/SMA-MUH2/AKD/' . $tahun;
    }
}