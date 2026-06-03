<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;

class LaporanController extends Controller
{
    public function index()
    {
        // Statistik peminjaman keseluruhan
        $totalSemuaPeminjaman = Peminjaman::count();
        $totalDipinjam        = Peminjaman::where('status', 'dipinjam')->count();
        $totalDikembalikan    = Peminjaman::where('status', 'dikembalikan')->count();
        $totalTerlambat       = Peminjaman::where('status', 'terlambat')->count();
        $totalDendaAll        = Peminjaman::sum('denda');

        // Bulan ini
        $bulanIniPinjam   = Peminjaman::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        $bulanIniKembali  = Peminjaman::where('status', 'dikembalikan')->whereMonth('tgl_kembali_aktual', now()->month)->whereYear('tgl_kembali_aktual', now()->year)->count();
        $bulanIniDenda    = Peminjaman::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('denda');

        // 10 buku terpopuler
        $bukuPopuler = Buku::withCount('peminjaman')
                           ->orderByDesc('peminjaman_count')
                           ->take(10)->get();

        // Chart 6 bulan terakhir
        $chartLabels = $chartPinjam = $chartKembali = $chartLambat = [];
        for ($i = 5; $i >= 0; $i--) {
            $d = now()->subMonths($i);
            $chartLabels[] = $d->format('M Y');
            $chartPinjam[] = Peminjaman::whereMonth('created_at', $d->month)->whereYear('created_at', $d->year)->count();
            $chartKembali[] = Peminjaman::whereMonth('tgl_kembali_aktual', $d->month)->whereYear('tgl_kembali_aktual', $d->year)->whereNotNull('tgl_kembali_aktual')->count();
            $chartLambat[]  = Peminjaman::whereMonth('created_at', $d->month)->whereYear('created_at', $d->year)->where('status', 'terlambat')->count();
        }

        return view('laporan.index', compact(
            'totalSemuaPeminjaman', 'totalDipinjam', 'totalDikembalikan',
            'totalTerlambat', 'totalDendaAll',
            'bulanIniPinjam', 'bulanIniKembali', 'bulanIniDenda',
            'bukuPopuler',
            'chartLabels', 'chartPinjam', 'chartKembali', 'chartLambat'
        ));
    }

    /**
     * Halaman cetak/PDF rekap seluruh transaksi peminjaman.
     * Dioptimalkan untuk browser print → Save as PDF.
     */
    public function cetakTransaksi()
    {
        $transaksi = Peminjaman::with(['buku', 'anggota'])
                               ->latest()
                               ->get();

        $stats = [
            'total'        => $transaksi->count(),
            'dipinjam'     => $transaksi->where('status', 'dipinjam')->count(),
            'dikembalikan' => $transaksi->where('status', 'dikembalikan')->count(),
            'terlambat'    => $transaksi->where('status', 'terlambat')->count(),
            'total_denda'  => $transaksi->sum('denda'),
        ];

        return view('laporan.cetak-transaksi', compact('transaksi', 'stats'));
    }

    /**
     * Halaman cetak/PDF rekap denda siswa.
     */
    public function cetakDenda()
    {
        $dendaList = Peminjaman::with(['buku', 'anggota'])
                               ->where('denda', '>', 0)
                               ->latest()
                               ->get();

        $totalDenda = $dendaList->sum('denda');

        return view('laporan.cetak-denda', compact('dendaList', 'totalDenda'));
    }
}
