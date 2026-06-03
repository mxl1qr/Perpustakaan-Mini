<?php

namespace App\Http\Controllers;

use App\Models\DendaSetting;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class DendaController extends Controller
{
    public function index()
    {
        // Daftar denda aktif
        $dendaAktif = Peminjaman::where('status', 'terlambat')
                                ->with(['buku', 'anggota'])
                                ->orderByDesc('denda')
                                ->get();

        // Denda yang sudah diselesaikan
        $dendaLunas = Peminjaman::where('status', 'dikembalikan')
                                ->where('denda', '>', 0)
                                ->with(['buku', 'anggota'])
                                ->orderByDesc('tgl_kembali_aktual')
                                ->get();

        $totalDendaAktif = $dendaAktif->sum('denda');
        $totalDendaLunas = $dendaLunas->sum('denda');
        $totalDendaAll   = $totalDendaAktif + $totalDendaLunas;

        $settings = DendaSetting::all()->keyBy('key');

        return view('denda.index', compact(
            'dendaAktif', 'dendaLunas',
            'totalDendaAktif', 'totalDendaLunas', 'totalDendaAll',
            'settings'
        ));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'tarif_per_hari' => 'required|integer|min:0',
            'toleransi_hari' => 'required|integer|min:0',
            'denda_maksimal'  => 'required|integer|min:0',
        ]);

        DendaSetting::where('key', 'tarif_per_hari')->update(['value' => $request->tarif_per_hari]);
        DendaSetting::where('key', 'toleransi_hari')->update(['value' => $request->toleransi_hari]);
        DendaSetting::where('key', 'denda_maksimal')->update(['value' => $request->denda_maksimal]);

        return redirect()->route('denda.index')->with('success', 'Pengaturan denda berhasil diperbarui!');
    }

    /**
     * Tandai denda sebagai lunas — ubah status 'terlambat' → 'dikembalikan'
     */
    public function lunaskan(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'terlambat') {
            return redirect()->route('denda.index')
                ->with('error', 'Transaksi ini tidak memiliki denda aktif yang perlu dilunasi.');
        }

        $peminjaman->status = 'dikembalikan';
        $peminjaman->save();

        return redirect()->route('denda.index')
            ->with('success', 'Denda Rp ' . number_format($peminjaman->denda, 0, ',', '.') . ' atas nama ' . $peminjaman->anggota->nama . ' berhasil dilunasi!');
    }
}