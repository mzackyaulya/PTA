<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SuratController extends Controller
{
    
    public function index(Request $request)
    {
        $user = auth()->user();
        
        // 1. Ambil semua daftar tahun ajaran untuk filter dropdown
        $daftarTahunAjaran = TahunAjaran::orderBy('tahun', 'desc')->orderBy('semester', 'desc')->get();

        // 2. Cari tahun ajaran yang sedang aktif sebagai default awal
        $tahunAjaranAktif = TahunAjaran::where('aktif', true)->first();

        $query = Surat::with(['pembuat', 'siswaTerlibat', 'waka']);

        // 3. LOGIKA FILTER FIX: Fokus murni pada ID Tahun Ajaran (Tanpa tanggal/bulan)
        if ($request->filled('tahun_ajaran_filter')) {
            // Jika dropdown filter dipilih, cari yang ID-nya sama persis
            $query->where('tahun_ajaran_id', $request->tahun_ajaran_filter);
        } else {
            // Jika pertama kali dibuka, tampilkan tahun ajaran yang aktif saat ini saja
            if ($tahunAjaranAktif) {
                $query->where('tahun_ajaran_id', $tahunAjaranAktif->id);
            } else {
                $query->whereNull('id');
            }
        }

        // 4. Filter berdasarkan Role Akses User
        if ($user->role === 'siswa') {
            $surats = $query->where('user_id', $user->id)
                ->latest()
                ->paginate(10);
        } else {
            $surats = $query->latest()
                ->paginate(10);
        }

        return view('surat.index', compact('surats', 'daftarTahunAjaran', 'tahunAjaranAktif'));
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
            'pengaju_user_id' => 'required|exists:users,id', 
        ];

        $request->validate($rules);

        // AMBIL TAHUN AJARAN YANG SEDANG AKTIF SAAT SURAT INI DIBUAT
        $tahunAjaranAktif = TahunAjaran::where('aktif', true)->first();

        $surat = Surat::create([
            'user_id' => $request->pengaju_user_id, 
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
            'tahun_ajaran_id' => $tahunAjaranAktif ? $tahunAjaranAktif->id : null, // KUNCI DI SINI
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

    private function cekAksesWaka()
    {
        if (auth()->user()->role !== 'waka') {
            abort(403, 'Hanya Waka yang dapat melakukan aksi ini.');
        }
    }

    private function generateKodeSurat(Surat $surat)
    {
        $tahunAjaranAktif = TahunAjaran::where('aktif', true)->first();

        if (!$tahunAjaranAktif) {
            $tahun = date('Y');
            $jumlahSuratSelesai = Surat::whereYear('created_at', $tahun)
                ->whereNotNull('kode_surat')
                ->count() + 1;
        } else {
            // Hitung surat berdasarkan ID Tahun Ajaran aktif (Bukan berdasarkan range tanggal lagi)
            $jumlahSuratSelesai = Surat::whereNotNull('kode_surat')
                ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
                ->count() + 1;

            $tahun = str_replace('/', '-', $tahunAjaranAktif->tahun);
        }

        $nomorUrut = str_pad($jumlahSuratSelesai, 3, '0', STR_PAD_LEFT);
        $semesterCode = $tahunAjaranAktif ? '/SMT' . $tahunAjaranAktif->semester : '';

        return $nomorUrut . '/SMA-MUH2/AKD' . $semesterCode . '/' . $tahun;
    }
}