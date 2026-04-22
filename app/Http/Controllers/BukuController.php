<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Index - Menampilkan semua data buku
     * Dipanggil saat: GET /buku
     */
    public function index()
    {
        // Ambil semua data dari tabel buku, urutkan terbaru di atas
        $bukus = Buku::latest()->get();

        // Kirim data ke view resources/views/buku/index.blade.php
        return view('buku.index', compact('bukus'));
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
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer|digits:4',
            'stok' => 'required|integer|min:0',
        ]);

        // Simpan ke DB pakai mass assignment
        Buku::create($request->only(['judul', 'pengarang', 'tahun_terbit', 'stok']));

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
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer|digits:4',
            'stok' => 'required|integer|min:0',
        ]);

        $buku->update($request->only(['judul', 'pengarang', 'tahun_terbit', 'stok']));

        return redirect()->route('buku.index')
                         ->with('success', 'Data buku berhasil diperbarui!');
    }

    /**
     * Destroy - Menghapus data buku dari database
     * Dipanggil saat: DELETE /buku/{id}
     */
    public function destroy(string $id)
    {
        $buku->delete();

        return redirect()->route('buku.index')
                         ->with('success', 'Buku berhasil dihapus!');
    }
}
