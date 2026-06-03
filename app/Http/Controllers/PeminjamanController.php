<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    // Tampilkan daftar semua peminjaman
    public function index()
    {
        $peminjamans = Peminjaman::with(['buku', 'anggota'])
            ->latest()
            ->get();
        $bukus    = Buku::where('stok', '>', 0)->orderBy('judul')->get();
        $anggotas = Anggota::orderBy('nama')->get();
        return view('peminjaman.index', compact('peminjamans', 'bukus', 'anggotas'));
    }

    // Tampilkan form tambah peminjaman
    public function create()
    {
        $bukus    = Buku::where('stok', '>', 0)->get(); // Hanya buku yang masih ada stok
        $anggotas = Anggota::all();
        return view('peminjaman.create', compact('bukus', 'anggotas'));
    }

    // Simpan data peminjaman baru
    public function store(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'anggota_id'         => 'required|exists:anggotas,id',
            'buku_id'            => 'required|exists:bukus,id',
            'tgl_kembali_rencana'=> 'required|date|after:today',
        ]);

        // 2. Cek stok buku
        $buku = Buku::findOrFail($request->buku_id);
        if ($buku->stok <= 0) {
            return back()->with('error', 'Stok buku habis!');
        }

        // 3. Simpan peminjaman
        Peminjaman::create([
            'anggota_id'          => $request->anggota_id,
            'buku_id'             => $request->buku_id,
            'tgl_pinjam'          => now()->toDateString(),
            'tgl_kembali_rencana' => $request->tgl_kembali_rencana,
            'status'              => 'dipinjam',
        ]);

        // 4. Kurangi stok buku
        $buku->decrement('stok');

        return redirect()->route('peminjaman.index')
                         ->with('success', 'Buku berhasil dipinjam!');
    }

    // Proses pengembalian buku — method terpisah sesuai jobsheet
    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $peminjaman->tgl_kembali_aktual = now()->toDateString();
        $terlambat = now()->diffInDays($peminjaman->tgl_kembali_rencana, false);

        // Hitung denda dari pengaturan
        $dendaPerHari  = (int) \App\Models\DendaSetting::get('tarif_per_hari', 1000);
        $toleransi     = (int) \App\Models\DendaSetting::get('toleransi_hari', 0);
        $dendaMaksimal = (int) \App\Models\DendaSetting::get('denda_maksimal', 0);

        $hariTerlambat = $terlambat < 0 ? abs($terlambat) : 0;
        $hariDikenakan = max(0, $hariTerlambat - $toleransi);
        $totalDenda    = $hariDikenakan * $dendaPerHari;

        if ($dendaMaksimal > 0) {
            $totalDenda = min($totalDenda, $dendaMaksimal);
        }

        $peminjaman->denda  = $totalDenda;
        $peminjaman->status = $totalDenda > 0 ? 'terlambat' : 'dikembalikan';
        $peminjaman->save();

        // Kembalikan stok buku
        $peminjaman->buku()->increment('stok');

        return redirect()->route('peminjaman.index')
                         ->with('success', 'Buku berhasil dikembalikan.' .
                             ($totalDenda > 0 ? ' Denda: Rp ' . number_format($totalDenda, 0, ',', '.') : ''));
     }

     // Setujui permintaan peminjaman dari siswa
     public function setujui($id)
     {
         $peminjaman = Peminjaman::findOrFail($id);

         if ($peminjaman->status !== 'diajukan') {
             return back()->with('error', 'Transaksi ini tidak sedang menunggu validasi.');
         }

         $buku = $peminjaman->buku;
         if ($buku->stok <= 0) {
             return back()->with('error', 'Stok buku ini sedang habis. Tidak dapat menyetujui peminjaman.');
         }

         \Illuminate\Support\Facades\DB::transaction(function () use ($peminjaman, $buku) {
             $peminjaman->update([
                 'status' => 'dipinjam',
                 'tgl_pinjam' => now()->toDateString(),
                 'tgl_kembali_rencana' => now()->addDays(14)->toDateString(),
                 'anggota_notified' => false,
             ]);
             $buku->decrement('stok');
         });

         return back()->with('success', 'Permintaan peminjaman buku "' . $buku->judul . '" berhasil disetujui.');
     }

     // Tolak permintaan peminjaman dari siswa
     public function tolak($id)
     {
         $peminjaman = Peminjaman::findOrFail($id);

         if ($peminjaman->status !== 'diajukan') {
             return back()->with('error', 'Transaksi ini tidak sedang menunggu validasi.');
         }

         $peminjaman->delete();

         return back()->with('success', 'Permintaan peminjaman berhasil ditolak.');
     }

     /**
      * JSON endpoint untuk polling notifikasi realtime di header admin.
      */
     public function pendingNotifications()
     {
         $pending = Peminjaman::where('status', 'diajukan')
             ->with(['anggota:id,nama,kelas', 'buku:id,judul'])
             ->latest()
             ->take(10)
             ->get()
             ->map(fn($p) => [
                 'id'          => $p->id,
                 'anggota'     => $p->anggota?->nama ?? 'N/A',
                 'kelas'       => $p->anggota?->kelas ?? '',
                 'buku'        => $p->buku?->judul ?? 'N/A',
                 'waktu'       => $p->created_at->diffForHumans(),
                 'url'         => route('peminjaman.index'),
             ]);

         return response()->json([
             'count' => $pending->count(),
             'items' => $pending,
         ]);
     }
}
