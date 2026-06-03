<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    /**
     * Index - Menampilkan semua data buku
     * Dipanggil saat: GET /buku
     */
    public function index()
    {
        $totalBuku = Buku::count();
        $bukuBaru = Buku::whereMonth('created_at', now()->month)
                        ->whereYear('created_at', now()->year)
                        ->count();
        
        $kategoris = \App\Models\Kategori::all();

        // Ambil semua data dari tabel buku beserta relasi kategori, urutkan terbaru di atas
        $bukus = Buku::with('kategori')->latest()->paginate(15);

        // Kirim data ke view resources/views/buku/index.blade.php
        return view('buku.index', compact('bukus', 'totalBuku', 'bukuBaru', 'kategoris'));
    }

    /**
     * Create - Menampilkan form tambah buku
     * Dipanggil saat: GET /buku/create
     */
    public function create()
    {
        return view('buku.create');
    }

    /**
     * Store - Menyimpan data buku baru ke DB
     * Dipanggil saat: POST /buku
     */
    public function store(Request $request)
    {
        // Validasi input form sebelum disimpan
        $request->validate([
            'judul'        => 'required|string|max:255',
            'penulis'      => 'required|string|max:255',
            'penerbit'     => 'required|string|max:255',
            'isbn'         => 'nullable|string|max:20|unique:bukus,isbn',
            'deskripsi'    => 'nullable|string',
            'kategori_id'  => 'nullable|exists:kategoris,id',
            'tahun_terbit' => 'required|integer|digits:4',
            'stok'         => 'required|integer|min:0',
            'cover'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $data = $request->only(['judul', 'penulis', 'penerbit', 'isbn', 'deskripsi', 'kategori_id', 'tahun_terbit', 'stok']);

        // Handle upload cover
        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        // Simpan ke DB
        Buku::create($data);

        // Redirect ke halaman daftar buku dengan flash message sukses
        return redirect()->route('buku.index')
                         ->with('success', 'Buku berhasil ditambahkan!');
    }

    /**
     * Edit - Nampilin form edit buku
     * Dipanggil saat: GET /buku/{id}/edit
     */
    public function edit(Buku $buku)
    {
        // Laravel otomatis cari data berdasarkan id (Route Model Binding)
        return view('buku.edit', compact('buku'));
    }

    /**
     * Update - Menyimpan perubahan data buku ke DB
     * Dipanggil saat: PUT /buku/{id}
     */
    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'judul'        => 'required|string|max:255',
            'penulis'      => 'required|string|max:255',
            'penerbit'     => 'required|string|max:255',
            'isbn'         => 'nullable|string|max:20|unique:bukus,isbn,' . $buku->id,
            'deskripsi'    => 'nullable|string',
            'kategori_id'  => 'nullable|exists:kategoris,id',
            'tahun_terbit' => 'required|integer|digits:4',
            'stok'         => 'required|integer|min:0',
            'cover'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $data = $request->only(['judul', 'penulis', 'penerbit', 'isbn', 'deskripsi', 'kategori_id', 'tahun_terbit', 'stok']);

        // Handle upload cover
        if ($request->hasFile('cover')) {
            // Hapus cover lama jika ada
            if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
                Storage::disk('public')->delete($buku->cover);
            }
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $buku->update($data);

        return redirect()->route('buku.index')
                         ->with('success', 'Data buku berhasil diperbarui!');
    }

    /**
     * Destroy - Menghapus data buku dari database
     * Dipanggil saat: DELETE /buku/{id}
     */
    public function destroy(Buku $buku)
    {
        $buku->delete();

        return redirect()->route('buku.index')
                         ->with('success', 'Buku berhasil dihapus!');
    }
}
