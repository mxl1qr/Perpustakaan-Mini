<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBuku    = Buku::count();
        $totalAnggota = Anggota::count();
        $dipinjam     = Peminjaman::where('status', 'dipinjam')->count();
        $totalDenda   = Peminjaman::whereMonth('created_at', now()->month)->sum('denda');
        $jumlahTerlambat = Peminjaman::where('status', 'dipinjam')
                                     ->where('tgl_kembali_rencana', '<', now())
                                     ->count();

        // Laporan peminjaman (all time)
        $totalSemuaPeminjaman = Peminjaman::count();
        $totalDikembalikan    = Peminjaman::where('status', 'dikembalikan')->count();
        $totalTerlambatAll    = Peminjaman::where('status', 'terlambat')->count();
        $totalDendaAll        = Peminjaman::sum('denda');

        // Denda aktif: yang masih terlambat / belum lunas
        $dendaAktif = Peminjaman::where('status', 'terlambat')
                                ->with(['buku', 'anggota'])
                                ->orderByDesc('denda')
                                ->get();

        // 5 buku paling populer
        $bukuPopuler = Buku::withCount('peminjaman')
                           ->orderByDesc('peminjaman_count')
                           ->take(5)->get();

        // Terlambat (dipinjam + lewat deadline)
        $terlambat = Peminjaman::where('status', 'dipinjam')
                               ->where('tgl_kembali_rencana', '<', now())
                               ->with(['buku', 'anggota'])
                               ->get();

        // 7 peminjaman terbaru
        $recentPeminjamans = Peminjaman::with(['buku', 'anggota'])
                                       ->latest()->take(7)->get();

        // Chart 6 bulan terakhir
        $chartLabels = $chartDipinjam = $chartDikembalikan = $chartTerlambat = [];
        for ($i = 5; $i >= 0; $i--) {
            $d = now()->subMonths($i);
            $chartLabels[]       = $d->format('M Y');
            $chartDipinjam[]     = Peminjaman::whereMonth('created_at', $d->month)->whereYear('created_at', $d->year)->count();
            $chartDikembalikan[] = Peminjaman::whereMonth('tgl_kembali_aktual', $d->month)->whereYear('tgl_kembali_aktual', $d->year)->whereNotNull('tgl_kembali_aktual')->count();
            $chartTerlambat[]    = Peminjaman::whereMonth('created_at', $d->month)->whereYear('created_at', $d->year)->where('status', 'terlambat')->count();
        }

        $kategoris = \App\Models\Kategori::all();
        $anggotas_all = Anggota::orderBy('nama')->get();
        $bukus_all = Buku::where('stok', '>', 0)->orderBy('judul')->get();
        $peminjamanAktif = Peminjaman::with(['buku', 'anggota'])->where('status', 'dipinjam')->get();

        return view('dashboard', compact(
            'totalBuku', 'totalAnggota', 'dipinjam', 'totalDenda',
            'jumlahTerlambat', 'bukuPopuler', 'terlambat', 'recentPeminjamans',
            'chartLabels', 'chartDipinjam', 'chartDikembalikan', 'chartTerlambat',
            'totalSemuaPeminjaman', 'totalDikembalikan', 'totalTerlambatAll',
            'totalDendaAll', 'dendaAktif', 'kategoris', 'anggotas_all', 'bukus_all', 'peminjamanAktif'
        ));
    }
}
