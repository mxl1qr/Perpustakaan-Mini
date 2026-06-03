<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Anggota;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnggotaPortalController extends Controller
{
    /**
     * Menampilkan halaman beranda/dashboard anggota
     */
    public function index()
    {
        $user    = Auth::user();
        $anggota = $this->getAnggota($user);
        
        $peminjamanAktif = 0;
        $totalRiwayat = 0;
        $dendaTertunggak = 0;
        $notifikasiPeminjaman = collect();

        if ($anggota) {
            $peminjamanAktif = Peminjaman::where('anggota_id', $anggota->id)
                                         ->where('status', 'dipinjam')
                                         ->count();
                                         
            $totalRiwayat = Peminjaman::where('anggota_id', $anggota->id)->count();
            
            // Hitung denda yang sudah tercatat
            $dendaSelesai = Peminjaman::where('anggota_id', $anggota->id)
                                      ->whereIn('status', ['dikembalikan', 'terlambat'])
                                      ->sum('denda');
                                      
            // Hitung potensi denda berjalan
            $potensiDenda = 0;
            $peminjamanBerjalanTerlambat = Peminjaman::where('anggota_id', $anggota->id)
                                                    ->where('status', 'dipinjam')
                                                    ->where('tgl_kembali_rencana', '<', now()->toDateString())
                                                    ->get();
            foreach ($peminjamanBerjalanTerlambat as $p) {
                $hariTerlambat = now()->diffInDays($p->tgl_kembali_rencana, false);
                if ($hariTerlambat < 0) {
                    $potensiDenda += abs($hariTerlambat) * 1000;
                }
            }

            $dendaTertunggak = $dendaSelesai + $potensiDenda;

            // Ambil peminjaman yang baru disetujui admin
            $notifikasiPeminjaman = Peminjaman::with('buku')
                                         ->where('anggota_id', $anggota->id)
                                         ->where('status', 'dipinjam')
                                         ->where('anggota_notified', false)
                                         ->get();

            if ($notifikasiPeminjaman->isNotEmpty()) {
                Peminjaman::whereIn('id', $notifikasiPeminjaman->pluck('id'))
                          ->update(['anggota_notified' => true]);
            }
        }
        
        $bukuTerbaru = Buku::with('kategori')->latest()->take(4)->get();

        return view('portal.index', compact('user', 'peminjamanAktif', 'totalRiwayat', 'dendaTertunggak', 'bukuTerbaru', 'notifikasiPeminjaman'));
    }

    /**
     * Menampilkan katalog buku untuk anggota
     */
    public function katalog(Request $request)
    {
        $query = Buku::with('kategori');
        
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('penulis', 'like', '%' . $request->search . '%');
            });
        }
        
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori_id', $request->kategori);
        }
        
        $buku = $query->paginate(12)->withQueryString();
        $kategoriList = \App\Models\Kategori::all();
        
        return view('portal.katalog', compact('buku', 'kategoriList'));
    }

    /**
     * Menampilkan detail buku untuk anggota
     */
    public function showBuku($id)
    {
        $user = Auth::user();
        $buku = Buku::with('kategori')->findOrFail($id);
        $isFavorit = $user->bukuFavorit()->where('buku_id', $id)->exists();
        
        $bukuLain = Buku::where('kategori_id', $buku->kategori_id)
                        ->where('id', '!=', $buku->id)
                        ->inRandomOrder()
                        ->take(5)
                        ->get();
                        
        return view('portal.detail-buku', compact('buku', 'bukuLain', 'isFavorit'));
    }

    /**
     * Fitur Pinjam Buku (Tambah ke keranjang)
     */
    public function pinjamBuku(Request $request, $id)
    {
        $user = Auth::user();
        $anggota = $this->getAnggota($user);

        if (!$anggota) {
            return back()->with('error', 'Profil anggota tidak ditemukan. Harap hubungi pustakawan.');
        }

        $buku = Buku::findOrFail($id);

        if ($buku->stok <= 0) {
            return back()->with('error', 'Maaf, stok buku ini sedang kosong.');
        }

        // Cek apakah sedang meminjam atau sudah mengajukan buku ini
        $isAlreadyBorrowing = Peminjaman::where('anggota_id', $anggota->id)
            ->where('buku_id', $id)
            ->whereIn('status', ['diajukan', 'dipinjam'])
            ->exists();

        if ($isAlreadyBorrowing) {
            return back()->with('error', 'Anda sedang meminjam atau telah mengajukan peminjaman untuk buku ini.');
        }

        $cart = session()->get('cart', []);

        if (in_array($id, $cart)) {
            return back()->with('error', 'Buku ini sudah ada di keranjang Anda.');
        }

        // Cek total di keranjang + active borrowings
        $activeAndPendingCount = Peminjaman::where('anggota_id', $anggota->id)
            ->whereIn('status', ['diajukan', 'dipinjam'])
            ->count();

        if (count($cart) + $activeAndPendingCount >= 2) {
            return back()->with('error', 'Batas maksimal peminjaman adalah 2 buku secara bersamaan.');
        }

        // Tambah ke keranjang
        $cart[] = $id;
        session()->put('cart', $cart);

        return redirect()->route('anggota.keranjang')->with('success', 'Buku berhasil dimasukkan ke keranjang.');
    }

    /**
     * Toggle status favorit buku
     */
    public function toggleFavorit($id)
    {
        $user = Auth::user();
        $buku = Buku::findOrFail($id);
        
        $exists = $user->bukuFavorit()->where('buku_id', $id)->exists();
        
        if ($exists) {
            $user->bukuFavorit()->detach($id);
            $message = 'Buku dihapus dari favorit.';
        } else {
            $user->bukuFavorit()->attach($id);
            $message = 'Buku berhasil ditambahkan ke favorit!';
        }

        return back()->with('success', $message);
    }

    /**
     * Menampilkan daftar buku favorit anggota
     */
    public function favorit()
    {
        $user = Auth::user();
        $favorits = $user->bukuFavorit()->with('kategori')->latest()->get();
        $rekomendasi = Buku::with('kategori')->inRandomOrder()->take(5)->get();
        
        return view('portal.favorit', compact('favorits', 'rekomendasi'));
    }

    /**
     * Menampilkan keranjang buku anggota
     */
    public function keranjang()
    {
        $cart = session()->get('cart', []);
        $bukus = Buku::with('kategori')->whereIn('id', $cart)->get();
        return view('portal.keranjang', compact('bukus'));
    }

    /**
     * Menghapus buku dari keranjang
     */
    public function hapusKeranjang($id)
    {
        $cart = session()->get('cart', []);
        if (($key = array_search($id, $cart)) !== false) {
            unset($cart[$key]);
            session()->put('cart', array_values($cart));
        }
        return back()->with('success', 'Buku berhasil dihapus dari keranjang.');
    }

    /**
     * Memproses peminjaman buku dari keranjang (Checkout)
     */
    public function checkoutKeranjang()
    {
        $user = Auth::user();
        $anggota = $this->getAnggota($user);

        if (!$anggota) {
            return back()->with('error', 'Profil anggota tidak ditemukan. Harap hubungi pustakawan.');
        }

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'Keranjang Anda kosong.');
        }

        $activeAndPendingCount = Peminjaman::where('anggota_id', $anggota->id)
            ->whereIn('status', ['diajukan', 'dipinjam'])
            ->count();

        if (count($cart) + $activeAndPendingCount > 2) {
            return back()->with('error', 'Total peminjaman melebihi batas maksimal (maks. 2 buku).');
        }

        DB::transaction(function () use ($anggota, $cart) {
            foreach ($cart as $bukuId) {
                Peminjaman::create([
                    'anggota_id'          => $anggota->id,
                    'buku_id'             => $bukuId,
                    'tgl_pinjam'          => now()->toDateString(),
                    'tgl_kembali_rencana' => now()->addDays(14)->toDateString(),
                    'status'              => 'diajukan',
                    'anggota_notified'    => false,
                ]);
            }
        });

        // Kosongkan keranjang
        session()->forget('cart');

        return redirect()->route('anggota.transaksi')->with('success', 'Peminjaman berhasil diajukan! Menunggu validasi admin.');
    }

    /**
     * Menampilkan halaman transaksi (riwayat peminjaman, denda, dll)
     */
    public function transaksi()
    {
        $user    = Auth::user();
        $anggota = $this->getAnggota($user);
        
        $stats = ['total' => 0, 'diajukan' => 0, 'dipinjam' => 0, 'terlambat' => 0, 'selesai' => 0];
        $dendaStats = ['total' => 0, 'belum' => 0, 'sudah' => 0];
        $riwayat = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10);
        $rinciDenda = collect();

        if ($anggota) {
            $baseQuery = Peminjaman::where('anggota_id', $anggota->id);
            
            $stats['total']    = (clone $baseQuery)->count();
            $stats['diajukan'] = (clone $baseQuery)->where('status', 'diajukan')->count();
            $stats['dipinjam'] = (clone $baseQuery)->where('status', 'dipinjam')->count();
            
            // Terlambat = Status dipinjam tapi sudah lewat deadline
            $stats['terlambat'] = (clone $baseQuery)
                                    ->where('status', 'dipinjam')
                                    ->where('tgl_kembali_rencana', '<', now()->toDateString())
                                    ->count();
                                    
            $stats['selesai']  = (clone $baseQuery)->whereIn('status', ['dikembalikan', 'terlambat'])->count();
            
            // Hitung denda yang sudah tercatat
            $dendaSudahTercatat = (clone $baseQuery)->whereIn('status', ['dikembalikan', 'terlambat'])->sum('denda');
            
            // Hitung POTENSI denda untuk yang masih dipinjam tapi terlambat
            $peminjamanBerjalanTerlambat = (clone $baseQuery)
                                            ->where('status', 'dipinjam')
                                            ->where('tgl_kembali_rencana', '<', now()->toDateString())
                                            ->get();
            
            $potensiDenda = 0;
            foreach ($peminjamanBerjalanTerlambat as $p) {
                $hariTerlambat = now()->diffInDays($p->tgl_kembali_rencana, false);
                if ($hariTerlambat < 0) {
                    $potensiDenda += abs($hariTerlambat) * 1000;
                }
            }

            $dendaStats['total'] = $dendaSudahTercatat + $potensiDenda;
            $dendaStats['belum'] = $potensiDenda;
            $dendaStats['sudah'] = $dendaSudahTercatat;

            $riwayat = Peminjaman::with('buku')
                                 ->where('anggota_id', $anggota->id)
                                 ->latest()
                                 ->paginate(10);

            // Rincian denda
            $rinciDenda = Peminjaman::with('buku')
                                    ->where('anggota_id', $anggota->id)
                                    ->where(function($q) {
                                        $q->where('denda', '>', 0)
                                          ->orWhere(function($sq) {
                                              $sq->where('status', 'dipinjam')
                                                 ->where('tgl_kembali_rencana', '<', now()->toDateString());
                                          });
                                    })
                                    ->latest()
                                    ->get()
                                    ->map(function($p) {
                                        if ($p->status === 'dipinjam' && $p->tgl_kembali_rencana->isPast()) {
                                            $p->denda = now()->diffInDays($p->tgl_kembali_rencana) * 1000;
                                        }
                                        return $p;
                                    });
        }
                             
        return view('portal.transaksi', compact('riwayat', 'stats', 'dendaStats', 'rinciDenda'));
    }

    /**
     * Halaman cetak transaksi personal anggota
     */
    public function cetakTransaksi()
    {
        $user    = Auth::user();
        $anggota = $this->getAnggota($user);

        if (!$anggota) {
            abort(404, 'Data anggota tidak ditemukan.');
        }

        $riwayat = Peminjaman::with('buku')
                             ->where('anggota_id', $anggota->id)
                             ->latest()
                             ->get();

        $totalDenda = $riwayat->sum('denda');
        
        // Tambahkan potensi denda untuk yang masih dipinjam tapi telat
        foreach ($riwayat as $p) {
            if ($p->status === 'dipinjam' && $p->tgl_kembali_rencana->isPast()) {
                $totalDenda += now()->diffInDays($p->tgl_kembali_rencana) * 1000;
            }
        }

        return view('portal.cetak-transaksi', compact('user', 'anggota', 'riwayat', 'totalDenda'));
    }

    /**
     * Helper untuk mendapatkan data anggota dari user yang login
     */
    private function getAnggota($user)
    {
        if (!$user) return null;
        return $user->anggota ?? Anggota::where('nis', $user->nisn)->first();
    }
}
